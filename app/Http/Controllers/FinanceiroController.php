<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;
use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Caixa as Caixa;
use serranatural\Models\Retirada as Retirada;
use serranatural\Models\Cliente as Cliente;
use serranatural\User as User;
use serranatural\Models\Funcionario;

use Mail;

class FinanceiroController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => []]);

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
}
