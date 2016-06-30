<?php

namespace Admins\Http\Controllers;

use Illuminate\Http\Request;

use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;
use Mail;
use Admins\Campaign;

class MassiveMailingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $client = Client::where('_id', $id)->first();
        echo 'index';
        $campañas = Campaign::where('interaction.name','mailing_list');
        dd($campañas);
//            echo $massiveEmail;
    }

    public function sendMail()
    {
        Mail::send('mail.axa', ['data' => ''], function ($message) {
            $message->from('notificacion@enera.mx', 'Enera Intelligence');
            $message->to('arosas@enera.mx', 'angel avalos')->subject('Maling Enera Intelligence');
        });
    }

    public function unSubscribe()
    {
        echo 'salir';
    }
}
