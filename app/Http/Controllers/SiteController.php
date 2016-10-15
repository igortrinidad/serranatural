<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;
use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Cliente;
use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;

use Mail;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('landing/home');
    }

    public function cardapio()
    {
        return view('landing/cardapio');
    }

    public function promocoes()
    {
        return view('landing/promocoes');
    }

    public function fidelidade()
    {
        return view('landing/fidelidade');
    }

    public function contato()
    {
        return view('landing/contato');
    }
}
