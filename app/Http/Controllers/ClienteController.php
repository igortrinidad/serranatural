<?php

namespace serranatural\Http\Controllers;

//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

use Mail;

use Illuminate\Http\Request;
use serranatural\Http\Requests;
use Illuminate\Support\Facades\Validator;

use serranatural\Http\Controllers\Controller;

use serranatural\Models\Cliente;
use serranatural\Models\Preferencias;
use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;
use serranatural\Models\PontoColetado;
use serranatural\Models\Voucher;
use serranatural\Models\Retirada;
use serranatural\Models\Caixa;
use serranatural\Models\Import;

class ClienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['cadastro', 'storeSelfCliente', 'clienteSelfEdita', 'clienteSelfMostra', 'selfChangeClient', 'testeApi', 'reenviaSenha', 'destroy']]);

    }

    public function lista()
    {
        $lista = Cliente::paginate(10);

        $clientesForSelect = $this->clientesForSelect();

        $urlPagination = '/admin/clientes/lista/?page=';

        flash()->success('Isto está um <b>sucesso</b>.');

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
                                ->orderBY('vencimento', 'ASC')
                                ->paginate(8);

        $vouchers = Voucher::where('cliente_id', '=', $id)
                            ->orderBY('vencimento', 'ASC')
                            ->paginate(8);

                            //dd($vouchers);

        $pontosTotal = count(PontoColetado::where('cliente_id', '=', $id)
                                            ->get());

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
                                ]
                            );

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

         $dados =
            [
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

        flash()->error('Cliente excluído com sucesso.');

        return back();
    }

    public function enviaEmailPratoDoDia($id)
    {

        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d'))
                                    ->first();

        if (!is_null($pratoDoDia) or !empty($pratoDoDia))
        {

            $cliente = Cliente::find($id);

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

        $data = [
                'msg_retorno' => 'Prato do dia não localizado',
                'tipo_retorno' => 'danger',
            ];

            return back()->with($data);

    }

    public function cadastro()
    {
        return view('adm.clientes.selfCadastro');

    }

    public function storeSelfCliente(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:clientes',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'title' => 'Ops!',
                'message' => 'Cliente já existe!',
                'type' => 'error'
            ], 403);
        }

        $cliente = Cliente::create($request->all());

        $data = [
            'msg_retorno' => 'Cadastro efetuado com sucesso!',
            'tipo_retorno' => 'success',
        ];

        return redirect()->back()->with($data);
    }

    public function clienteSelfMostra($email)
    {

        $cliente = Cliente::where('email', '=', $email)->first();

        if (is_null($cliente) or empty($cliente)) {
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

        if (is_null($cliente) or empty($cliente)) {
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
                                ]
                            );

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

        $clientesForSelect = $this->clientesForSelect();

        $pontosColetados = PontoColetado::with('cliente')
                                        ->orderBY('created_at', 'DESC')
                                        ->paginate(10);

        $urlPagination = '/admin/clientes/fidelidade/?page=';

        $dados = [
            'clientesForSelect' => $clientesForSelect,
            'pontosColetados' => $pontosColetados,
            'urlPagination' => $urlPagination
        ];

        return view('adm.clientes.fidelidadeIndex')->with($dados);
    }

    public function salvaPonto(Request $request)
    {
        $cliente = $request->all();

        $id = $cliente['cliente_id'];

        $timestamp = strtotime("+3 month");

        $ponto = PontoColetado::create([
                'cliente_id' => $id,
                'data_coleta' => date('Y-m-d'),
                'vencimento' => date('Y-m-d', $timestamp),
                'is_valido' => 1,
                'produto' => $cliente['produto']
            ]);

        $pontos = PontoColetado::where('cliente_id', '=', $cliente['cliente_id'])
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', $cliente['produto'])
                                ->get();




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

        $this->enviaEmailVoucherColetado($cliente['cliente_id'], $voucher->id);

        $dados = [
            'msg_retorno' => 'Pontos adicionados com sucesso. Cliente acaba de ganhar um voucher de'.$cliente['produto'].'.',
            'tipo_retorno' => 'info'
        ];

        return redirect()->back()->with($dados);

        }

        $this->enviaEmailPontoColetado($cliente['cliente_id'], $cliente['produto']);

        $c = Cliente::find($id);

        $pontosAcai = PontoColetado::where('cliente_id', '=', $id)
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', 'Açaí')
                                ->count();

        $pontosAlmoco = PontoColetado::where('cliente_id', '=', $id)
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', 'Almoço')
                                ->count();

        $dados = [
            'msg_retorno' => 'Pontos adicionados com sucesso para: ' . $c->nome . ' | Pontos Açaí: ' . $pontosAcai . ' | Pontos Almoço: ' . $pontosAlmoco,
            'tipo_retorno' => 'success'
        ];

        return redirect()->back()->with($dados);

    }

    public function usesVoucher(Request $request)
    {
        //dd($request->all());

        $cliente = Cliente::where('id', '=', $request->cliente_id)
                            ->where('senha_resgate', '=', $request->senha_resgate)
                            ->first();

        $userMaster = User::where('id', '=', \Auth::user->id)
                            ->where('user_type', '=', 'super_adm')
                            ->first();

        $voucher = Voucher::where('id', '=', $request->voucher_id)
                            ->first();

        if (!$cliente && !$userMaster) {
            $dados = [
                'msg_retorno' => 'Senha errada!',
                'tipo_retorno' => 'error'
            ];
            return $dados;

        } else if (is_null($request->valor) or empty($request->valor)) {
            
            $dados = [
                'msg_retorno' => 'Valor não preenchido',
                'tipo_retorno' => 'error'
            ];
            return $dados;

        } else if (dataPtBrParaMysql($voucher->vencimento) < date('Y-m-d')) {
            $dados = [
                'msg_retorno' => 'Voucher vencido!',
                'tipo_retorno' => 'error'
            ];
            return $dados;

        } else if ($voucher->is_valido == 0) {
            $dados = [
                'msg_retorno' => 'Voucher utilizado!',
                'tipo_retorno' => 'error'
            ];
            return $dados;
        }

        $voucher->is_valido = 0;
        $voucher->data_utilizado = date('Y-m-d');
        $voucher->valor = $request->valor;
        $voucher->user_id = \Auth::user()->id;
        $voucher->save();

        $retirada = new Retirada();
        $retirada->user_id = \Auth::user()->id;
        $retirada->valor = $request->valor;
        $retirada->descricao = 'ID Voucher: ' . $voucher->id . ' - ID Cliente: ' . $request->cliente_id;

        $retirada->save();

        $caixa = Caixa::where('is_aberto', '=', 1)->first();

        if(!is_null($caixa) or !empty($caixa)) {
            $retirada->retirado_caixa = 1;
            $retirada->caixa_id = $caixa->id;
            $retirada->save();
            $totalRetirada = Retirada::where('caixa_id', '=', $caixa->id)->sum('valor');
            $caixa->total_retirada = $totalRetirada;
            $caixa->save();
        }

        $dados = [
            'msg_retorno' => 'Voucher utilizado com sucesso.',
            'tipo_retorno' => 'success'
        ];

        return $dados;
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

    public function enviaEmailVoucherColetado($id, $voucherAdiquirido)
    {

        $cliente = Cliente::find($id);


        $voucher = Voucher::where('id', '=', $voucherAdiquirido)
                                ->where('is_valido', '=', 1)
                                ->first();

        $data = [

        'nomeCliente' => $cliente->nome,
        'emailCliente' => $cliente->email,
        'produto' => $voucher->produto,
        'senha' => $cliente->senha_resgate,
        'validade' => $voucher->vencimento,
        ];

                Mail::queue('emails.marketing.voucherColetado', $data, function ($message) use ($cliente, $data) {

                    $message->to($cliente->email, $cliente->nome);
                    $message->from('mkt@serranatural.com', 'Serra Natural');
                    $message->subject('Fidelidade Serra Natural');
                    $message->getSwiftMessage();

                });

                return true;

    }

    public function addVoucherCortesia($id, Request $request)
    {

        if ($request->senha == '154986') {
            
            $timestamp = strtotime("+2 month");
            
            $voucher = Voucher::create([
                    'cliente_id' => $id,
                    'data_voucher' => date('Y-m-d'),
                    'vencimento' => date('Y-m-d', $timestamp),
                    'is_valido' => 1,
                    'produto' => $request->produto
                ]);

            $this->enviaEmailVoucherColetado($id, $voucher->id);

            flash()->success('Voucher adicionado com sucesso.');

            return redirect()->back();

        }

        flash()->error('Senha errada.');

        return redirect()->back();
    }

    public function voucherList()
    {
        $vouchers = Voucher::with('cliente')->orderBy('data_utilizado', 'DESC')->paginate(20);

        return view('adm.clientes.voucherList', compact('vouchers'));
    }

    public function reenviaSenha($id)
    {
        $voucher = Voucher::where('cliente_id', '=', $id)->where('is_valido', '=', '1')->first();

        if(!$voucher) {

            flash()->error('Cliente não possui voucher');

            return redirect()->back();

        }
            $this->enviaEmailVoucherColetado($id, $voucher->id);

            flash()->success('Senha reenviada com sucesso.');

            return redirect()->back();

    }

    public function importIndex()
    {
        return view('adm.clientes.importIndex');
    }

        public function importData(Request $request)
    {
        Import::create([
            'data' => json_encode($request->data)
            ]);
        return 'Ok';
    }

    public function importOpen($id)
    {
        $import = Import::find($id);

        $import = $import->data;

        $clientes = Cliente::all();

        return view('adm.clientes.importOpen', compact('import', 'id', 'clientes'));
    }

    public function importUpdate(Request $request)
    {
        $import = Import::find($request->id);

        $import = $import->update([ 'data' => json_encode($request->clients) ]);

        return 'ok';
    }



}
