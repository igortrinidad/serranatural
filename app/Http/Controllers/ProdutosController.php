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
use serranatural\Models\Produto;
use serranatural\Models\ReceitaPrato;

class ProdutosController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['landPratoDoDia', 'landAmanha']]);

    }

    public function criaProduto()
    {

    }


    public function mostraPrato()
    {
        $id = Request::route('id');

        $prato = Pratos::where('id', '=', $id)->first();

        $ingredientes = ReceitaPrato::where('prato_id', '=', $id)->get();


        $produtos = Produto::where('is_materiaPrima', '=', 1)->get();

        $dados = [
            'prato' => $prato,
            'produtos' => $produtos,
            'ingredientes' => $ingredientes,
        ];

        return view('adm/produtos/prato/mostra')->with($dados);

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
            'modo_preparo' => Request::input('modo_preparo'),

            ]);

        $dados = [

        'msg_retorno' => 'Prato alterado com sucesso',
        'tipo_retorno' => 'success'

        ];

        return redirect('/admin/produtos/pratos/mostra/'.$id)->with($dados);

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

        return view('adm/produtos/prato/novoPrato')->with($dados);
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

        $votosGeral = Voto::select(DB::raw('pratos_id, COUNT(*) as qtdVoto'))
             ->from('votacaoPratosDoDia')
             ->groupBY('pratos_id')
             ->orderBY('qtdVoto', 'DESC')
             ->take(5)
             ->get();

        $totalVotosGeral = DB::table('votacaoPratosDoDia')
                     ->select(DB::raw('pratos_id, COUNT(*) as total'))
                     ->from('votacaoPratosDoDia')
                     ->first();
        


        return view('adm/produtos/prato/pratosSemana')->with(
            ['pratos' => $pratos, 
            'agenda' => $agenda,
            'votos' => $votos,
            'totalVotos' => $totalVotos,
            'votosGeral' => $votosGeral,
            'totalVotosGeral' => $totalVotosGeral,
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
    public function landPratoDoDia()
    {
        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d'))
                                    ->first();

        $prato = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

        $dados = [
            'prato' => $prato,
            'data' => date('d/m/Y')
        ];

        return view('adm/produtos/prato/landPratoDoDia')->with($dados);
    }

    public function landAmanha()
    {
        $timestamp = strtotime("+1 days");
        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d', $timestamp))
                                    ->first();

        if(!is_null($pratoDoDia))
        {
            $prato = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

            $dados = [
                'prato' => $prato,
                'data' => date('d/m/Y')
        ];
            return view('adm/produtos/prato/landAmanha')->with($dados);

        } else {

            $prato = ['prato' => 'surpresa',
            'acompanhamentos' => 'surpresa'];

            $dados = [
                'prato' => $prato,
                'data' => date('d/m/Y', $timestamp)
        ];
            return view('adm/produtos/prato/landAmanha')->with($dados);

        }
        
    }
}
