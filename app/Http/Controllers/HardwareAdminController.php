<?php

namespace Admins\Http\Controllers;

use Admins\AccessPoint;
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


        return view('setting.index');
        //AccessPoint::create()
        
    }

    public function show()
    {
        return view('setting.show');
    }
    
}
