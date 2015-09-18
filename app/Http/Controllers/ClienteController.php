<?php

namespace serranatural\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Cliente;
use serranatural\Models\Preferencias;
use serranatural\Models\Pratos;

class ClienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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

    public function updateCliente()
    {
        $request = Request::all();

        $id = Request::route('id');

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
            'tipo_retorno' => 'Cliente adicionado à lista de e-mail',
        ];

        return back()->with($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function entrarEmail()
    {
        $id = Request::route('id');

        Cliente::where('id', '=', $id)
        ->update(['opt_email' => 1]);

        $dados = [
            'msg_retorno' => 'Cliente retirado da lista de e-mail',
            'tipo_retorno' => 'danger',
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
        //
    }
}
