<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

class VotacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$mes = formatandoData(date(time()));
        //$inicioSemana = date('d');
        //$fimSemana = date('d', strtotime("+6 days"));
        //$semana = $inicioSemana . ' a ' . $fimSemana . ' de ' . $mes;
//
        //$opcoes = Opcoes::all();
//
        //$votos = DB::table('votos')
        //             ->select(DB::raw('voto, COUNT(*) as qtdVoto'))
        //             ->from('votos')
        //             ->groupBY('voto')
        //             ->orderBY('qtdVoto', 'DESC')
        //             ->get();
//
        //$totalVotos = DB::table('votos')
        //             ->select(DB::raw('voto, COUNT(*) as total'))
        //             ->from('votos')
        //             ->first();
//
        //$dados = [
//
        //'opcoes' => $opcoes,
        //'semana' => $semana,
        //'votos' => $votos,
        //'totalVotos' => $totalVotos
//
        //];

        return view('votacao/votacao');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
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
