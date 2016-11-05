<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\User;

class UsuarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('nivelAcesso:super_adm', ['except' => ['index']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {   
        $users = User::all();

        return view('adm.usuarios.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function mostraPerfil()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
