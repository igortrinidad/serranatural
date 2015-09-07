<?php

namespace serranatural\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;
use Mail;

use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;
use serranatural\Models\Promocoes;
use serranatural\Models\Voto;
use serranatural\Models\Cliente;

class ProdutosController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editaPrato()
    {
        $id = Request::route('id');

        $prato = Pratos::where('id', '=', $id)->first();

        $dados = [
            'p' => $prato
        ];

        return view('adm/produtos/prato/edita')->with($dados);

    }

        public function updatePrato()
    {
        $id = Request::route('id');

        $prato = Pratos::where('id', '=', $id)
        ->update([
            'prato' => Request::input('prato'),
            'acompanhamentos' => Request::input('acompanhamento'),

            ]);

        $dados = [

        'msg_retorno' => 'Prato alterado com sucesso',
        'tipo_retorno' => 'success'

        ];

        return redirect()->action('ProdutosController@indexPrato')->with($dados);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function indexPrato()
    {

        $listaPratos = Pratos::orderBy('ativo', 'DESC')->paginate(8);

        $dados = [

            'listaPratos' => $listaPratos,

        ];

        return view('adm/produtos/novoPrato')->with($dados);
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

        return redirect()->action('ProdutosController@indexPrato')->with($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function semanaIndex()
    {
        
        $pratos = Pratos::all();

        $agenda = AgendaPratos::orderBy('dataStamp', 'ASC')->get();

        $votos = Voto::select(DB::raw('pratos_id, COUNT(*) as qtdVoto'))
                     ->from('votacaoPratosDoDia')
                     ->join('promocoes', 'votacaoPratosDoDia.promocaoID', '=', 'promocoes.id')
                     ->where('promocoes.ativo', '=', 1)
                     ->groupBY('pratos_id')
                     ->orderBY('qtdVoto', 'DESC')
                     ->take(5)
                     ->get();
        
        $totalVotos = DB::table('votacaoPratosDoDia')
                     ->select(DB::raw('pratos_id, COUNT(*) as total'))
                     ->from('votacaoPratosDoDia')
                     ->join('promocoes', 'votacaoPratosDoDia.promocaoID', '=', 'promocoes.id')
                     ->where('promocoes.ativo', '=', 1)
                     ->first();


        return view('adm/produtos/pratosSemana')->with(
            ['pratos' => $pratos, 
            'agenda' => $agenda,
            'votos' => $votos,
            'totalVotos' => $totalVotos
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function salvaPratoSemana()
    {
        $dataMysql = dataPtBrParaMysql(Request::get('dataStr'));

        $prato = AgendaPratos::create([

            'pratos_id' => Request::get('pratos_id'),
            'dataStr' => Request::get('dataStr'),
            'dataStamp' => $dataMysql,

            ]);

        $dados = [

        'msg_retorno' => 'Prato agendado para ' . Request::get('dataStr') . ' com sucesso',
        'tipo_retorno' => 'success'

        ];

        return redirect()->action('ProdutosController@semanaIndex')->with($dados);

    }

    public function addPratoSemana()
    {
        $dataMysql = dataPtBrParaMysql(Request::get('dataStr'));

        $prato = AgendaPratos::create([

            'pratos_id' => Request::route('id'),
            'dataStr' => Request::get('dataStr'),
            'dataStamp' => $dataMysql,
            ]);

        $dados = [

        'msg_retorno' => 'Prato agendado para ' . Request::get('dataStr') . ' com sucesso',
        'tipo_retorno' => 'success'

        ];

        return redirect()->action('ProdutosController@semanaIndex')->with($dados);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function ativarPrato()
    {
        $id = Request::route('id');

        $produto = Pratos::where('id', '=', $id)
                    ->update(['ativo' => 1]);

        $dados = [

        'msg_retorno' => 'Prato ativado com sucesso',
        'tipo_retorno' => 'danger',

        ];

        return redirect()->action('ProdutosController@indexPrato')->with($dados);

    }

    public function desativarPrato()
    {
        $id = Request::route('id');

        $produto = Pratos::where('id', '=', $id)
                    ->update(['ativo' => 0]);

        $dados = [

        'msg_retorno' => 'Prato desativado com sucesso',
        'tipo_retorno' => 'danger',

        ];

        return redirect()->action('ProdutosController@indexPrato')->with($dados);

    }

    public function excluiPratoSemana()

        {
        $id = Request::route('id');

        $produto = AgendaPratos::find($id)->delete();

        $dados = [

        'msg_retorno' => 'Prato excluido com sucesso',
        'tipo_retorno' => 'danger',

        ];

        return redirect()->action('ProdutosController@semanaIndex')->with($dados);

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
