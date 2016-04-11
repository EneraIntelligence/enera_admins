<?php

namespace Admins\Http\Controllers;

use Admins\Administrator;
use Admins\ValidationCode;
use Hash;
use Illuminate\Http\Request;
use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;
use Input;
use Mail;
use Validator;

class AuthController extends Controller
{
    /**
     * Vista de Formulario
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth.index');
    }

    /**
     * Recepcion y comprobacion de usuario y contraseña
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        $validator = Validator::make(Input::all(), [
            'email' => 'required|email|min:6|max:250',
            'password' => 'required|alpha_num|min:8|max:16',
        ]);
        if ($validator->passes()) {
            $admin = Administrator::where('email', Input::get('email'))->first();
            if ($admin && $admin->status == 'active') {
                if (auth()->attempt(['email' => Input::get('email'), 'password' => Input::get('password'), 'status' => 'active'], Input::get('login_page_stay_signed'))) {
                    return redirect()->route('home');
                } else {
                    return redirect()->route('auth.index')->with('error', 'El correo y/o la contraseña son incorrectos.');
                }
            } elseif ($admin && $admin->status != 'active') {
                return redirect()->route('auth.index')->with('error', 'Debe validar tu cuenta antes de ingresar.');
            } else {
                return redirect()->route('auth.index')->with('error', 'El correo y/o la contraseña son incorrectos.');
            }
        } else {
            return redirect()->route('auth.index')->withErrors($validator);
        }
    }

    /**
     * Salir del sistema
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth()->logout();
        return redirect()->route('auth.index')->with('registro', 'no');
    }

    public function verify($id, $token) //verifica los codigos que llegan
    {
        $code = ValidationCode::where('token', $token)->first();// busco el codigo en la base de datos
        if ($code != null && $code->count() > 0) //si el codigo existe
        {
            echo 'el codigo existe';
            if ($code->administrator_id == $id) //verifico si el token es el mismo
            {
                echo 'si el codigo pertenece al user';
                $tipo = $code->type;
                /*** se compara que tipo de codigo es   ***/
                switch ($tipo) {
                    case 'resetPassword':
                        $data['id'] = $id;
                        $data['token'] = $token;
                        return redirect()->route('auth.newpassword')->with('data', $data);
                        break;
                    case 'validationEmail':
                        echo 'validar email';
                        $admin = Administrator::find($id);
//                        dd($admin);
                        if ($admin && $admin->status != 'active') {
                            $admin->status = 'active';   //cambio el status de pending a active
                            $admin->save();
                            /**    se agrega el historial de cuando se cambio a activo     **/
                            $admin->history()->create(array('previous_status' => 'pending'));
                            /**    se borra el validation code     **/
                            $code->delete();
                            //  se regresa al login con mensaje de que se activo cuenta
                            return redirect()->route('auth.index')->with('data', 'active');
                        } else {
                            return redirect()->route('auth.index')->with('data', 'invalido');
                        }
                        break;
                    default:
                        return redirect()->route('auth.index')->with('data', 'invalido');
                        break;
                }
            } else {
                /*echo 'codigo no valido';
                dd($code);*/
                return redirect()->route('auth.index')->with('data', 'invalido');
            }
        } else {
            return redirect()->route('auth.index')->with('data', 'invalido');
        }

    }

    public function restore()   //manda correo para recuperar contraseña
    {
        $validator = Validator::make(Input::all(), [
            'reset_password_email' => 'required|email|max:250'
        ]);
        if ($validator->passes()) {
            $admin = Administrator::where('email', Input::get('reset_password_email'))->first();
            if ($admin != null) {
                if ($admin && $admin->status == 'active') {
                    $confirmation_code = md5(Input::get('email')).date('Ymdhms');
                    $data['correo'] = $admin->email;
                    $data['nombre'] = $admin->name['first'];
                    $data['apellido'] = $admin->name['last'];
                    $data['session'] = session('_token');
                    $data['id_usuario'] = $admin->_id;
                    $data['confirmation_code'] = $confirmation_code;
                    $correo = $admin->email;
                    $nombre = $admin->name['first'];

                    $Token = ValidationCode::create(array(
                        'administrator_id' => $admin->_id, 'type' => 'resetPassword', 'token' => $confirmation_code
                    ));

                    Mail::send('emails.resetpass', ['data' => $data], function ($message) use ($correo, $nombre) {
                        $message->from('notificacion@enera.mx', 'Enera Intelligence');
                        $message->to($correo, $nombre)->subject('Recuperacion de contraseña');
                    });

                    return redirect()->route('auth.index')->with('reset_msg2', 'se a enviado un mail a tu correo: <strong>' . Input::get('reset_password_email') . '</strong> . Para restablecer la contraseña');
                } else if ($admin && $admin->status == 'pending') {
                    return redirect()->route('auth.index')->with('reset_msg2', 'la cuenta <strong>' . Input::get('reset_password_email') . '</strong> no se ha activado todavía. por favor activa tu cuenta primero ');
                }
            } else {
                return redirect()->route('auth.index')->with('reset_msg2', 'se a enviado un mail a tu correo: <strong>' . Input::get('reset_password_email') . '</strong> . Para restablecer la contraseña');
            }
        } else {
            return redirect()->route('auth.index')->withErrors($validator);
        }
    }

    public function newpassword() //vista solo valida, si no traes variables te regresa a login
    {
        $data = session('data');
        if ($data != null || session('cc') != null) {
            return view('auth.newpassword')->with('data', $data);
        } else {
            $status = 'Introduce la dirección de correo electrónico que usaste para crear la cuenta';
        }
        return redirect()->route('auth.index')->with('reset_msg', $status);
    }

    public function newpass() //post recibe la nueva contraseña y la pone
    {
        $validator = Validator::make(Input::all(), [
            'password' => 'required|alpha_num|min:8|max:16',
            'confirma_contraseña' => 'required|alpha_num|min:8|max:16',
            'u' => 'required',
            't' => 'required'
        ]);

        if ($validator->passes()) {
            $new = Hash::make(Input::get('password'));
            $admin = Administrator::where('_id', Input::get('u'))->first();
            if ($admin != null) {
                $admin->password = $new;
                $admin->save();
                /**    se agrega el historial de cuando se cambio a activo     **/
                $admin->history()->create(array('previous_status' => 'cambio de contraseña'));
                /**    se borra el validation code     **/
                $code = ValidationCode::where('token', Input::get('t'))->first();// busco el codigo en la base de datos y lo borro
                $code->delete();
                return redirect()->route('auth.index')->with('reset_msg2', 'se ha cambiado la contraseña');
            } else {
                return redirect()->route('auth.index')->with('data', 'invalido');
            }
        } else {
            return redirect()->route('auth.index')->with('data', 'invalido');
        }

    }

    public function remove()
    {
        echo Input::get('id').'<br>';
        if (Input::get('id') != null) {
            echo 'si trae datos';

            $tokens = ValidationCode::where('administrator_id', Input::get('id'))->get();// busco el codigo en la base de datos y lo borro
            foreach ($tokens as $k => $v) { //se recorre el arreglo con todos los tokens que alla creado y se borran
                $tokens[$k]->delete();
            }
//            $tokens = ValidationCode::where('administrator_id', Input::get('id'))->get();
            return redirect()->route('auth.index')->with('reset_msg2', 'tu solicitud de cancelacion se ha procesado');
        } else {
            echo 'no trae datos';
            return redirect()->route('auth.index');
        }
    }

}
