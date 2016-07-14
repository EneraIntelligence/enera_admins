<?php

namespace Admins\Http\Controllers;

use Admins\Http\Requests;
use Admins\MassiveMail;
use Auth;
use DateTime;
use DB;
use Input;
use Mail;
use Admins\MassiveMailList;
use MongoDate;
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

        if ($validator->passes()) {
            $user = Auth::user();
            $gender = Input::get('gender');
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

    public function newMail()
    {
//        echo Input::get('id');
        return view('massivemail.newmail', ['id' => Input::get('id'), 'name' => Input::get('name')]);
    }

    public function createMail()
    {
        echo 'entro a crear correo';
//        dd(Input::all());
        $validator = Validator::make(Input::all(), [
            'name' => array('regex:[^([a-zA-Z ñáéíóú]{2,60})$]'),
            'sender_mail' => 'required|email|min:6|max:250',
            'sender_name' => 'required|min:6|max:40',
            'mail_subject' => 'required|min:6|max:40',
            'mailing_content' => 'required'
        ]);

        if ($validator->passes()) {
            $list = MassiveMailList::where('_id', Input::get('list'))->first();
//            dd($list);

            /*$user = Auth::user();
            $mail = MassiveMail::create(array(
                'list_id' => Input::get('list'),
                'name' => Input::get('name'),
                'content' => [
                    'subject' => Input::get('mail_subject'),
                    'html' => Input::get('mailing_content'),
                ],
                'sender' => [
                    'email' => Input::get('sender_mail'),
                    'name' => Input::get('sender_name')
                ],
                'administrator_id' => $user['_id'],
                'sent' => new MongoDate(),
                'analytics' => []
            ));*/

            $genero = $list['filters']['gender'];
//            dd($genero);
            /*******         OBTENER LOS CORREOS Y NOMBRES DE LOS USUARIOS       ***************/
            $collection = DB::getMongoDB()->selectCollection('users');
            $users = $collection->aggregate([
                [
                    '$match' => [
                        'facebook.email' => ['$exists' => true],
                        'massive_mail.accept' => ['$ne' => "false"],
                        'facebook.gender' => ['$in' => $genero],
                    ]
                ],
                [
                    '$group' => [
                        '_id' => [
                            'email' => '$facebook.email',
                            'name' => '$facebook.name'
                        ]
                    ]
                ],
                [
                    '$sort' => [
                        '_id' => 1
                    ]
                ],
                [
                    '$skip' => 0
                ],
                [
                    '$limit' => 20
                ]
            ]);

            dd($users);
        }
    }

    public function sendMail($skip, $take)
    {
        /*$users = User::where('facebook.email', 'exists', 'true')->
        where('massive_mail.accept', '<>', false)->skip($skip)->take($take)->get();*/
        $users = User::where('facebook.email', 'angel17avalos@hotmail.com')->
        where('massive_mail.accept', '<>', false)->skip($skip)->take($take)->get();
        $total = 0;
        foreach ($users as $user) {
            $diff = date_diff(new DateTime($user->facebook['birthday']['date']), new Datetime());
            if ($diff->y >= 25) {
                Mail::send('mail.kitmailing_banamex', [
                    'data' => [
                        'email' => $user->facebook['email']
                    ]
                ], function ($message) use ($user) {
                    $message->from('noreply@enera.mx', 'demo mail');
                    $message->to($user->facebook['email'], $user->facebook['first_name'])->subject('Notificación de Seguridad');
                });
                $total += 1;
            }
        }
        echo $total;
    }

    public function movistar($skip, $take)
    {
        $users = User::where('facebook.email', 'exists', 'true')->
        where('massive_mail.accept', '<>', false)->skip($skip)->take($take)->get();
        /*$users = User::where('facebook.email', 'jose_asdrubal1@hotmail.com')->
        where('massive_mail.accept', '<>', false)->skip($skip)->take($take)->get();*/
        $total = 0;
        foreach ($users as $user) {
            $diff = date_diff(new DateTime($user->facebook['birthday']['date']), new Datetime());
            if ($diff->y >= 25) {
                Mail::send('mail.kitmailing_prepago', [
                    'data' => [
                        'email' => $user->facebook['email']
                    ]
                ], function ($message) use ($user) {
                    $message->from('Noreplay@movistar.com', 'Movistar');
                    $message->to($user->facebook['email'], $user->facebook['first_name'])->subject('Promoción Movistar');
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
                $user = User::where('facebook.email', $email)->first();
                if ($user != null && count($user) > 0) {
                    if (Input::get('motivo') != 'otro') {
                        $motivo = Input::get('motivo');
                    } else {
                        $motivo = Input::get('motivo2');
                    }
                    $user->massivemail = ['accept' => false, 'reason' => $motivo];
                    $user->save();
                    return view('massivemail.unsubscribeok', ['ok' => 'true', 'email' => '']);
                } else {
                    return view('massivemail.unsubscribeok', ['ok' => 'false', 'email' => '']);
                }
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
