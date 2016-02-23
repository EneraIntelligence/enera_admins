<?php

namespace Admins\Http\Controllers;

use Admins\Client;
use Illuminate\Http\Request;

use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;
use Admins;
use Admins\Administrator;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('admin.clients.index',['clients' => $clients] );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::where('_id', $id)->first();
        return view('admin.clients.show',['client' => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {

        $clients = Client::where('name', 'like', '%'.\Input::get('search').'%')
                         ->orWhere('billing_information.business_name', 'like', '%'.\Input::get('search').'%')
                         ->orWhere('billing_information.rfc', 'like', '%'.\Input::get('search').'%')
                         ->orWhere('billing_information.address', 'like', '%'.\Input::get('search').'%')
                         ->get();
        return view('admin.clients.index',['clients' => $clients] );
    }

}
