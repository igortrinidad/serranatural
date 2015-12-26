<?php

namespace serranatural\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class nivelAcesso
{

    public function handle($request, Closure $next, $tipoUsuario)
        {

            $return = [
            'msg_retorno' => 'Você não tem acesso a essa funcionalidade',
            'tipo_retorno' => 'danger'
            ];

            if (\Auth::user()->user_type <> $tipoUsuario) {
                
            return redirect('/admin')->with($return);
        }
        return $next($request);
        }

}

