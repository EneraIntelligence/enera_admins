<?php

namespace Admins\Http\Controllers;

use Admins\Http\Requests;
use Input;
use Mail;
use Admins\MassiveMailList;
use Validator;
//use Admins\Http\Controllers\Controller;
use Admins\User;

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
//        echo 'index';
//        $campañas = Campaign::where('interaction.name','mailing_list')->where('status','ended')->get();
        $lists = MassiveMailList::where('status', 'active')->get();
//        dd($lists);
        return view('massivemail.index', ['lists' => $lists]);
    }

    public function newList()
    {
        return view('massivemail.newlist');
    }

    public function createList()
    {
        echo 'se creara la lista';
//        dd(Input::all());
        $validator = Validator::make(Input::all(), [
            'nombre' => array('regex:[^([a-zA-Z ñáéíóú]{2,60})$]'),
            'male' => array('regex:[^([a-zA-Z ñáéíóú]{2,60})$]'),
            'edad' => 'required'
        ]);
//        dd($validator);
        //     despues de las validaciones
        if ($validator->passes()) {
//            dd(Input::all());

        }
    }

    public function slectedMail()
    {

    }

    public function sendMail()
    {
        Mail::send('mail.axa', ['data' => ''], function ($message) {
            $message->from('notificacion@enera.mx', 'Enera Intelligence');
            $message->to('aavalos@enera.mx', 'angel avalos')->subject('Maling Enera Intelligence');
        });
    }

    public function unSubscribe($email = 'default')
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//            echo 'es post <br>';
//            dd(Input::all());
            $email = Input::get('email');
            $validator = Validator::make(Input::all(), [
                'email' => 'required|email|min:6|max:250',
                'motivo' => 'required'
            ]);
            if ($validator->passes()) {
                /*if (Input::get('motivo') == 'otro') {
                }*/
//                $email = Input::get('email');
                $user = User::where('facebook.email', $email)->first();
                if ($user != null && count($user) > 0) {

                    if(Input::get('motivo')!='otro'){
                        $motivo = Input::get('motivo');
//                        echo Input::get('motivo');
                    }else{
                        $motivo = Input::get('motivo2');
//                        echo Input::get('motivo2');
                    }
                    $user->massivemail = ['accept' => false, 'reason'=> $motivo];
                    $user->save();
//                    dd($user);
                    return view('massivemail.unsubscribeok', ['ok' => 'true', 'email' => '']);
                } else {
                    return view('massivemail.unsubscribeok', ['ok' => 'false', 'email' => '']);
                }
//                dd($user);
            } else {//fin del if validator
//                echo 'error <br>';
                return view('massivemail.unsubscribeok', ['ok' => 'false', 'email' => '']);
//                dd(Input::all());
            } //fin del if validator

        } else {
            return view('massivemail.unsubscribe', ['email' => $email]);
        }
    }
}
