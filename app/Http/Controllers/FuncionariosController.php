<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;
use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Funcionario;

class FuncionariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('adm.funcionarios.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Funcionario::create($request->all());

        $dados = [
            'msg_retorno' => 'Funcionario adicionado com sucesso',
            'tipo_retorno' => 'success'
        ];

        return back()->with($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('adm.funcionarios.detalhes');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funcionario = Funcionario::find($id);

        $dados = [
            'funcionario' => $funcionario
        ];

        return view('adm.funcionarios.edita')->with($dados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function funcionariosForSelect()
    {
        $funcionarios = \serranatural\Models\Funcionario::all();
        $result = array();

        foreach($funcionarios as $key => $value) 
        {
            $result[$value->id] = $value->nome;
        }

        return $result;
    }

    public function lista()
    {
        $funcionarios = Funcionario::all();

        $dados = [
            'funcionarios' => $funcionarios,
        ];

        return view('adm.funcionarios.lista')->with($dados);
    }
}
