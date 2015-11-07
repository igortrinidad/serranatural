<?php

namespace serranatural\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class nivelAcesso
{

    public function handle($request, Closure $next, $tipo)
        {

            $dados = [
            'msg_retorno' => 'Você não tem acesso a essa funcionalidade',
            'tipo_retorno' => 'danger'
            ];


            if(\Auth::user()->user_type <> $tipo){
            return redirect('/admin')->with($dados);
        }
        return $next($request);
        }

}

