<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;
use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Funcionario;

class FuncionariosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('nivelAcesso:super_adm', ['only' => ['show', 'edit']]);

    }
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
        $funcionario = Funcionario::with(['retirada'])->find($id);

        $dados = [
            'funcionario' => $funcionario,
        ];
        return view('adm.funcionarios.detalhes')->with($dados);
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
    public function update(Request $request)
    {

        $funcionario = Funcionario::find($request->id);
        $funcionario->nome = $request->nome;
        $funcionario->telefone = $request->telefone;
        $funcionario->email = $request->email;
        $funcionario->endereco = $request->endereco;
        $funcionario->horario_trabalho = $request->horario_trabalho;
        $funcionario->cargo = $request->cargo;
        $funcionario->observacoes = $request->cargo;
        $funcionario->transporte = $request->transporte;
        $funcionario->vr_transporte = $request->vr_transporte;
        $funcionario->identidade = $request->identidade;
        $funcionario->cpf = $request->cpf;
        $funcionario->vr_salario = $request->vr_salario;
        $funcionario->dt_inicio = $request->dt_inicio;
        $funcionario->foto = $request->foto;

        $funcionario->save();

        $dados = [
            'msg_retorno' => 'Funcionario editado com sucesso.',
            'tipo_retorno' => 'success',
            'funcionario' => $funcionario
        ];

        return back()->with($dados);
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
        $funcionarios = \serranatural\Models\Funcionario::with('retiradas')->all();
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
