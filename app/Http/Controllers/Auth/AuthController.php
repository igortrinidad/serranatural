<?php

namespace serranatural\Http\Controllers\Auth;

use serranatural\User;
use Validator;
use serranatural\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Support\Facades\Request;
use serranatural\Http\Requests;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    protected $redirectPath = '/admin';

    protected $loginPath = '/login';


    public function __construct()
    {
        $this->middleware('guest', [

            'except' => ['getLogout', 'novoUser', 'salvaUsuario', 'editaUsuario', 'updateUsuario'],

            ]);

        $this->middleware('auth', ['only' => ['novoUser', 'editaUsuario', 'updateUsuario', 'salvaUsuario']]);
    
        $this->middleware('nivelAcesso:super_adm,two', ['only' => ['salvaUsuario', 'novoUser']]);

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function salvaUsuario()
    {

        $usuario = Request::all();
            
        User::create([
            'name' => $usuario['name'],
            'email' => $usuario['email'],
            'password' => bcrypt($usuario['password']),
            'user_type' => $usuario['user_type'],
        ]);

        $dados = [

        'msg_retorno' => 'Usuario cadastrado com sucesso',
        'tipo_retorno' => 'success'

        ];

        return redirect('/admin')->with($dados);
    }

    public function novoUser()
    {

        return view('auth/register');

    }

    protected function updateUsuario()
    {

        $usuario = Request::all();
            
        User::where('id', '=', \Auth::user()->id)
            ->update([
                'name' => $usuario['name'],
                'email' => $usuario['email'],
                'password' => bcrypt($usuario['password']),
                ]);

        $dados = [

        'msg_retorno' => 'Usuario alterado com sucesso',
        'tipo_retorno' => 'success'

        ];

        return view('adm/usuarios/config')->with($dados);
    }

    public function editaUsuario()
    {

        return view('adm/usuarios/config');
    }


}
