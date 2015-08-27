<?php

namespace serranatural\Http\Controllers;

use Illuminate\Support\Facades\Request;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Pratos;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function formPrato()
    {
        

        return view('adm/produtos/novoPrato');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function salvaPrato()
    {
        Pratos::create(Request::all());

        $dados = [

        'msg_retorno' => 'Prato adicionado com sucesso',
        'tipo_retorno' => 'success'

        ];

        return redirect()->action('ProdutosController@formPrato')->with($dados);
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
