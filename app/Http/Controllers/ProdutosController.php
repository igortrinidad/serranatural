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
use Input;

use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;
use serranatural\Models\Cliente;
use serranatural\Models\Produto;
use serranatural\Models\Squareproduct;
use serranatural\Models\ReceitaPrato;
use serranatural\Models\Preferencias;
use serranatural\Models\Movimentacao;
use serranatural\Models\Balanco;
use serranatural\Models\Fornecedor;

use serranatural\Http\Controllers\Square;

class ProdutosController extends Controller
{

    use Square;
    
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['landPratoDoDia', 'landPratoDoDiaCompleto', 'landAmanha']]);

    }

    public function createPrato()
    {
        return view('adm.produtos.prato.create');
    }


    public function mostraPrato($id, $quantidade = 10)
    {

        if(Input::get('quantidade')){
            $quantidade = Input::get('quantidade');
        }

        $prato = Pratos::with('produtos')->where('id', '=', $id)->first();

        $prato->total = 0;
        $prato->total_calculado = 0;

        if($prato->produtos){
            foreach ($prato->produtos as $produto) {
                $produto->custo = $produto->preco * $produto->pivot->quantidade;
                $produto->quantidade_calculado = $produto->pivot->quantidade * $quantidade;
                $produto->custo_calculado = $produto->preco * $produto->quantidade_calculado;
                $prato->total = $prato->total + $produto->custo;
                $prato->total_calculado = $prato->total_calculado + $produto->custo_calculado;
            }
        }

        $produtosForSelect = $this->produtosForSelect();

        $dados =
        [
            'prato' => $prato,
            'produtosForSelect' => $produtosForSelect,
            'quantidade' => $quantidade
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

        if (!is_null($request->file('foto')) or !empty($request->file('foto'))) {
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
    public function listaPrato()
    {

        $listaPratos = Pratos::orderBy('ativo', 'DESC')->paginate(40);

        $pratosForSelect = $this->pratosForSelect();

        $dados = [

            'listaPratos' => $listaPratos,
            'pratosForSelect' => $pratosForSelect,
        ];

        return view('adm.produtos.prato.lista')->with($dados);
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

        if (!is_null($request->file('foto')) or !empty($request->file('foto'))) {
        //Salva arquivo pagamento e seta o nome no banco.
            $nomeArquivos = $this->salvaArquivosProdutos($request->file('foto'), '_PratoID_' . $prato->id);
            $prato->foto = $nomeArquivos;
            $prato->save();
        }

        $cliente = Cliente::get();

        foreach ($cliente as $cliente) {

            Preferencias::create([

                    'clienteId' => $cliente->id,
                    'preferencias' => $prato->id
                ]);
        }

        flash()->success('Prato cadastrado com sucesso.');

        return redirect()->back();
    }

    public function destroyPrato($id)
    {
        $prato = Pratos::find($id)->delete();

        $preferencias = Preferencias::where('preferencias', '=', $id)->delete();

        return redirect('/admin/produtos/pratos/lista');
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

        $agenda = AgendaPratos::where('dataStamp', '>=', Carbon::now()->format('Y-m-d'))->orderBy('dataStamp', 'ASC')->get();
        
        $pratosForSelect = $this->pratosForSelect();

        return view('adm/produtos/prato/pratosSemana')->with(
            [
            'pratos' => $pratos,
            'agenda' => $agenda,
            'pratosForSelect' => $pratosForSelect,
            ]
        );
    }


    public function salvaPratoSemana(Request $request)
    {
        $dataMysql = dataPtBrParaMysql($request->get('dataStr'));

        $pratoAgendado = AgendaPratos::create([
            'pratos_id' => $request->get('pratos_id'),
            'dataStamp' => $dataMysql,
        ]);

        $prato = Pratos::where('id', '=', $request->get('pratos_id'))->first();


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

    public function indexQuantidadeVendaPrato()
    {
        $pratos = AgendaPratos::with('pratos')->orderBy('dataStamp', 'DESC')->get();

        return view('adm.produtos.prato.indexQuantidade', compact('pratos'));
    }

    public function alteraQuantidadeVendaPrato(Request $request)
    {
        $prato = AgendaPratos::find($request->id);

        $prato->quantidade_venda = $request->quantidade_venda;
        $prato->save();

        flash()->success('Quantidade salva com sucesso.');

        return redirect()->back();
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

        if (!is_null($pratoDoDia)) {
            $prato = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

            $dados =
            [
                'prato' => $prato,
                'data' => date('d/m/Y')
            ];
            return view('adm/produtos/prato/landPratoDoDia')->with($dados);

        } else {

            $prato = ['prato' => 'surpresa',
            'acompanhamentos' => 'surpresa'];

            $dados =
            [
                'prato' => $prato,
                'data' => date('d/m/Y')
            ];
            return view('adm/produtos/prato/landPratoDoDia')->with($dados);

        }
        
    }

    public function landPratoDoDiaCompleto()
    {
        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d'))
                                    ->first();

        if (!is_null($pratoDoDia)) {
            $prato = Pratos::with('produtos')->where('id', '=', $pratoDoDia->pratos_id)->first();

            $dados =
            [
                'prato' => $prato,
                'data' => date('d/m/Y')
            ];
            return view('adm/produtos/prato/landPratoDoDiaCompleto')->with($dados);

        } else {

            $prato = ['prato' => 'surpresa',
            'acompanhamentos' => 'surpresa'];

            $dados =
            [
                'prato' => $prato,
                'data' => date('d/m/Y')
            ];
            return view('adm/produtos/prato/landPratoDoDia')->with($dados);

        }
        
    }

    public function landAmanhaCompleto()
    {
        $timestamp = strtotime("+1 days");
        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d', $timestamp))
                                    ->first();

        if (!is_null($pratoDoDia)) {
            $prato = Pratos::with('produtos')->where('id', '=', $pratoDoDia->pratos_id)->first();

            $dados =
            [
                'prato' => $prato,
                'data' => date('d/m/Y')
            ];
            return view('adm/produtos/prato/landPratoDoDiaCompleto')->with($dados);

        } else {

            $prato = ['prato' => 'surpresa',
            'acompanhamentos' => 'surpresa'];

            $dados =
            [
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

        if (!is_null($pratoDoDia)) {
            $prato = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

            $dados =
            [
                'prato' => $prato,
                'data' => date('d/m/Y', $timestamp)
            ];
            return view('adm/produtos/prato/landAmanha')->with($dados);

        } else {

            $prato = ['prato' => 'surpresa',
            'acompanhamentos' => 'surpresa'];

            $dados =
            [
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
        $salvaArquivo = Storage::disk('produtos')->put($nomeArquivo, File::get($arquivo));

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

        foreach ($clientes as $cliente) {

            $dados =
            [
                'prato' => $prato,
                'nomeCliente' => $cliente->nome,
                'emailCliente' => $cliente->email,
                'mensagem' => $mensagem
            ];

        //dd($dados);

            Mail::queue('emails.marketing.pratoNovo', $dados, function ($message) use ($cliente, $dados) {
                $message->to($cliente->email, $cliente->nome);
                $message->from('mkt@serranatural.com', 'Serra Natural');
                $message->subject('Cardápio do dia');
                $message->getSwiftMessage();
            });

            $body = json_encode($dados);

            \serranatural\Models\LogEmail::create(
                [
                    'email' => $cliente->email,
                    'assunto' => 'Cardapio do dia',
                    'mensagem' => $body
                ]
            );

            
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

        foreach ($clientes as $key => $value) {
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

    public function cadastrarIngrediente(Request $request)
    {
        dd($request->all());
    }

    public function produtosForSelect()
    {
        $produtos = Produto::orderBy('nome_produto', 'ASC')->get();
        $result = array();

        foreach ($produtos as $key => $value) {
            $result[$value->id] = $value->id.' - '.$value->nome_produto;
        }

        return $result;
    }

    public function produtosForSelectJson($trackeds)
    {
        if($trackeds == 'trackeds') {
            $produtos = Produto::where('tracked', '=', '1')->orderBy('nome_produto', 'ASC')->get();
        } else {
            $produtos = Produto::orderBy('nome_produto', 'ASC')->all();
        }
        
        $result = array();

        foreach ($produtos as $key => $value) {
            $result[$key]['id'] = $value->id;
            $result[$key]['nome'] = $value->nome_produto;
            $result[$key]['quantidadeEstoque'] = $value->quantidadeEstoque;
            $result[$key]['quantidadeReal'] = '';
            $result[$key]['diferenca'] = '0';
        }

        return json_encode($result);
    }

    public function fornecedoresForSelect()
    {
        $fornecedores = \serranatural\Models\Fornecedor::all();
        $result = array();

        foreach ($fornecedores as $key => $value) {
            $result[$value->id] = $value->id.' - '.$value->nome;
        }

        return $result;
    }

    public function showProduto($id)
    {
        $produto = Produto::with(['categoria', 'squareproducts'])->find($id);

        $squareItemsForSelect = $this->squareItemsForSelect();

        $movimentacoes = Movimentacao::with('usuario')
            ->where('produto_id', '=', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('adm.produtos.produtos.show', compact('produto', 'movimentacoes', 'squareItemsForSelect'));
    }

    public function editProduto($id)
    {
        $produto = Produto::with(['categoria', 'fornecedores'])->find($id);
        $fornecedoresForSelect = $this->fornecedoresForSelect();
        $categories = \serranatural\Models\Categoria::all();

        foreach($categories as $key => $value) {
            $categorias[$value->id] = $value->nome;
        }

        $fornecedores = DB::table('fornecedor_produto')->where('produto_id', '=', $produto->id)->get();
        $fornecedoresSelecionados = [];
        foreach($fornecedores as $f){
             $fornecedoresSelecionados[] = $f->fornecedor_id;
        }


        return view('adm.produtos.produtos.edit', compact(
            'produto', 
            'fornecedoresForSelect', 
            'categorias',
            'fornecedoresSelecionados'
        ));
    }

    public function listaProdutos()
    {
        $produtosRastreados = Produto::with('categoria')->where('tracked', '=', '1')->orderBy('nome_produto', 'asc')->get();

        $produtosNaoRastreados = Produto::with('categoria')->where('tracked', '=', '0')->orderBy('nome_produto', 'asc')->get();

        $produtosForSelect = $this->produtosForSelect();
        
        $squareItemsForSelect = $this->squareItemsForSelect();

        return view('adm.produtos.produtos.lista', compact(
                'produtosRastreados', 
                'produtosNaoRastreados',
                'squareItemsForSelect',
                'produtosForSelect'
                ));
    }

    public function createProdutos()
    {
        $fornecedoresForSelect = $this->fornecedoresForSelect();
        $categorias = \serranatural\Models\Categoria::all();

        foreach($categorias as $key => $value) {
            $categorias[$key] = $value->nome;
        }

        return view('adm.produtos.produtos.create', compact(
            'fornecedoresForSelect', 
            'categorias'
            ));
    }

    public function storeProduto(Request $request)
    {

        $produto = Produto::create($request->all());

        if($request->fornecedor_id)
        {
            $produto->fornecedores()->sync($request->fornecedor_id);
        }

        $dados =
        [
            'msg_retorno' => 'Produto adicionado com sucesso',
            'tipo_retorno' => 'success'
        ];

        return redirect()->back()->with($dados);
    }

    public function addSquareProduct(Request $request)
    {

        Squareproduct::create([
            'square_name' => $request->square_name,
            'square_id' => $request->square_id,
            'produto_id' => $request->produto_id,
            'quantidade_por_venda' => $request->quantidade_por_venda,
        ]);

        $dados =
        [
            'msg_retorno' => 'Vinculo adicionado com sucesso',
            'tipo_retorno' => 'success'
        ];

        return redirect('/admin/produtos/show/' . $request->produto_id);

    }

    public function removeSquareProduct(Request $request)
    {


        $square = Squareproduct::where('produto_id', $request->produto_id)->where('square_id', $request->square_id)->delete();

        $dados =
        [
            'msg_retorno' => 'Vinculo removido com sucesso',
            'tipo_retorno' => 'success'
        ];

        return redirect('/admin/produtos/show/' . $request->produto_id);

    }

    public function updateProduto(Request $request, $id)
    {

        $produto = Produto::find($id);
        $produto->nome_produto = $request->nome_produto;
        $produto->descricao = $request->descricao;
        $produto->preco = $request->preco;
        $produto->is_ativo = $request->is_ativo;
        $produto->tracked = $request->tracked;
        $produto->categoria_id = $request->categoria_id;

        if($request->fornecedor_id) {
            $produto->fornecedores()->sync($request->fornecedor_id);  
        }
        $produto->save();

        if(!empty($request->square_id)){
            $square = Squareproduct::where('produto_id', $produto->id)->get();

            if($square){
                $square->quantidade_por_venda = $request->quantidade_por_venda;
                $square->save();
            } else {

                Squareproduct::create([
                    'square_name' => $request->square_name,
                    'square_id' => $request->square_id,
                    'produto_id' => $produto['id'],
                    'quantidade_por_venda' => $request->quantidade_por_venda,
                ]);
            }
        }

        return redirect(route('produtos.produtos.show', $id));
    }

    public function destroyProduto($id)
    {
        $produto = Produto::find($id);
        $produto->delete();

        flash()->success('Produto deletado com sucesso.');

        return redirect()->back();
    }

    public function baixaestoque()
    {
        return view('adm.estoque.darbaixa');
    }

    public function baixaestoquePost(Request $request)
    {

        if(is_array($request->produtos)) {
            
            foreach ($request->produtos as $produto) {

                Movimentacao::create([
                        'is_saida' => 1,
                        'obs' => $produto['motivo'],
                        'quantity' => $produto['quantidade'],
                        'produto_id' => $produto['id'],
                        'user_id' => \Auth::user()->id,
                    ]);

                $prod = Produto::find($produto['id']);
                $prod->quantidadeEstoque = $prod->quantidadeEstoque - $produto['quantidade'];
                $prod->save();

            }

            return response()->json([
                'return' => [
                    'type' => 'success',
                    'message' => 'Baixa no estoque cadastrada',
                    'status_code' => 200,
                ],
            ], 200);
        } else {
            return response()->json([
                'return' => [
                    'type' => 'error',
                    'message' => 'Produtos não chegaram no local',
                    'status_code' => 404,
                ],
            ], 404);
        }
    }

    public function entradaestoque()
    {
        return view('adm.estoque.darEntrada');
    }

    public function entradaestoquePost(Request $request)
    {

        if(is_array($request->produtos)) {
            
            foreach ($request->produtos as $produto) {

                Movimentacao::create([
                        'is_saida' => 0,
                        'is_entrada' => 1,
                        'produto_id' => $produto['id'],
                        'quantity' => $produto['quantidade'],
                        'valor' => $produto['valor'],
                        'obs' => $produto['observacao'],
                        'user_id' => \Auth::user()->id,
                    ]);

                $prod = Produto::find($produto['id']);
                $prod->quantidadeEstoque = $prod->quantidadeEstoque + $produto['quantidade'];
                $prod->save();

            }

            return response()->json([
                'return' => [
                    'type' => 'success',
                    'message' => 'Entrada no estoque cadastrada',
                    'status_code' => 200,
                ],
            ], 200);
        } else {
            return response()->json([
                'return' => [
                    'type' => 'error',
                    'message' => 'Produtos não chegaram no local',
                    'status_code' => 404,
                ],
            ], 404);
        }
    }

    public function balanco()
    {
        return view('adm.estoque.balanco');
    }

    public function balancoPost(Request $request)
    {
        if (is_array($request->listaProdutos)) {
            
            foreach ($request->listaProdutos as $produto) {

                if ($produto['diferenca'] != 0) {

                    Movimentacao::create([
                        'is_saida' => 1,
                        'motivo' => 'Diferença no estoque',
                        'quantity' => $produto['diferenca'],
                        'produto_id' => $produto['id'],
                        'user_id' => \Auth::user()->id,
                    ]);
                }

                $prod = Produto::find($produto['id']);
                $prod->quantidadeEstoque = $produto['quantidadeReal'];
                $prod->save();

            }

            DB::table('balancos')->insert([
                    'lista' => json_encode($request->listaProdutos),
                    'user_id' => \Auth::user()->id,
                    'finished' => $request->finished,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

            return response()->json([
                'return' => [
                    'type' => 'success',
                    'message' => 'Balanço de estoque realizado.',
                    'status_code' => 200,
                ],
            ], 200);
        } else {
            return response()->json([
                'return' => [
                    'type' => 'error',
                    'message' => 'Produtos não chegaram no local',
                    'status_code' => 404,
                ],
            ], 404);
        }
    }

    public function historicoBalanco()
    {
        return view('adm.estoque.historico');
    }

    public function balancosJson()
    {
        $balancos = Balanco::with('usuario')->orderBy('created_at', 'desc')->get();

        foreach($balancos as $balanco) {
            $balanco->lista = json_decode($balanco->lista);
        }

        return $balancos;
    }

    public function editProdutosDisponiveis()
    {

        $squareItems = $this->squareItemsList();

        return view('adm.produtos.produtos.available', compact(
            'squareItems'
            ));

    }

}
