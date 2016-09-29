<?php

namespace serranatural\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;
use serranatural\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use serranatural\Models\Pratos;
use serranatural\Models\Voto;
use serranatural\Models\Cliente;
use serranatural\Models\Preferencias;
use serranatural\Models\Promocoes;

class PromocoesController extends Controller
{
        public function __construct()
    {
        //$this->middleware('auth', [
//
        //    'except' => [],
//
        //    ]);
    }


    public function listPromo()
    {
        return view('adm.promocoes.list');
    }

    public function create()
    {
        return view('adm.promocoes.create');
    }
}
