<?php

namespace Admins\Http\Controllers;

use Admins\Http\Requests;
use Auth;
use Input;
use Mail;
use Admins\MassiveMailList;
use Validator;
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
//        dd(Input::all());
        $validator = Validator::make(Input::all(), [
            'nombre' => array('regex:[^([a-zA-Z ñáéíóú]{2,60})$]'),
            'male' => array('regex:[^([a-zA-Z ñáéíóú]{2,60})$]'),
            'edad' => 'required'
        ]);
        //     despues de las validaciones
        if ($validator->passes()) {
            $user = Auth::user();
            $gender['male'] = Input::get('male') ? Input::get('male') : '';
            $gender['female'] = Input::get('female') ? Input::get('female') : '';
            $edad = explode(";", Input::get('edad'));

            $lista = MassiveMailList::create(array(
                'name' => Input::get('nombre'),
                'filters' => [
                    'gender' => $gender,
                    'age' => $edad
                ],
                'administrator_id' => $user['_id'],
                'status' => 'active'
            ));
//            dd($lista);
            return redirect()->route('mailing::index');
        }
    }

    public function slectedMail()
    {

    }

    public function sendMail($skipe, $take)
    {

        $users = User::where('facebook.email', 'exists', 'true')->
        where('massive_mail.accept', '<>', false)->skipe($skipe)->take($take)->get();
        $total = 0;
        foreach ($users as $user) {
            $date = strtotime($user->facebook['birthday']['date']);
            $diff = date_diff($date, date());
            if ($diff->y >= 25) {
                Mail::send('mail.axa', [
                    'data' => [
                        'email' => $user->facebook['email']
                    ]
                ], function ($message) use ($user) {
                    $message->from('noreply@axa.com', 'Seguros Axa');
                    $message->to($user->facebook['email'], $user->facebook['first_name'])->subject('Notificación de Seguridad');
                });
                $total += 1;
            }
        }
        echo $total;
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

                    if (Input::get('motivo') != 'otro') {
                        $motivo = Input::get('motivo');
//                        echo Input::get('motivo');
                    } else {
                        $motivo = Input::get('motivo2');
//                        echo Input::get('motivo2');
                    }
                    $user->massivemail = ['accept' => false, 'reason' => $motivo];
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
