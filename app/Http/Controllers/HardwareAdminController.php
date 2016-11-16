<?php

namespace Admins\Http\Controllers;

use Admins\AccessPoint;
use Admins\Branche;
use Admins\Client;
use Admins\Network;
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
        $ap->location = array(floatval($request->get('lat')), floatval($request->get('lng')));
        $ap->save();

        return view('setting.index');
        //AccessPoint::create()

    }

    public function updateAPBranch(Request $request)
    {
        $this->validate($request, [
            'ap_id' => 'required',
            'branch_id' => 'required'
        ]);

        $ap = AccessPoint::where('id', $request->get('ap_id'))->first();

        if (isset($ap))
        {
            $branch = Branche::where('id', $request->get('branch_id'))->first();

            if (isset($branch))
            {
                $oldBranchId = $ap->branch_id;
                if (isset($oldBranchId))
                {
                    $this->removeAPFromBranch($ap->id, $oldBranchId);
                }

                $ap->branch_id = $request->get('branch_id');
                $ap->network_id = $branch->network_id;
                $ap->status = "active";
                $ap->save();

                if (!isset($branch->aps))
                    $branch->aps = array();
                $branch->aps[] = $ap->id;
                $branch->save();

                return "All ok";
            } else
            {
                return "Branch not found!";
            }

        } else
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

        if (isset($ap))
        {
            if (isset($ap->branch_id))
            {
                $this->removeAPFromBranch($ap->id, $ap->branch_id);
            }

            $ap->status = "pending";
            $ap->branch_id = null;
            $ap->network_id = null;
            $ap->save();

            return "all ok!";
        } else
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
        if (isset($branch->aps))
        {
            //remove ap from branch
            $index = array_search($ap_id, $branch->aps);
            if ($index > -1)
            {
                array_splice($branch->aps, $index, 1);
                $branch->save();
            }
        }
    }

    public function createBranch(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'network_id' => 'required',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'portal_image' => 'required',
            'external_ads' => 'required'
        ]);


        $network = Network::where('id',$request->get('network_id'))->first();

        if( !isset($network))
        {
            return 'Invalid network_id !';
        }


        $branch = new Branche;
        $branch->name = $request->get('name');
        $branch->network_id = $request->get('network_id');
        $branch->location = array(floatval($request->get('lat')), floatval($request->get('lng')));

        $portal = array(
            'image' => $request->get('portal_image'),
            'background' => 'none',
            'message' => array(
                'text' => 'Wifi gratis',
                'color' => '#000000'
            ),
            'session_time' => 30
        );
        $branch->portal = $portal;


        $category = array(
            "type" => "default",
            "tags" => array()
        );
        $branch->category = $category;

        $filters = array(
            'external_ads'=> $request->get('external_ads')=="yes",
            'tags_deny'=>array()
        );
        $branch->filters = $filters;
        $branch->private = false;

        $traffic = array(
            'private'=>0,
            'external'=>100
        );
        $branch->traffic = $traffic;

        $branch->aps = array();
        $branch->status = 'pending';

        $branch->save();

        return "Branch created!";
    }

    public function updateBranchStatus(Request $request)
    {
        $this->validate($request, [
            'branch_id' => 'required',
            'new_status' => 'required'
        ]);

        $branch = Branche::where('id', $request->get('branch_id'))->first();

        if(isset($branch))
        {
            $status = $request->get('new_status');

            if(
                $status=="active" ||
                $status=="pending" ||
                $status=="filed"
            )
            {
                $branch->status = $status;
                $branch->save();
                return 'All ok!';
            }
            return 'Invalid new_status!';
        }
        else
        {
            return 'Branch not found';
        }

    }

    public function createNetwork(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'client_id' => 'required',
        ]);

        $client = Client::where('id',$request->get('client_id'))->first();

        if( !isset($client))
        {
            return 'Invalid client_id !';
        }

        $network= new Network;
        $network->name = $request->get('name');
        $network->type = $request->get('type');
        $network->status = 'pending';
        $network->client_id = $request->get('client_id');
        $network->save();

        return 'All ok!';

    }

    public function updateNetworkStatus(Request $request)
    {
        $this->validate($request, [
            'network_id' => 'required',
            'new_status' => 'required'
        ]);

        $network = Network::where('id', $request->get('network_id'))->first();

        if(isset($network))
        {
            $status = $request->get('new_status');

            if(
                $status=="active" ||
                $status=="pending" ||
                $status=="filed"
            )
            {
                $network->status = $status;
                $network->save();
                return 'All ok!';
            }
            return 'Invalid new_status!';
        }
        else
        {
            return 'Network not found';
        }

    }

    public function createClient(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'business_name' => 'required',
            'rfc' => 'required',
            'address' => 'required',
            'suburb' => 'required',
            'zip_code' => 'required',
        ]);

        $client = new Client;
        $client->name = $request->get('name');
        $billing_info = array(
            'business_name'=>$request->get('business_name'),
            'rfc'=>$request->get('rfc'),
            'address'=>$request->get('address'),
            'suburb'=>$request->get('suburb'),
            'zipcode'=>$request->get('zipcode')
        );
        $client->billing_information = $billing_info;
        $client->save();

        return 'All ok!';

    }

}
