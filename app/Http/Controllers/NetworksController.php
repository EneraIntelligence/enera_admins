<?php

namespace Admins\Http\Controllers;

use Admins\Client;
use Admins\Network;
use Illuminate\Http\Request;

use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;
use Input;

class NetworksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $network = Network::where('status', 'active')->get();
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
        $network = Network::where('name', 'like', '%'. Input::get('search'). '%')
                    ->orWhere('type', 'like', '%'. Input::get('search'). '%')->get();
        return view('network.index', ['networks' => $network]);
    }

}
