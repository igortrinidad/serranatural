<?php

namespace serranatural\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;
use serranatural\Models\Produto;
use serranatural\Models\Fornecedor;


class ReceitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function addIngrediente(Request $request)
    {

        $prato = Pratos::find($request->prato_id);

        $prato->produtos()->attach($request->produtos_id, ['quantidade' => $request->quantidade, 'unidade' => $request->unidade]);

        return redirect()->back();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function excluiIngrediente($produto, $prato)
    {

        $prato = Pratos::find($prato);

        $prato->produtos()->detach($produto);

        $return =
        [
            'msg_retorno' => 'Produto excluido do prato com sucesso.',
            'tipo_retorno' => 'info',
        ];

        return redirect()->back()->with($return);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function storeIngrediente(Request $request)
    {

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

    public function dateRange(Request $request)
    {

        $quantidade = $request->quantidade;

        $agendados = AgendaPratos::whereBetween('dataStamp', array($request->dataInicio, $request->dataFim))
                                ->lists('pratos_id');

        $pratos = Pratos::with('produtos', 'agendaPratos')
                    ->whereIn('id', $agendados)
                    ->get();

        foreach ($pratos as $prato) {
            foreach ($prato->produtos as $produtos) {
                $produtos->pivot->quantidade = $quantidade * $produtos->pivot->quantidade;
            }
        }

        $return =
        [
            'pratos' => $pratos,
            'quantidadePratos' => $quantidade,
        ];

        return view('adm.produtos.prato.listaCompras')->with($return);
    }
}
