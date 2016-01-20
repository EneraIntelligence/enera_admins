<?php

namespace Admins\Http\Controllers;

use Admins\Campaign;
use Auth;
use Illuminate\Http\Request;

use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Campaign::where('administrator_id', Auth::user()->_id)->limit(10)->get();
        $active = Campaign::where('administrator_id', Auth::user()->_id)->where('status', 'active')->count();
        $closed = Campaign::where('administrator_id', Auth::user()->_id)->where('status', 'closed')->count();
        $canceled = Campaign::where('administrator_id', Auth::user()->_id)->where('status', 'canceled')->count();
        return view('profile.index', ['user' => Auth::user(), 'all' => $all, 'active' => $active, 'closed' => $closed, 'canceled' => $canceled]);
    }

}
