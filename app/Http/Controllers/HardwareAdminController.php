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
                    $old_branch = Branche::where('id', $oldBranchId)->first();
                    if(isset($old_branch->aps))
                    {
                        //remove ap from old branch
                        $index = array_search($ap->id,$old_branch->aps);
                        if($index>-1)
                        {
                            array_splice($old_branch->aps, $index, 1);
                            $old_branch->save();
                        }
                    }
                }

                $ap->branch_id = $request->get('branch_id');
                $ap->network_id = $branch->network_id;
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

    public function show()
    {
        return view('setting.show');
    }
    
}
