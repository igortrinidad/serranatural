<?php

namespace serranatural\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use serranatural\Http\Requests;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use serranatural\Http\Controllers\Controller;
use Mail;
use Carbon\Carbon;

use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;
use serranatural\Models\Promocoes;
use serranatural\Models\Voto;
use serranatural\Models\Cliente;
use serranatural\Models\Produto;
use serranatural\Models\ReceitaPrato;
use serranatural\Models\Preferencias;

use QrCode;


class ProdutosController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['landPratoDoDia', 'landAmanha']]);

    }

    public function criaProduto()
    {

    }


    public function mostraPrato($id)
    {

        $prato = Pratos::where('id', '=', $id)->first();

        $link = 'http://www.maisbartenders.com.br/'.$prato->prato.','.date('d/m/Y');

        //$arquivo = time() .'.png';
//
        //$caminho = '../public/qrcodes/'. $arquivo;
//
        //QrCode::format('png');
        //QrCode::size(300);
        //$teste = QrCode::generate($link, $caminho);


        $ingredientes = ReceitaPrato::where('prato_id', '=', $id)->get();


        $produtos = Produto::where('is_materiaPrima', '=', 1)->get();

        $dados = [
            'prato' => $prato,
            'produtos' => $produtos,
            'ingredientes' => $ingredientes,
            //'arquivo' => $arquivo
        ];

        return view('adm/produtos/prato/mostra')->with($dados);

    }

    public function editaPrato($id)
    {

        $prato = Pratos::where('id', '=', $id)->first();

        $dados = [
            'p' => $prato
        ];

        return view('adm/produtos/prato/edita')->with($dados);

    }

        public function updatePrato(Request $request)
    {
        $id = $request->id;

        $prato = Pratos::find($id);

        $prato->prato = $request->prato;
        $prato->acompanhamentos = $request->acompanhamentos;
        $prato->modo_preparo = $request->modo_preparo;
        $prato->valor_pequeno = $request->valor_pequeno;
        $prato->valor_grande = $request->valor_grande;

        if(!is_null($request->file('foto')) OR !empty($request->file('foto')))
        {
        //Salva arquivo pagamento e seta o nome no banco.
            $nomeArquivos = $this->salvaArquivosProdutos($request->file('foto'), '_PratoID_' . $id);
            $prato->foto = $nomeArquivos;
            $prato->titulo_foto = $request->titulo_foto;
        }

        $prato->save();

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

        $pratosForSelect = $this->pratosForSelect();

        $dados = [

            'listaPratos' => $listaPratos,
            'pratosForSelect' => $pratosForSelect,

        ];

        return view('adm/produtos/prato/novoPrato')->with($dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function salvaPrato(Request $request)
    {
        $prato = Pratos::create($request->all());

        if(!is_null($request->file('foto')) OR !empty($request->file('foto')))
        {
        //Salva arquivo pagamento e seta o nome no banco.
            $nomeArquivos = $this->salvaArquivosProdutos($request->file('foto'), '_PratoID_' . $prato->id);
            $prato->foto = $nomeArquivos;
            $prato->save();
        }

        $cliente = Cliente::get();

        foreach($cliente as $cliente) {

            Preferencias::create([

                    'clienteId' => $cliente->id,
                    'preferencias' => $prato->id
                ]);
        }

        $dados = [

        'msg_retorno' => 'Prato adicionado com sucesso',
        'tipo_retorno' => 'success'

        ];

        return redirect()->action('ProdutosController@indexPrato')->with($dados);
    }

        public function destroyPrato($id)
    {

        $prato = Pratos::find($id)->delete();

        $preferencias = Preferencias::where('preferencias', '=', $id)->delete();

        $dados = [

        'msg_retorno' => 'Prato EXCLUIDO com sucesso',
        'tipo_retorno' => 'danger'

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

        $agenda = AgendaPratos::where('dataStamp', '>=', Carbon::now())->orderBy('dataStamp', 'ASC')->get();

       // $votos = Voto::select(DB::raw('pratos_id, COUNT(*) as qtdVoto'))
       //              ->from('votacaoPratosDoDia')
       //              ->join('promocoes', 'votacaoPratosDoDia.promocaoID', '=', 'promocoes.id')
       //              ->where('promocoes.ativo', '=', 1)
       //              ->groupBY('pratos_id')
       //              ->orderBY('qtdVoto', 'DESC')
       //              ->take(5)
       //              ->get();


       // $totalVotos = DB::table('votacaoPratosDoDia')
       //              ->select(DB::raw('pratos_id, COUNT(*) as total'))
       //              ->from('votacaoPratosDoDia')
       //              ->join('promocoes', 'votacaoPratosDoDia.promocaoID', '=', 'promocoes.id')
       //              ->where('promocoes.ativo', '=', 1)
       //              ->first();

       // $votosGeral = Voto::select(DB::raw('pratos_id, COUNT(*) as qtdVoto'))
       //      ->from('votacaoPratosDoDia')
       //      ->groupBY('pratos_id')
       //      ->orderBY('qtdVoto', 'DESC')
       //      ->take(5)
       //      ->get();

       // $totalVotosGeral = DB::table('votacaoPratosDoDia')
       //              ->select(DB::raw('pratos_id, COUNT(*) as total'))
       //              ->from('votacaoPratosDoDia')
       //              ->first();
        
        $pratosForSelect = $this->pratosForSelect();

        return view('adm/produtos/prato/pratosSemana')->with(
            ['pratos' => $pratos, 
            'agenda' => $agenda,
            'pratosForSelect' => $pratosForSelect,
            ]);
    }


    public function salvaPratoSemana(Request $request)
    {
        $dataMysql = dataPtBrParaMysql($request->get('dataStr'));

        $pratoAgendado = AgendaPratos::create([
            'pratos_id' => $request->get('pratos_id'),
            'dataStamp' => $dataMysql,
        ]);

        $prato = Pratos::where('id', '=', $request->get('pratos_id'))->first();

        $data = [
            'prato' => $prato,
            'nomeCliente' => 'Direção',
            'emailCliente' => 'contato@serranatural.com',
        ];

        //dd($dados);

        Mail::queue('emails.marketing.pratoNovo', $data, function ($message) use ($data)
        {

            $message->to('contato@serranatural.com', 'Serra Natural');
            $message->from('mkt@serranatural.com', 'Serra Natural');
            $message->subject('Cardápio de amanhã');
            $message->getSwiftMessage();

        });

        $dados = [

        'msg_retorno' => 'Prato agendado para ' . $request->get('dataStr') . ' com sucesso.',
        'tipo_retorno' => 'success'

        ];

        return redirect()->action('ProdutosController@semanaIndex')->with($dados);

    }

    public function addPratoSemana(Request $request)
    {
        $dataMysql = dataPtBrParaMysql($request->get('dataStr'));

        $prato = AgendaPratos::create([

            'pratos_id' => $request->route('id'),
            'dataStr' => $request->get('dataStr'),
            'dataStamp' => $dataMysql,
            ]);

        $dados = [

        'msg_retorno' => 'Prato agendado para ' . $request->get('dataStr') . ' com sucesso',
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
    public function ativarPrato(Request $request)
    {
        $id = $request->route('id');

        $produto = Pratos::where('id', '=', $id)
                    ->update(['ativo' => 1]);

        $dados = [

        'msg_retorno' => 'Prato ativado com sucesso',
        'tipo_retorno' => 'danger',

        ];

        return redirect()->action('ProdutosController@indexPrato')->with($dados);

    }

    public function desativarPrato(Request $request)
    {
        $id = $request->route('id');

        $produto = Pratos::where('id', '=', $id)
                    ->update(['ativo' => 0]);

        $dados = [

        'msg_retorno' => 'Prato desativado com sucesso',
        'tipo_retorno' => 'danger',

        ];

        return redirect()->action('ProdutosController@indexPrato')->with($dados);

    }

    public function excluiPratoSemana($id)

        {

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

        if(!is_null($pratoDoDia))
        {
            $prato = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

            $dados = [
                'prato' => $prato,
                'data' => date('d/m/Y')
        ];
            return view('adm/produtos/prato/landPratoDoDia')->with($dados);

        } else {

            $prato = ['prato' => 'surpresa',
            'acompanhamentos' => 'surpresa'];

            $dados = [
                'prato' => $prato,
                'data' => date('d/m/Y')
        ];
            return view('adm/produtos/prato/landPratoDoDia')->with($dados);

        }
        
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
                'data' => date('d/m/Y', $timestamp)
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

    public function salvaArquivosProdutos($arquivo, $prefix)
    {

        $extArquivo = $arquivo->getClientOriginalExtension();
        $nomeArquivo =  $prefix . '.' . $extArquivo;
        $salvaArquivo = Storage::disk('produtos')->put($nomeArquivo,  File::get($arquivo));

        return $nomeArquivo;

    }

    public function enviaPratoDoDia(Request $request)
    {

        $mensagem = $request->mensagem;

        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d'))
                                    ->first();

        $clientes = Cliente::where('clientes.opt_email', '=', 1)
                            ->get();

        $total = count($clientes);

        $prato = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

        set_time_limit(900);

        foreach($clientes as $cliente){

        $dados = [

        'prato' => $prato,
        'nomeCliente' => $cliente->nome,
        'emailCliente' => $cliente->email,
        'mensagem' => $mensagem

        ];

        //dd($dados);

        Mail::queue('emails.marketing.pratoNovo', $dados, function ($message) use ($cliente, $dados)
        {

            $message->to($cliente->email, $cliente->nome);
            $message->from('mkt@serranatural.com', 'Serra Natural');
            $message->subject('Cardápio do dia');
            $message->getSwiftMessage();

        });

        $body = json_encode($dados);

        \serranatural\Models\LogEmail::create([

        'email' => $cliente->email,
        'assunto' => 'Cardapio do dia',
        'mensagem' => $body

        ]);

            
        }

        $data = [
            'msg_retorno' => 'Email prato do dia enviado com sucesso para ' . $total . ' clientes',
            'tipo_retorno' => 'success',
        ];

        return back()->with($data);
    }

        public function pratosForSelect()
    {
        $clientes = Pratos::all();
        $result = array();

        foreach($clientes as $key => $value) {
            $result[$value->id] = $value->id.' - '.$value->prato . ' - ' . $value->valor_pequeno . ' - ' . $value->valor_grande;
        }

        return $result;
    }

    public function consultaPrato(Request $request)
    {
        $prato = Pratos::where('id', '=', $request->id)->first();

        $return = [
            'prato' => $prato->prato,
            'acompanhamentos' => $prato->acompanhamentos,
            'valor_pequeno' => $prato->valor_pequeno,
            'valor_grande' => $prato->valor_grande,
            'foto' => $prato->foto,
            'titulo_foto' => $prato->titulo_foto,
        ];

        return $return;
    }
}
