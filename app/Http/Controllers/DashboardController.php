<?php

namespace Admins\Http\Controllers;

use Illuminate\Http\Request;

use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.index');
    }

}
