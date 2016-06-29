<?php

namespace Admins\Http\Controllers;

use Illuminate\Http\Request;

use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;
use Mail;

class MassiveMailingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Mail::send('mail.axa', ['data' => ''], function ($message) {
            $message->from('notificacion@enera.mx', 'Enera Intelligence');
            $message->to('aavalos@enera.mx', 'angel avalos')->subject('Maling Enera Intelligence');
        });
    }
}
