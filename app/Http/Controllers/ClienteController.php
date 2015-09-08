<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Cliente;

class ClienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function lista()
    {
        $lista = Cliente::paginate(10);

        $dados = [

            'lista' => $lista

        ];

        return view('adm/clientes/lista')->with($dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function mostraCliente()
    {
        $id = Request::route('id');
        $cliente = Cliente::where('id', '=', $id);

        $dados = [
            'cliente' => $cliente,
        ];

        return view('adm/clientes/mostra')->with($dados);

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
