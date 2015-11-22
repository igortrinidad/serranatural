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

use Image;
use Input;

use serranatural\Http\Requests\PagamentoRequest as PagamentoRequest;

class FinanceiroController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getImage']]);

        //$this->middleware('nivelAcesso:super_adm', ['only' => ['retirada']]);

    }

    public function indexFluxo()
    {

        $caixa = Caixa::with('usuarioAbertura')->where('is_aberto', '=', 1)->first();

        //dd($caixa);

        $dados = [
            'caixa' => $caixa
        ];

        return view('adm.financeiro.fluxo')->with($dados);
    }

    public function caixaCreate()
    {
        

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

        if (is_null($autoriza) OR empty($autoriza))
        {
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
                                'total_retirada' => $request->total_retirada,
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

        if (is_null($autoriza) OR empty($autoriza))
        {
            $dados = [
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

        $caixa = Caixa::where('id', '=', $request->id)->first();

        $userAbertura = User::where('id', '=', $caixa->user_id_abertura)->first();
        $userFechamento = User::where('id', '=', $caixa->user_id_fechamento)->first();

        $dados = [

        'dt_abertura' => $caixa->dt_abertura,
        'dt_fechamento' => $caixa->dt_fechamento,
        'vendas_cash' => $caixa->vendas_cash,
        'vendas_card' => $caixa->vendas_card,
        'total_vendas' => number_format($caixa->vendas_cash + $caixa->vendas_card, 2, ',', '.'),
        'vendas_rede' => $caixa->vendas_rede,
        'vendas_cielo' => $caixa->vendas_cielo,
        'total_retirada' => $caixa->total_retirada,
        'esperado_caixa' => $caixa->esperado_caixa,
        'vr_emCaixa' => $caixa->vr_emCaixa,
        'vr_abertura' => $caixa->vr_abertura,
        'diferenca_cartoes' => $caixa->diferenca_cartoes,
        'diferenca_caixa' => $caixa->diferenca_caixa,
        'diferenca_final' => $caixa->diferenca_final,
        'user_abertura' => $userAbertura->name,
        'user_fechamento' => $userFechamento->name,
        ];

        $mensagem = json_encode($dados);

        $email = Mail::queue('emails.admin.fechamentoCaixa', $dados, function ($message) use ($dados, $caixa)
            {

                $message->to('contato@maisbartenders.com.br', 'Igor Trindade');
                $message->from('mkt@serranatural.com', 'Serra Natural');
                $message->subject('Fechamento de caixa : ' . $caixa->dt_fechamento);
                $message->getSwiftMessage();

            });

        if(!$email)
        {
            $return = [
                'msg_retorno' => 'Ocorreu algum problema no envio do email.',
                'tipo_retorno' => 'error'
                ];

            return $return;
        }

        $return = [
                'msg_retorno' => 'Caixa fechado com sucesso, consulte o caixa em histórico.',
                'tipo_retorno' => 'success'
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
    public function destroy($id)
    {
        //
    }

    public function funcionariosForSelect()
    {
        $funcionarios = \serranatural\Models\Funcionario::all();
        $result = array();

        foreach($funcionarios as $key => $value) 
        {
            $result[$value->id] = $value->nome;
        }

        return $result;
    }

    public function retirada(Request $request)
    {

        $funcionarios = $this->funcionariosForSelect();

        $dados = [
            'funcionarios' => $funcionarios
        ];

        return view('adm.financeiro.retirada')->with($dados);
    }

    public function cadastraPgto()
    {
        return view('adm.financeiro.cadastraBoleto');
    }

    public function storePgto(PagamentoRequest $request)
    {
        $pagamento = Pagamento::create($request->all());

        //Salva arquivo pagamento e seta o nome no banco.
        $nomeArquivos = $this->salvaArquivosPagamento($request->file('pagamento'), $request->file('notaFiscal'), $request->vencimento);

        $pagamento->pagamento = $nomeArquivos['nomeArqPagamento'];
        $pagamento->notafiscal = $nomeArquivos['nomeArqNota'];
        $pagamento->user_id_cadastro = \Auth::user()->id;
        $pagamento->save();


        $return = [
            'msg_retorno' => 'Pagamento cadastrado com sucesso.',
            'tipo_retorno' => 'success'
            ];

        return redirect()->back()->with($return);

    }

    public function salvaArquivosPagamento($pagamento, $nota, $data)
    {

        $dataAlt = dataAnoMes($data);
        $dataArquivo = dataPtBrParaArquivo($data);

        if(!is_null($pagamento) OR !empty($pagamento))
        {
            $extPagamento = $pagamento->getClientOriginalExtension();
            $nomeArqPagamento = $dataAlt . '_PAG_V_' . $dataArquivo . '.' . $extPagamento;
            $arquivoPagamento = Storage::disk('pagamentos')->put($nomeArqPagamento,  File::get($pagamento));
        }
        if(!is_null($nota) OR !empty($nota))
        {
            $extNota = $nota->getClientOriginalExtension();
            $nomeArqNota = $dataAlt . '_NOTA_V_' . $dataArquivo . '.' . $extNota;
            $arquivoNota = Storage::disk('pagamentos')->put($nomeArqNota,  File::get($nota));
        }

        $nomeArquivos = [
             'nomeArqPagamento' => isset($nomeArqPagamento) ? $nomeArqPagamento : '',
             'nomeArqNota' => isset($nomeArqNota) ? $nomeArqNota : '',
        ];

        return $nomeArquivos;

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
        $pagamento = Pagamento::with(['usuarioPagamento'])->where('id', '=', $id)->first();

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


        if(!is_null($request->file('pagamento')) OR !empty($request->file('pagamento')))
        {
        //Salva arquivo pagamento e seta o nome no banco.
            $nomeArquivos = $this->salvaArquivosPagamento($request->file('pagamento'), $request->file('notaFiscal'), $request->vencimento);
            $pagamento->pagamento = $nomeArquivos['nomeArqPagamento'];
        }

        if(!is_null($request->file('notaFiscal')) OR !empty($request->file('notaFiscal')))
        {
        //Salva arquivo pagamento e seta o nome no banco.
            $nomeArquivos = $this->salvaArquivosPagamento($request->file('pagamento'), $request->file('notaFiscal'), $request->vencimento);
            $pagamento->notafiscal = $nomeArquivos['nomeArqNota'];
        }

        $pagamento->save();

        $dados = [
            'pagamento' => $pagamento
        ];

        return redirect(route('admin.financeiro.detalhes', $pagamento->id))->with($dados);
    }

    public function liquidar(PagamentoRequest $request)
    {


        $pagamento = Pagamento::where('id', '=', $request->pagamento_id)->first();

        if(!is_null($request->comprovante) OR !empty($request->comprovante))
        {
        //Salva arquivo nota e nome
        $comprovante = $request->file('comprovante');
        $extComprovante = $comprovante->getClientOriginalExtension();
        $nomeArqComprovante = dataAnoMes(($pagamento->vencimento)) . '_V_' . dataPtBrParaArquivo($pagamento->vencimento) . '_COMP_dtPgto_' . dataPtBrParaArquivo($request->data_pgto).'.'.$extComprovante;
        $arquivoComprovante = Storage::disk('pagamentos')->put($nomeArqComprovante,  File::get($comprovante));
        $pagamento->comprovante = $nomeArqComprovante;
        }

        if($request->is_liquidado == 1)
        {
            $pagamento->data_pgto = $request->data_pgto;
            $pagamento->fonte_pgto = $request->fonte_pgto;
            $pagamento->is_liquidado = 1;
            $pagamento->user_id_pagamento = \Auth::user()->id;
        } else 
        {
            $pagamento->is_liquidado = 0;
            $pagamento->user_id_pagamento = '';
            $pagamento->fonte_pgto = '';
            $pagamento->comprovante = '';
        }
        $pagamento->save();


        $dados = [
            'msg_retorno' => 'Pagamento liquidado com sucesso.',
            'tipo_retorno' => 'success'
        ];

        return redirect()->back()->with($dados);
    }


       //    if(!is_null($request->notaFiscal) OR !empty($request->notaFiscal))
       //{
       ////Salva arquivo nota e nome
       //$nota = $request->file('notaFiscal');
       //$extensaoNota = $nota->getClientOriginalExtension();
       //$arqNotaNome = 'VENC_' . dataPtBrParaArquivo($data) . '_NOTA_' . primeiro_nome($request->descricao).'.'.$extensaoNota;
       //$arquivoNota = Storage::disk('aPagar')->put($arqNotaNome,  File::get($nota));
       //$PGTO->notaFiscal_mime = $nota->getClientMimeType();
       //$PGTO->notaFiscal = $arqNotaNome;
       //}


}
