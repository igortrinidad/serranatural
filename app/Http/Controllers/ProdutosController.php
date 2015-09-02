<?php

namespace serranatural\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;
use serranatural\Models\Promocoes;
use serranatural\Models\Voto;

class ProdutosController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

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
    public function semanaIndex()
    {
        
        $pratos = Pratos::all();

        $agenda = AgendaPratos::orderBy('dataStamp', 'ASC')->get();

       $votos = Voto::select(DB::raw('pratos_id, COUNT(*) as qtdVoto'))
                     ->from('votacaoPratosDoDia')
                     ->groupBY('pratos_id')
                     ->orderBY('qtdVoto', 'ASC')
                     ->take(5)
                     ->get();
        
        $totalVotos = DB::table('votacaoPratosDoDia')
                     ->select(DB::raw('pratos_id, COUNT(*) as total'))
                     ->from('votacaoPratosDoDia')
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

        'msg_retorno' => 'Prato adicionado com sucesso',
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

        'msg_retorno' => 'Prato adicionado com sucesso',
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
