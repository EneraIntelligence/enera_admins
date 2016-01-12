<?php

namespace Admins\Http\Controllers;

use Admins\Administrator;
use Illuminate\Http\Request;

use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;
use Input;

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



}
