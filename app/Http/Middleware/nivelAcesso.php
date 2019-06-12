<?php

namespace serranatural\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class nivelAcesso
{

    public function handle($request, Closure $next, $one, $two)
        {

            $return = [
            'msg_retorno' => 'Você não tem acesso a essa funcionalidade',
            'tipo_retorno' => 'danger'
            ];

            if (\Auth::user()->user_type == $one or \Auth::user()->user_type == $two) {
            
                return $next($request);
            
        }
            return redirect('/admin')->with($return);
        }

}

