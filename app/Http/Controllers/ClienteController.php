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

class ClienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['cadastro', 'storeSelfCliente', 'clienteMostra', 'selfChangeClient', 'testeApi']]);

    }

    public function lista()
    {
        $lista = Cliente::paginate(10);

        $dados = [

            'lista' => $lista

        ];

        return view('adm/clientes/lista')->with($dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function mostraCliente()
    {
        $id = Request::route('id');
        $cliente = Cliente::where('id', '=', $id)->first();
        $preferencias = Preferencias::join('pratosDoDia', 'preferenciaClientes.preferencias', '=', 'pratosDoDia.id')
                                        ->where('clienteId', '=', $id)->get();
        $pratos = Pratos::all();

        $dados = [
            'cliente' => $cliente,
            'preferencias' => $preferencias,
            'pratos' => $pratos,
        ];

        return view('adm/clientes/mostra')->with($dados);

    }

    public function editaCliente()
    {
        $id = Request::route('id');

        $cliente = Cliente::where('id', '=', $id)->first();

        $dados = [
            'c' => $cliente
        ];

        return view('adm/clientes/edita')->with($dados);

    }

    public function updateCliente(Request $request)
    {
        $id = $request->route('id');

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

        return redirect('/admin/clientes/mostra/'.$id)->with($dados);

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

    public function clienteMostra($email)
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

        return view('cliente.clienteMostra')->with($dados);
    }

    public function selfChangeClient(Request $request)
    {

        $cliente = $request->all();

        //dd($cliente);

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

        return redirect()->back()->with($dados);
    }

    public function testeApi(Request $request)
    {
        $retorno = json_decode($request->all);

        //dd($request);

        return $retorno;
    }



}
