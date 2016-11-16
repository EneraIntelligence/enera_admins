<?php

namespace Admins\Http\Controllers;

use Admins\AccessPoint;
use Admins\Branche;
use Illuminate\Http\Request;

use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;

class HardwareAdminController extends Controller
{
    public function createAP(Request $request)
    {
        /*
        "_id" : ObjectId("5696a6a7a8262b649ab70c10"),
    "model" : "MR18",
    "mac" : "00:18:0a:7b:30:71",
    "serial_number" : "Q2GD-AQ6H-6M7B",
    "status" : "active",
    "name" : "Plaza Sendero del rio AP6",
    "network_id" : "56815cbea826c763c1998df4",
    "branch_id" : "56956b05a8262b649ab70b72",
    "location" : [
        19.456708,
        -99.122272
    ],
        */
        $this->validate($request, [
            'model' => 'required',
            'mac' => 'required|size:17',
            'serial' => 'required',
            'name' => 'required',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);


        $ap = new AccessPoint;
        $ap->model = $request->get('model');
        $ap->mac = $request->get('mac');
        $ap->serial_number = $request->get('serial');
        $ap->name = $request->get('name');
        $ap->status = "pending";
        $ap->location = array( floatval($request->get('lat')), floatval($request->get('lng')) );
        $ap->save();

        return view('setting.index');
        //AccessPoint::create()
        
    }

    public function updateAPBranch(Request $request)
    {
        $this->validate($request, [
            'ap_id' => 'required',
            'branch_id'=> 'required'
        ]);

        $ap = AccessPoint::where('id', $request->get('ap_id'))->first();

        if( isset($ap))
        {
            $branch = Branche::where('id', $request->get('branch_id'))->first();

            if(isset($branch))
            {
                $oldBranchId = $ap->branch_id;
                if(isset($oldBranchId))
                {
                    $this->removeAPFromBranch($ap->id,$oldBranchId);
                }

                $ap->branch_id = $request->get('branch_id');
                $ap->network_id = $branch->network_id;
                $ap->status = "active";
                $ap->save();

                if(!isset($branch->aps))
                    $branch->aps = array();
                $branch->aps[] = $ap->id;
                $branch->save();

                return "All ok";
            }
            else
            {
                return "Branch not found!";
            }

        }
        else
        {
            return "AP not found!";
        }

    }

    public function disableAP(Request $request)
    {
        $this->validate($request, [
            'ap_id' => 'required',
        ]);

        $ap = AccessPoint::where('id', $request->get('ap_id'))->first();

        if( isset($ap) )
        {
            if(isset($ap->branch_id))
            {
                $this->removeAPFromBranch($ap->id, $ap->branch_id);
            }

            $ap->status = "pending";
            $ap->branch_id=null;
            $ap->network_id=null;
            $ap->save();

            return "all ok!";
        }
        else
        {
            return "AP not found!";
        }
    }


    public function show()
    {
        return view('setting.show');
    }

    private function removeAPFromBranch($ap_id, $branch_id)
    {
        $branch = Branche::where('id', $branch_id)->first();
        if(isset($branch->aps))
        {
            //remove ap from branch
            $index = array_search($ap_id,$branch->aps);
            if($index>-1)
            {
                array_splice($branch->aps, $index, 1);
                $branch->save();
            }
        }
    }

}
