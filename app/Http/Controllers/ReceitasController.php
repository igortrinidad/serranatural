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

use Carbon\Carbon;

class ReceitasController extends Controller
{

    public function rangeIndex()
    {

        $pratos = Pratos::all();

        $agenda = AgendaPratos::where('dataStamp', '>=', Carbon::now()->format('Y-m-d'))->orderBy('dataStamp', 'ASC')->get();

        $return =
        [
            'pratos' => $pratos,
            'agenda' => $agenda
        ];

        return view('adm.produtos.prato.rangeData')->with($return);
    }
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

        $agendados = AgendaPratos::with('pratos')
                                ->whereBetween('dataStamp', array($request->dataInicio, $request->dataFim))
                                ->orderBy('dataStamp', 'ASC')
                                ->get();

        $teste = AgendaPratos::with(['pratos' => function($query) {
                                $query->with(['produtos' => function($query) {
                                $query->groupBy('nome_produto');
                                }]);
                                }])->whereBetween('dataStamp', array($request->dataInicio, $request->dataFim))
                                ->get();

        foreach ($agendados as $agenda) {
            foreach ($agenda->pratos->produtos as $produtos) {
                $produtos->pivot->quantidade = $quantidade * $produtos->pivot->quantidade;
            }
        }

        $produtosTotais = [];

        foreach ($agendados as $agenda) {
            foreach ($agenda->pratos->produtos as $produto) {
                if ( array_key_exists($produto->nome_produto, $produtosTotais) ) {
                    $produtosTotais[$produto->nome_produto] = $produtosTotais[$produto->nome_produto] + $produto->pivot->quantidade;
                } else {
                    $produtosTotais[$produto->nome_produto] = $produto->pivot->quantidade;
                }
                
            }
            
        }

        $return =
        [
            'agendados' => $agendados,
            'quantidadePratos' => $quantidade,
            'produtosTotais' => $produtosTotais
        ];

        return view('adm.produtos.prato.listaCompras')->with($return);
    }
}
