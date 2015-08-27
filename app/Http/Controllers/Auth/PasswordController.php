<?php

namespace serranatural\Http\Controllers\Auth;

use serranatural\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use serranatural\Http\Requests;
use Illuminate\Http\Response;
use Mail;
use serranatural\User;


class PasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function formSenha(){

        return view('auth/password');

    }



    public function resetPass()
    {

    $newPass = mt_rand (100000, 999999);

    $email = Request::get('email');

    $usuario = User::where('email', '=', $email)
                     ->first();

    $usuario->password = bcrypt($newPass);
    $usuario->save();

    $data = [

    'pass' => $newPass

    ];


    Mail::send('emails.password', $data, function ($message) use ($email, $data){

            $message->from('contato@mais.bar', 'MaIS.BAR');
            $message->to($email, 'teste');
            $message->subject('Email testado');
            $message->getSwiftMessage();
});


        return redirect()->action('Auth\AuthController@getLogin');

    }

}
