<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;
use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Mail;
use serranatural\Models\Caixa as Caixa;
use serranatural\Models\Retirada as Retirada;
use serranatural\Models\Cliente as Cliente;
use serranatural\User as User;
use serranatural\Models\Funcionario;
use serranatural\Models\Pagamento;
use serranatural\Models\Produto;
use serranatural\Models\Movimentacao;

use Image;
use Input;

use Carbon\Carbon;

use serranatural\Http\Requests\PagamentoRequest as PagamentoRequest;

class FinanceiroController extends Controller
{
    /*
     * Seta o caminho para upload do arquivo.
     */
    private  $uploadPath = 'financeiro/pagamentos/';

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getImage']]);

        $this->middleware('nivelAcesso:super_adm,two', ['only' => ['autorizarRetirada']]);

        //$this->middleware('nivelAcesso:super_adm,two', ['only' => ['retirada']]);

    }

    public function indexFluxo()
    {

        $caixa = Caixa::with('usuarioAbertura', 'retiradas')->where('is_aberto', '=', 1)->first();

        $dados = [
            'caixa' => $caixa
        ];

        return view('adm.financeiro.fluxo')->with($dados);
    }

    public function autorizarRetirada($id)
    {

        $retirada = Retirada::find($id);
        $retirada->autorizado_por = \Auth::user()->id;
        $retirada->autorizado_quando = date('Y-m-d H:i:s');
        $retirada->save();

        flash()->success('Retirada autorizada com sucesso.');

        return redirect()->back();



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexHistorico()
    {

        $caixas = Caixa::with('usuarioFechamento', 'usuarioAbertura')->paginate(10);

        //dd($caixas);

        $dados = [
            'caixas' => $caixas,
        ];

        return view('adm.financeiro.historicoCaixa')->with($dados);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function abreCaixa(Request $request)
    {

        $autoriza = User::where('id', '=', \Auth::user()->id)
            ->where('senha_operacao', '=', $request->senha)
            ->first();

        if (is_null($autoriza) or empty($autoriza)) {
            $dados = [
                'msg_retorno' => 'Senha inválida',
                'tipo_retorno' => 'error'
            ];
            return $dados;
        }

        Caixa::create([
            'dt_abertura' => date('Y-m-d H:i:s'),
            'vr_abertura' => $request->vr_abertura,
            'is_aberto' => '1',
            'user_id_abertura' => \Auth::user()->id
        ]);

        $dados = [
            'msg_retorno' => 'Caixa Aberto!',
            'tipo_retorno' => 'success'
        ];
        return $dados;


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gravarCaixa(Request $request)
    {

        $result = Caixa::where('id', '=', $request->id)
            ->update([
                'vendas_card' => $request->vendas_card,
                'vendas_cash' => $request->vendas_cash,
                'vendas_rede' => $request->vendas_rede,
                'vendas_cielo' => $request->vendas_cielo,
                'vr_abertura' => $request->vr_abertura,
                'esperado_caixa' => $request->esperado_caixa,
                'diferenca_caixa' => $request->diferenca_caixa,
                'diferenca_cartoes' => $request->diferenca_cartoes,
                'diferenca_final' => $request->diferenca_final,
                'vr_emCaixa' => $request->vr_emCaixa,
            ]);

        $dados = [
            'msg_retorno' => 'Caixa gravado com sucesso, não esqueça de fecha-lo!',
            'tipo_retorno' => 'success'
        ];

        return $dados;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fecharCaixa(Request $request)
    {
        $autoriza = User::where('id', '=', \Auth::user()->id)
            ->where('senha_operacao', '=', $request->senha)
            ->first();

        if (is_null($autoriza) or empty($autoriza)) {
            $dados =
                [
                    'msg_retorno' => 'Senha inválida',
                    'tipo_retorno' => 'error'
                ];
            return $dados;
        }

        Caixa::where('id', '=', $request->id)
            ->update([
                'is_aberto' => 0,
                'user_id_fechamento' => \Auth::user()->id,
                'dt_fechamento' => date('Y-m-d H:i:s')
            ]);

        $caixa = Caixa::with('usuarioAbertura', 'retiradas')->where('id', '=', $request->id)->first();

        $dados = [
            'dt_abertura' => $caixa->dt_abertura->format('d/m/Y H:i:s'),
            'dt_fechamento' => $caixa->dt_fechamento->format('d/m/Y H:i:s'),
            'vendas_cash' => $caixa->vendas_cash,
            'vendas_card' => $caixa->vendas_card,
            'total_vendas' => number_format($caixa->vendas_cash + $caixa->vendas_card, 2, ',', '.'),
            'total_retirada' => $caixa->total_retirada,
            'vendas_rede' => $caixa->vendas_rede,
            'vendas_cielo' => $caixa->vendas_cielo,
            'esperado_caixa' => $caixa->esperado_caixa,
            'vr_emCaixa' => $caixa->vr_emCaixa,
            'vr_abertura' => $caixa->vr_abertura,
            'diferenca_cartoes' => $caixa->diferenca_cartoes,
            'diferenca_caixa' => $caixa->diferenca_caixa,
            'diferenca_final' => $caixa->diferenca_final,
            'user_abertura' => $caixa->usuarioAbertura->name,
            'user_fechamento' => $caixa->usuarioFechamento->name,
            'retiradas' => $caixa->retiradas,
        ];

        $email = Mail::queue('emails.admin.fechamentoCaixa', $dados, function ($message) use ($dados, $caixa) {

            $message->to('contato@maisbartenders.com.br', 'Igor Trindade');
            $message->from('mkt@serranatural.com', 'Serra Natural');
            $message->subject('Fechamento de caixa : ' . $caixa->dt_fechamento->format('d/m/Y H:i:s'));
            $message->getSwiftMessage();

        });

        $body = json_encode($dados);

        \serranatural\Models\LogEmail::create([

            'email' => 'contato@maisbartenders.com.br',
            'assunto' => 'Fechamento de caixa: ' . $caixa->dt_fechamento->format('d/m/Y H:i:s'),
            'mensagem' => $body

        ]);

        if (!$email) {
            $return = [
                'msg_retorno' => 'Ocorreu algum problema no envio do email.',
                'tipo_retorno' => 'error'
            ];

            return $return;
        }

        $return = [
            'msg_retorno' => 'Caixa fechado com sucesso, consulte o caixa em histórico.',
            'tipo_retorno' => 'success',
        ];

        return $return;
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
    public function destroyPagamento($id)
    {
        $pagamento = Pagamento::find($id);

        if (!is_null($pagamento) and $pagamento->is_liquidado == 0) {
            $pagamento->delete();

            flash()->success('Pagamento excluido com sucesso.');

            return redirect(route('admin.financeiro.aPagar'));
        }
        flash()->error('O pagamento não pode ser excluido.');

        return redirect(route('admin.financeiro.aPagar'));
    }

    public function funcionariosForSelect()
    {
        $funcionarios = \serranatural\Models\Funcionario::where('is_ativo', '=', 1)->get();
        $result = array();

        foreach ($funcionarios as $key => $value) {
            $result[$value->id] = $value->nome;
        }

        return $result;
    }

    public function retirada()
    {

        $funcionarios = $this->funcionariosForSelect();

        $usuarios = User::all();

        $dados = [
            'funcionarios' => $funcionarios,
            'usuarios' => $usuarios
        ];

        return view('adm.financeiro.retirada')->with($dados);
    }

    public function retiradaPost(Request $request)
    {

        $user = User::find($request->usuario_id);

        if($request->senha_operacao != $user->senha_operacao){
            return response()->json([
                'error' => [
                    'message' => 'Senha não confere!',
                    'status_code' => 404,
                ],
            ], 404);
        }

        $retirada = new Retirada();
        $retirada->user_id = $user->id;
        $retirada->valor = $request->valor;
        $retirada->descricao = $request->descricao;
        $retirada->tipo = $request->tipo;
        $retirada->motivo = $request->motivo;

        $retirada->fonte_pgto = $request->fontePgto;

        //dd($request->all());

        if ($request->funcionario_id >= 1) {
            $retirada->funcionario_id = $request->funcionario_id;
            if ($request->is_debito) {
                $retirada->is_debito = 1;
            }

            $retirada->init = Carbon::createFromFormat('d/m/Y', $request->init)->format('Y-m-d');
            $retirada->end = Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d');
        }

        if ($request->registraPagamento) {

            Pagamento::create([
                'user_id_cadastro' => $user->id,
                'descricao' => $request->tipo.' '.$request->descricao,
                'vencimento' => date('d/m/Y'),
                'data_pgto' => date('d/m/Y'),
                'valor' => $request->valor,
                'is_liquidado' => '1',
                'fonte_pgto' => $request->fontePgto,
                'user_id_pagamento' => \Auth::user()->id,
            ]);

        }

        $retirada->save();

        //Envia email para informar o cliente do cadastro
        $data = [];
        $data['align'] = 'center';
        $data['messageTitle'] = '<h4>Retirada no caixa de R$' . $request->valor. '</h4>';
        $data['messageOne'] = '
        <p>O usuário: ' . $user->name. ' acabou de fazer uma retirada </p>';

        $data['messageSubject'] = 'Retirada caixa: R$' . $request->valor;

        \Mail::send('emails.standart',['data' => $data], function ($message) use ($data, $request){
            $message->from('no-reply@serranatural.com', 'Serra Natural');
            $message->to('contato@maisbartenders.com.br', 'Igor Trindade')->subject($data['messageSubject']);
        });

        //dd($request->all());

        if ($request->retiradoCaixa == 1) {
            $caixa = Caixa::where('is_aberto', '=', 1)->first();

            if(!is_null($caixa) or !empty($caixa)) {
                $retirada->retirado_caixa = $request->retiradoCaixa;
                $retirada->caixa_id = $caixa->id;
                $retirada->save();
                $totalRetirada = Retirada::where('caixa_id', '=', $caixa->id)->sum('valor');
                $caixa->total_retirada = $totalRetirada;
                $caixa->save();
            } else {
                return response()->json([
                    'error' => [
                        'message' => 'O caixa não esta aberto!',
                        'status_code' => 404,
                    ],
                ], 404);
            }


        }

        $return = [
            'success' => '1',
            'message' => 'Retirada cadastrada',
        ];

        return $return;
    }

    public function retiradaEdit($id)
    {
        $retirada = Retirada::find($id);

        $funcionarios = $this->funcionariosForSelect();

        return view('adm.financeiro.retiradaEdit', compact('retirada', 'funcionarios'));
    }

    public function retiradaUpdate(Request $request)
    {
        $retirada = Retirada::find($request->id);

        $retirada->tipo = $request->tipo;
        $retirada->valor = $request->valor;
        $retirada->descricao = $request->descricao;
        $retirada->retirado_caixa = $request->retiradoCaixa;

        $retirada->is_debito = $request->is_debito;
        $retirada->motivo = $request->motivo;
        if($request->funcionario_id >= 1) {
            $retirada->funcionario_id = $request->funcionario_id;
            $retirada->init = Carbon::createFromFormat('d/m/Y', $request->init)->format('Y-m-d');
            $retirada->end = Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d');
        }
        $retirada->fonte_pgto = $request->fonte_pgto;
        $retirada->save();

        flash()->success('Retirada alterada com sucesso');

        return 'ok';

    }

    public function deletaRetirada($id)
    {
        if (\Auth::user()->user_type == 'super_adm') {

            $retirada = Retirada::find($id);

            $retirada->delete();

            flash()->success('Retirada deletada com sucesso.');

        } else {
            flash()->error('Você não tem permissão para fazer essa operação.');
        }

        return redirect()->back();
    }

    public function cadastraPgto()
    {
        return view('adm.financeiro.cadastraBoleto');
    }

    public function storePgto(Request $request)
    {
        $confere = Pagamento::where('linha_digitavel', '=', $request->linha_digitavel)->first();

        if ($confere) {

            return response()->json([
                'return' => [
                    'type' => 'warning',
                    'message' => 'Pagamento já existe',
                    'title' => 'Atenção',
                    'status_code' => 404,
                ],
            ], 404);

        }
        $pagamento = Pagamento::create($request->all());
        $pagamento->user_id_cadastro = \Auth::user()->id;
        $pagamento->save();

        if ($request->arquivoPagamento != '') {

            $this->gravaArquivo($request->arquivoPagamento, $request->vencimento, 'BOLETO_', $pagamento, 'pagamento');
        }

        if ($request->arquivoNota != '') {

            $this->gravaArquivo($request->arquivoNota, $request->vencimento, 'NOTA_', $pagamento, 'notaFiscal');
        }

        $pagamento->save();

        if ($request->produtos) {

            foreach ($request->produtos as $p) {

                $produto = Produto::find($p['id']);
                $produto->quantidadeEstoque = $produto->quantidadeEstoque + $p['quantidade'];
                $produto->save();

                Movimentacao::create([
                    'produto_id' => $p['id'],
                    'quantity' => $p['quantidade'],
                    'is_entrada' => 1,
                    'user_id' => \Auth::user()->id,
                    'pagamento_id' => $pagamento->id
                ]);
            }
        }

        return response()->json([
            'return' => [
                'type' => 'success',
                'message' => 'Pagamento cadastrado com sucesso',
                'title' => 'OK',
                'status_code' => 200,
            ],
        ], 200);

    }

    public function salvaArquivosPagamento($arquivo, $prefix, $data)
    {

        $dataAlt = dataAnoMes($data);
        $dataArquivo = dataPtBrParaArquivo($data);

        $extArquivo = $arquivo->getClientOriginalExtension();
        $nomeArquivo = $dataAlt . $prefix . $dataArquivo . '.' . $extArquivo;

        \Storage::disk('s3')->put($this->uploadPath.$nomeArquivo, file_get_contents($arquivo));

        return $this->uploadPath.$nomeArquivo;
        
    }

    public function listaAPagar()
    {
        $pagamentos = Pagamento::with(['usuarioCadastro', 'usuarioPagamento'])
            ->where('is_liquidado', '=', 0)
            ->orderBY('vencimento', 'ASC')
            ->get();

        $return = [
            'pagamentos' => $pagamentos,
        ];

        return view('adm.financeiro.aPagar')->with($return);
    }

    public function historicoPagamentos()
    {
        $pagamentos = Pagamento::with(['usuarioCadastro', 'usuarioPagamento'])
            ->where('is_liquidado', '=', 1)
            ->orderBY('data_pgto', 'DESC')
            ->get();

        $return = [
            'pagamentos' => $pagamentos,
        ];

        return view('adm.financeiro.historicoPagamentos')->with($return);
    }

    public function detalhesPagamento($id)
    {
        $pagamento = Pagamento::with(['usuarioPagamento', 'produtos.produto'])->where('id', '=', $id)->first();

        $dados = [
            'pagamento' => $pagamento
        ];

        return view('adm.financeiro.detalhes')->with($dados);
    }

    public function editPagamento($id)
    {
        $pagamento = Pagamento::find($id);

        $dados = [
            'pagamento' => $pagamento
        ];

        return view('adm.financeiro.editPagamento')->with($dados);
    }

    public function updatePagamento(PagamentoRequest $request)
    {

        $pagamento = Pagamento::find($request->id);

        $pagamento->where('id', '=', $request->id)->update([
            'linha_digitavel' => $request->linha_digitavel,
            'valor' => $request->valor,
            'descricao' => $request->descricao,
            'vencimento' => dataPtBrParaMysql($request->vencimento),
            'observacoes' => $request->observacoes,
        ]);


        if (!is_null($request->file('pagamento')) or !empty($request->file('pagamento'))) {
            //Salva arquivo pagamento e seta o nome no banco.
            $nomeArquivos = $this->salvaArquivosPagamento($request->file('pagamento'), '_ID_' . $pagamento->id . '_PGTO_', $request->vencimento);
            $pagamento->pagamento = $nomeArquivos;
        }

        if (!is_null($request->file('notaFiscal')) or !empty($request->file('notaFiscal'))) {
            //Salva arquivo pagamento e seta o nome no banco.
            $nomeArquivos = $this->salvaArquivosPagamento($request->file('notaFiscal'), '_ID_' . $pagamento->id . '_NOTAF_', $request->vencimento);
            $pagamento->notafiscal = $nomeArquivos;
        }

        $pagamento->save();

        $dados = [
            'pagamento' => $pagamento
        ];

        return redirect(route('admin.financeiro.detalhes', $pagamento->id))->with($dados);
    }

    public function liquidar(PagamentoRequest $request)
    {

        //dd($request->all());

        $pagamento = Pagamento::where('id', '=', $request->pagamento_id)->first();

        if ($request->file('comprovante')) {
            //Salva arquivo pagamento e seta o nome no banco.
            $nomeArquivos = $this->salvaArquivosPagamento($request->file('comprovante'), '_ID_' . $pagamento->id . '_COMPVT_', $request->data_pgto);
            //aqui sobrescrevendo o arquivo da nota
            $pagamento->comprovante = $nomeArquivos;
        }

        if ($request->is_liquidado) {
            $pagamento->is_liquidado = 1;
            $pagamento->data_pgto = $request->data_pgto;
            $pagamento->valor_pago = $request->valor_pago;
            $pagamento->fonte_pgto = $request->fonte_pgto;
            $pagamento->user_id_pagamento = \Auth::user()->id;
            
        } 

        if (!$request->is_liquidado){
            $pagamento->is_liquidado = 0;
            $pagamento->user_id_pagamento = '';
            $pagamento->fonte_pgto = '';
            $pagamento->comprovante = '';
            $pagamento->data_pgto = '00/00/0000';
        }

        $pagamento->save();

        flash()->success('Pagamento excluido com sucesso.');

        return redirect()->back();
    }

    public function dateRange(PagamentoRequest $request)
    {
        $pagamentos = Pagamento::with(['usuarioCadastro', 'usuarioPagamento'])
            ->whereBetween('data_pgto', array($request->dataInicio, $request->dataFim))
            ->where('is_liquidado', '=', 1)
            ->orderBY('data_pgto', 'DESC')
            ->get();

        $totalPeriodo = number_format($pagamentos->sum('valor'), 2, ',', '.');

        $return = [
            'pagamentos' => $pagamentos,
            'totalPeriodo' => $totalPeriodo,
            'dataInicio' => dataMysqlParaPtBr($request->dataInicio),
            'dataFim' => dataMysqlParaPtBr($request->dataFim),
        ];

        return view('adm.financeiro.historicoPagamentos')->with($return);

    }

    public function escolha()
    {
        return view('adm.financeiro.historicoGeral');
    }

    public function despesaCreate()
    {
        //$result = array();
        //
        //foreach ($produtos as $key => $value) {
        //    $result[$key]['nome'] = $value->nome_produto;
        //    $result[$key]['id'] = $value->id;
        //    $result[$key]['quantidade'] = '';
        //}

        $produtos = Produto::all();

        $produtosForSelect = [];
        foreach ($produtos as $key => $value) {
            $produtosForSelect[$value->id] = $value->nome_produto;
        }


        return view('adm.financeiro.pagamentoSimples', compact('produtos', 'produtosForSelect'));
    }

    public function despesaStore(PagamentoRequest $request)
    {

        $pagamento = Pagamento::create($request->all());
        $pagamento->user_id_cadastro = \Auth::user()->id;
        $pagamento->user_id_pagamento = \Auth::user()->id;
        $pagamento->is_liquidado = 1;
        $pagamento->vencimento = $pagamento->data_pgto;

        if (!is_null($request->file('comprovante')) or !empty($request->file('comprovante'))) {
            //Salva arquivo pagamento e seta o nome no banco.
            $nomeArquivos = $this->salvaArquivosPagamento($request->file('comprovante'), '_ID_' . $pagamento->id . '_COMPRVT_', $request->data_pgto);
            $pagamento->comprovante = $nomeArquivos;
        }

        $pagamento->save();



        $dados = [
            'msg_retorno' => 'Pagamento cadastrado com sucesso.',
            'tipo_retorno' => 'success'
        ];

        return view('adm.financeiro.pagamentoSimples')->with($dados);
    }


    public function retiradasList()
    {
        $retiradas = Retirada::orderBy('created_at', 'DESC')->paginate(12);

        $return =
            [
                'retiradas' => $retiradas,
            ];

        return view('adm.financeiro.retiradasList')->with($return);
    }

    public function despesaStoreVue(Request $request)
    {

        $pagamento = Pagamento::create([
            'valor' => $request->valor,
            'data_pgto' => $request->data_pgto,
            'vencimento' => $request->data_pgto,
            'descricao' => $request->descricao,
            'fonte_pgto' => $request->fonte_pgto,
            'observacoes' => $request->observacoes,
        ]);

        if ($request->comprovante != '') {

            $this->gravaArquivoBase64($request->comprovante, $request->data_pgto, 'COMP_', $pagamento, 'comprovante');
        }


        $pagamento->is_liquidado = 1;
        $pagamento->user_id_cadastro = \Auth::user()->id;
        $pagamento->user_id_pagamento = \Auth::user()->id;
        $pagamento->save();

        if ($request->produtos) {

            foreach ($request->produtos as $p) {

                $produto = Produto::find($p['id']);
                $produto->quantidadeEstoque = $produto->quantidadeEstoque + $p['quantidade'];
                $produto->save();

                Movimentacao::create([
                    'produto_id' => $p['id'],
                    'quantity' => $p['quantidade'],
                    'is_entrada' => 1,
                    'user_id' => \Auth::user()->id,
                    'pagamento_id' => $pagamento->id
                ]);
            }
        }

        return response()->json([
            'return' => [
                'type' => 'success',
                'message' => 'Pagamento simples cadastrado com sucesso',
                'title' => 'OK',
                'status_code' => 200,
            ],
        ], 200);

    }

    public function gravaArquivoBase64($arquivo, $data, $prefixo, $objeto, $tipo)
    {
        $img = Image::make($arquivo);
        $dataAlt = dataAnoMes($data);
        $dataArquivo = dataPtBrParaArquivo($data);
        $nomeArquivo = $prefixo . '_ID_' . $objeto->id . '_' . $dataArquivo . '.' . '.jpg';
        \Storage::disk('s3')->put($this->uploadPath.$nomeArquivo, $img->__toString());
        $objeto->$tipo = $this->uploadPath.$nomeArquivo;
    }

    public function gravaArquivo($arquivo, $data, $prefixo, $objeto, $tipo)
    {

        $ext = $arquivo->getClientOriginalExtension();
        $dataAlt = dataAnoMes($data);
        $dataArquivo = dataPtBrParaArquivo($data);
        $nomeArquivo = $prefixo . '_ID_' . $objeto->id . '_' . $dataArquivo . '.' . $ext;
        \Storage::disk('s3')->put($this->uploadPath.$nomeArquivo, file_get_contents($arquivo));
        $objeto->$tipo = $this->uploadPath.$nomeArquivo;

    }

    public function caixaIndex()
    {
        return view('adm.financeiro.fluxocaixa');
    }
}
