<?php

namespace serranatural\Http\Controllers;

use Illuminate\Support\Facades\Request;
use serranatural\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use serranatural\Models\Pratos;
use serranatural\Models\Voto;
use serranatural\Models\Cliente;

class VotacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $mes = retornaMesPorExtenso(date(time()));
        $inicioSemana = date('d');
        $fimSemana = date('d', strtotime("+6 days"));
        $semana = $inicioSemana . ' a ' . $fimSemana . ' de ' . $mes;
        
        $pratos = Pratos::all();
        
        $votos = DB::table('votacaoPratosDoDia')
                     ->select(DB::raw('opcaoEscolhida, COUNT(*) as qtdVoto'))
                     ->from('votacaoPratosDoDia')
                     ->groupBY('opcaoEscolhida')
                     ->orderBY('qtdVoto', 'DESC')
                     ->take(5)
                     ->get();
        
        $totalVotos = DB::table('votacaoPratosDoDia')
                     ->select(DB::raw('opcaoEscolhida, COUNT(*) as total'))
                     ->from('votacaoPratosDoDia')
                     ->first();
        
        $dados = [
        
        'pratos' => $pratos,
        'semana' => $semana,
        'votos' => $votos,
        'totalVotos' => $totalVotos
        
        ];

        return view('votacao/votacao')->with($dados);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function addVotoCadastro()
    {
        $opcoesEscolhidas = Request::get('opcaoEscolhida');

        if($opcoesEscolhidas == ''){

           $dados = [
           'msg_retorno' => 'Por favor, escolha alguma opção.',
           'tipo_retorno' => 'danger'
       ];

       return redirect()->action('VotacaoController@index')->with($dados); 

        } else {
        
        $opcoesEscolhidas = Request::get('opcaoEscolhida');

        $cliente = Request::all();

        if($cliente['emailCadastro'] <> ''){

            Cliente::create([

                'email' => $cliente['emailCadastro'],
                'nome' => $cliente['nome'],
                'telefone' => $cliente['telefone']
                ]);

            $id = Cliente::where('email', '=', $cliente['emailCadastro'])->first();

            $mes = retornaMesPorExtenso(date(time()));
            $inicioSemana = date('d');
            $fimSemana = date('d', strtotime("+6 days"));
            $semana = $inicioSemana . ' a ' . $fimSemana . ' de ' . $mes;
    
            foreach ($opcoesEscolhidas as $opcao){
                Voto::create([
                    'opcaoEscolhida' => $opcao,
                    'semanaCorrente' => $semana,
                    'clienteId' => $id['id']
                    ]);
            }

        } else {

        }

        $dados = [
            'msg_retorno' => 'Obrigado pelo seu voto! Cadastro',
            'tipo_retorno' => 'info'
        ];

        return redirect()->action('VotacaoController@index')->with($dados);

    }

}


        public function addVotoCliente()
    {

        $opcoesEscolhidas = Request::get('opcaoEscolhida');

        if($opcoesEscolhidas == ''){

           $dados = [
           'msg_retorno' => 'Por favor, escolha alguma opção.',
           'tipo_retorno' => 'danger'
       ];

       return redirect()->action('VotacaoController@index')->with($dados); 

        } else {


        $clienteEmail = Request::get('emailCliente');

        $opcoesEscolhidas = Request::get('opcaoEscolhida');

        $cliente = Cliente::where('email', '=', $clienteEmail)->first();

        if ($cliente['id'] == ''){
            $dados = [
           'msg_retorno' => 'Email não cadastrado',
           'tipo_retorno' => 'danger'
       ];

       return redirect()->action('VotacaoController@index')->with($dados); 

        } else {

           $mes = retornaMesPorExtenso(date(time()));
           $inicioSemana = date('d');
           $fimSemana = date('d', strtotime("+6 days"));
           $semana = $inicioSemana . ' a ' . $fimSemana . ' de ' . $mes;
    
           foreach ($opcoesEscolhidas as $opcao){
               Voto::create([
                   'opcaoEscolhida' => $opcao,
                   'semanaCorrente' => $semana, 
                   'clienteId' => $cliente['id']
                   ]);
           }


               $dados = [
                   'msg_retorno' => 'Obrigado pelo seu voto! Com Cliente',
                   'tipo_retorno' => 'info'
               ];

            return redirect()->action('VotacaoController@index')->with($dados);
        }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
