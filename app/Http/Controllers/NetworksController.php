<?php

namespace Admins\Http\Controllers;

use Admins\Client;
use Admins\Network;
use Illuminate\Http\Request;

use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;

class NetworksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $network = Network::all();
        return view('network.index', ['networks' => $network]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $network = Network::find($id);
        return view('network.show', ['network' => $network]);
    }

    public function search()
    {
        $network = Network::all();
        return view('network.index', ['networks' => $network]);
    }

}
