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

        $this->middleware('guest', [

            'except' => ['formSenha', 'novoUser', 'salvaUsuario'],

            ]);

        $this->middleware('auth', [

            'except' => ['formSenha', 'resetPass'],

            ]);
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

    if( is_null($usuario))
        {
           return redirect()->back()->withErrors(['Usuário não encontrado']); 

        } else {

        $usuario->password = bcrypt($newPass);
        $usuario->save();

        $data = [

        'pass' => $newPass

        ];


        Mail::send('emails.password', $data, function ($message) use ($email, $data){

                $message->to($email, '');
                $message->from('contato@serranatural.com', 'Serra Natural');
                $message->subject('Recuperação de senha');
                $message->getSwiftMessage();
    });


            return redirect()->action('Auth\AuthController@getLogin');

            }
    }

}
