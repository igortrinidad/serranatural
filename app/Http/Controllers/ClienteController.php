<?php

namespace serranatural\Http\Controllers;

//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

use Mail;

use Illuminate\Http\Request;
use serranatural\Http\Requests;

use serranatural\Http\Controllers\Controller;

use serranatural\Models\Cliente;
use serranatural\Models\Preferencias;
use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;
use serranatural\Models\PontoColetado;
use serranatural\Models\Voucher;

class ClienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['cadastro', 'storeSelfCliente', 'clienteSelfEdita', 'clienteSelfMostra', 'selfChangeClient', 'testeApi']]);

    }

    public function lista()
    {
        $lista = Cliente::paginate(10);

        $clientesForSelect = $this->clientesForSelect();

        $urlPagination = '/admin/clientes/lista/?page=';

        $dados = [

            'lista' => $lista,
            'clientesForSelect' => $clientesForSelect,
            'urlPagination' => $urlPagination

        ];

        return view('adm/clientes/lista')->with($dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function mostraCliente($id)
    {
        $cliente = Cliente::where('id', '=', $id)->first();
        $preferencias = Preferencias::join('pratosDoDia', 'preferenciaClientes.preferencias', '=', 'pratosDoDia.id')
                                        ->where('clienteId', '=', $id)->get();
        $pratos = Pratos::all();

        $pontos = PontoColetado::where('cliente_id', '=', $id)
                                ->where('is_valido', '=', 1)
                                ->orderBY('vencimento', 'ASC')
                                ->paginate(8);

        $vouchers = Voucher::where('cliente_id', '=', $id)
                            ->where('is_valido', '=', 1)
                            ->orderBY('vencimento', 'ASC')
                            ->paginate(8);

        $pontosTotal = count(PontoColetado::all());

        $dados = [
            'cliente' => $cliente,
            'preferencias' => $preferencias,
            'pratos' => $pratos,
            'pontos' => $pontos,
            'vouchers' => $vouchers,
            'pontosTotal' => $pontosTotal
        ];

        return view('adm/clientes/mostra')->with($dados);

    }

    public function editaCliente(Request $request)
    {
        $id = $request->id;

        $cliente = Cliente::where('id', '=', $id)->first();

        $dados = [
            'c' => $cliente
        ];

        return view('adm/clientes/edita')->with($dados);

    }

    public function updateCliente(Request $request)
    {

        $id = $request->id;

        $cliente = Cliente::where('id', '=', $id)
                            ->update(
                                [
                                'nome' => $request['nome'],
                                'telefone' => $request['telefone'],
                                'email' => $request['email']
                                ]);

        $dados = [
            'msg_retorno' => 'Cliente alterado com sucesso',
            'tipo_retorno' => 'success',
        ];

        return redirect(route('admin.client.show', $id))->with($dados);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function sairEmail($id)
    {
        Cliente::where('id', '=', $id)
                ->update(['opt_email' => 0]);

        $dados = [
            'msg_retorno' => 'Cliente retirado da lista de e-mail',
            'tipo_retorno' => 'danger',
        ];

        return back()->with($dados);
    }


    public function entrarEmail($id)
    {
        Cliente::where('id', '=', $id)
        ->update(['opt_email' => 1]);

        $dados = [
            'msg_retorno' => 'Cliente adicionado à lista de e-mail',
            'tipo_retorno' => 'success',
        ];

        return back()->with($dados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function excluiPreferencia()
    {
        $clienteID = Request::route('clienteId');
        $preferencia = Request::route('preferencia');

        Preferencias::where('preferencias', '=', $preferencia)
                        ->where('clienteId', '=', $clienteID)
                        ->delete();

         $dados = [
            'msg_retorno' => 'Preferência excluida com sucesso.',
            'tipo_retorno' => 'danger',
        ];

        return back()->with($dados);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function addPreferencia()
    {
        $request = Request::all();

        Preferencias::create([
            'clienteId' => $request['clienteId'],
            'preferencias' => $request['pratos_id'],
            ]);

        $dados = [
            'msg_retorno' => 'Preferência adicionada com sucesso.',
            'tipo_retorno' => 'success',
        ];

        return back()->with($dados);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    
    public function destroy($id)
    {
        Cliente::find($id)->delete();

        $dados = [
            'msg_retorno' => 'Cliente deletado com sucesso',
            'tipo_retorno' => 'danger',
        ];

        return back()->with($dados);
    }

    public function enviaEmailPratoDoDia($id)
    {

        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d'))
                                    ->first();

        $cliente = Cliente::find($id)->first();

        $prato = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

        set_time_limit(900);

        $dados = [

        'prato' => $prato,
        'nomeCliente' => $cliente->nome,
        'emailCliente' => $cliente->email,

        ];

                Mail::queue('emails.marketing.pratoNovo', $dados, function ($message) use ($cliente, $dados)
                {

                    $message->to($cliente->email, $cliente->nome);
                    $message->from('mkt@serranatural.com', 'Serra Natural');
                    $message->subject('Cardápio do dia');
                    $message->getSwiftMessage();

                });

            

        $data = [
            'msg_retorno' => 'Email enviado com sucesso',
            'tipo_retorno' => 'success',
        ];

        return back()->with($data);

    }

    public function cadastro()
    {
        return view('adm.clientes.selfCadastro');

    }

    public function storeSelfCliente(Request $request)
    {
        $cliente = Cliente::create($request->all());

        $data = [
            'msg_retornos' => 'Cadastro efetuado com sucesso!',
            'tipo_retornos' => 'success',
        ];

        return redirect()->back()->with($data);
    }

    public function clienteSelfMostra($email)
    {

        $cliente = Cliente::where('email', '=', $email)->first();

        if(is_null($cliente) OR empty($cliente)) 
        {
            $dados = [

            'email' => $email
        ];

        return view('cliente.clienteNotFound')->with($dados);

        }


        $pontosAcai = PontoColetado::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', 'Açaí')
                                ->get();

        $pontosAlmoco = PontoColetado::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', 'Almoço')
                                ->get();

        $pontosAll = PontoColetado::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->get();

        $vouchers = Voucher::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->get();

        $qtdPontosAcai = count($pontosAcai);
        $qtdPontosAlmoco = count($pontosAlmoco);

        $dados = [

            'cliente' => $cliente,
            'pontosAll' => $pontosAll,
            'qtdPontosAcai' => $qtdPontosAcai,
            'qtdPontosAlmoco' => $qtdPontosAlmoco,
            'vouchers' => $vouchers
        ];

        return view('cliente.formMostra')->with($dados);
    }

    public function clienteSelfEdita($email)
    {

        $cliente = Cliente::where('email', '=', $email)->first();

        if(is_null($cliente) OR empty($cliente)) 
        {
            $dados = [

            'email' => $email
        ];

        return view('cliente.clienteNotFound')->with($dados);

        }

        $dados = [

            'cliente' => $cliente
        ];

        return view('cliente.formEdita')->with($dados);
    }

    public function selfChangeClient(Request $request)
    {

        $cliente = $request->all();

        //dd($cliente);

        $email = $cliente['email'];

        $cliente = Cliente::where('email', '=', $cliente['email'])
                            ->update(
                                [
                                'nome' => $cliente['nome'],
                                'telefone' => $cliente['telefone'],
                                'email' => $cliente['email'],
                                'opt_email' => $cliente['opt_email']
                                ]);

        $dados = [
            'msg_retorno' => 'Dados alterados com sucesso',
            'tipo_retorno' => 'success',
        ];

        return redirect()->route('selfClient.mostraSelected', [$email])->with($dados);
    }

    public function testeApi(Request $request)
    {
        $json = $request->all();

        $retorno = [
            'status' => 'Ok',
            'Mensagem' => 'Dados recebidos com sucesso.'

        ];

        return $json;
    }

    public function clientesForSelect()
    {
        $clientes = Cliente::all();
        $result = array();

        foreach($clientes as $key => $value) {
            $result[$value->id] = $value->id.' - '.$value->nome . ' - ' . $value->email;
        }

        return $result;
    }

    public function editaSelected(Request $request)
    {

        $cliente = Cliente::find($request->cliente);

        $dados = [
            'c' => $cliente
        ];

        return view('adm/clientes/edita')->with($dados);


    }

    public function fidelidadeIndex()
    {

        $lista = Cliente::paginate(10);

        $clientesForSelect = $this->clientesForSelect();

        $pontosColetados = PontoColetado::with('cliente')
                                        ->orderBY('created_at', 'DESC')
                                        ->paginate(10);

        $urlPagination = '/admin/clientes/fidelidade/?page=';

        $dados = [
            'lista' => $lista,
            'clientesForSelect' => $clientesForSelect,
            'pontosColetados' => $pontosColetados,
            'urlPagination' => $urlPagination
        ];

        return view('adm.clientes.fidelidadeIndex')->with($dados);
    }

    public function salvaPonto(Request $request)
    {
        $cliente = $request->all();

        $timestamp = strtotime("+2 month");

        $ponto = PontoColetado::create([
                'cliente_id' => $cliente['cliente_id'],
                'data_coleta' => date('Y-m-d'),
                'vencimento' => date('Y-m-d', $timestamp),
                'is_valido' => 1,
                'produto' => $cliente['produto']
            ]);

        $pontos = PontoColetado::where('cliente_id', '=', $cliente['cliente_id'])
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', $cliente['produto'])
                                ->get();


        $this->enviaEmailPontoColetado($cliente['cliente_id'], $cliente['produto']);

        if (count($pontos) >= 15)
        {
            $voucher = Voucher::create([
                    'cliente_id' => $cliente['cliente_id'],
                    'data_voucher' => date('Y-m-d'),
                    'vencimento' => date('Y-m-d', $timestamp),
                    'is_valido' => 1,
                    'produto' => $cliente['produto']

                ]);

            PontoColetado::where('cliente_id', '=', $cliente['cliente_id'])
                        ->where('is_valido', '=', 1)
                        ->where('produto', '=', $cliente['produto'])
                        ->update([
                            'voucher_id' => $voucher->id,
                            'is_valido' => 0
                            ]);

            PontoColetado::where('cliente_id', '=', $cliente['cliente_id'])
                        ->where('voucher_id', '=', $voucher->id)
                        ->delete();

        $dados = [
            'msg_retorno' => 'Pontos adicionados com sucesso. Cliente acaba de ganhar um voucher de'.$cliente['produto'].'.',
            'tipo_retorno' => 'info'
        ];

        return redirect()->back()->with($dados);

        }

        $dados = [
            'msg_retorno' => 'Pontos adicionados com sucesso',
            'tipo_retorno' => 'success'
        ];

        return redirect()->back()->with($dados);

    }

    public function usesVoucher(Request $request)
    {

        $cliente = Cliente::where('id', '=', $request->cliente_id)
                            ->where('senha_resgate', '=', $request->senha_resgate)
                            ->first();

        if (is_null($cliente) OR empty($cliente))
        {
            $dados = [
                'msg_retorno' => 'Senha errada!',
                'tipo_retorno' => 'danger'
            ];

            return redirect()->back()->with($dados);
        } 

            $dados = [
                'msg_retorno' => 'Voucher utilizado com sucesso.',
                'tipo_retorno' => 'success'
            ];

            return redirect()->back()->with($dados);
    }

    public function enviaEmailPontoColetado($id, $produtoAdiquirido)
    {

        $cliente = Cliente::find($id);

        $produto = $produtoAdiquirido;

        $pontosAcai = PontoColetado::where('cliente_id', '=', $id)
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', 'Açaí')
                                ->get();

        $pontosAlmoco = PontoColetado::where('cliente_id', '=', $id)
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', 'Almoço')
                                ->get();

        $pontosAll = PontoColetado::where('cliente_id', '=', $id)
                                ->where('is_valido', '=', 1)
                                ->get();

        $vouchers = Voucher::where('cliente_id', '=', $id)
                                ->where('is_valido', '=', 1)
                                ->get();

        $qtdPontosAcai = count($pontosAcai);
        $qtdPontosAlmoco = count($pontosAlmoco);

        $data = [

        'nomeCliente' => $cliente->nome,
        'emailCliente' => $cliente->email,
        'produto' => $produto,
        'qtdPontosAcai' => $qtdPontosAcai,
        'qtdPontosAlmoco' => $qtdPontosAlmoco,
        'vouchers' => $vouchers,
        ];

                Mail::queue('emails.marketing.pontoColetado', $data, function ($message) use ($cliente, $data)
                {

                    $message->to($cliente->email, $cliente->nome);
                    $message->from('mkt@serranatural.com', 'Serra Natural');
                    $message->subject('Fidelidade Serra Natural');
                    $message->getSwiftMessage();

                });

        return true;

    }


}
