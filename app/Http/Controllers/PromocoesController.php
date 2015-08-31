<?php

namespace serranatural\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;
use serranatural\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use serranatural\Models\Pratos;
use serranatural\Models\Voto;
use serranatural\Models\Cliente;
use serranatural\Models\Preferencias;
use serranatural\Models\Promocoes;

class PromocoesController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth', [

            'except' => ['paginaVotacao', 'addVotoCadastro', 'addVotoCliente'],

            ]);
    }


   
   //Página do formulario de votação dos clientes.
    public function paginaVotacao()
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

       return redirect()->action('PromocoesController@paginaVotacao')->with($dados); 

        } else {
        
        $opcoesEscolhidas = Request::get('opcaoEscolhida');

        $cliente = Request::all();

        $verificaClienteExiste = Cliente::where('email', '=', $cliente['emailCadastro'])->first();

        if(is_null($verificaClienteExiste)){

            Cliente::create([

                'email' => $cliente['emailCadastro'],
                'nome' => $cliente['nome'],
                'telefone' => $cliente['telefone'],
                'opt_email' => 1,
                ]);

            $id = Cliente::where('email', '=', $cliente['emailCadastro'])->first();

            $idPromocao = Promocoes::where('nome_promocao', '=', 'Votação')
                    ->where('ativo', '=', '1')
                    ->orderBy('id', 'desc')
                    ->first(); 

            $diaVoto = date('d/m/Y');
    
            foreach ($opcoesEscolhidas as $opcao){
                Voto::create([
                    'opcaoEscolhida' => $opcao,
                    'clienteId' => $id['id'],
                    'diaVoto' => $diaVoto,
                    'promocaoID' => $idPromocao->id
                    ]);

                Preferencias::create([
                    'clienteId' => $id['id'],
                    'preferencias' => $opcao
                    ]);
                
            }

            $dados = [
            'msg_retorno' => 'Obrigado pelo voto e cadastro, ' . $cliente['nome'] . '.',
            'tipo_retorno' => 'info'
        ];

        return redirect()->action('PromocoesController@paginaVotacao')->with($dados);

        } else {

            $dados = [
            'msg_retorno' => 'Usuário já possui cadastro',
            'tipo_retorno' => 'danger'
        ];

        return redirect()->action('PromocoesController@paginaVotacao')->with($dados);

        }

        

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

            return redirect()->action('PromocoesController@paginaVotacao')->with($dados); 

            } else {


            $clienteEmail = Request::get('emailCliente');
            $opcoesEscolhidas = Request::get('opcaoEscolhida');
            $cliente = Cliente::where('email', '=', $clienteEmail)->first();

            if ($cliente['id'] == ''){
                $dados = [
               'msg_retorno' => 'Usuario não encontrado',
               'tipo_retorno' => 'danger'
           ];

           return redirect()->action('PromocoesController@paginaVotacao')->with($dados); 

            } else {

                $idPromocao = Promocoes::where('nome_promocao', '=', 'Votação')
                    ->where('ativo', '=', '1')
                    ->orderBy('id', 'desc')
                    ->first(); 
                $diaVoto = date('d/m/Y');

               foreach ($opcoesEscolhidas as $opcao){
                   Voto::create([
                       'opcaoEscolhida' => $opcao,
                       'clienteId' => $cliente['id'],
                       'diaVoto' => $diaVoto,
                       'promocaoID' => $idPromocao->id
                       ]);

                $consultaPreferencias = Preferencias::where('clienteId', '=', $cliente['id'])->where('preferencias', '=', $opcao)->first();
                    
                    if(is_null($consultaPreferencias)){
                    Preferencias::create([
                        'clienteId' => $cliente['id'],
                        'preferencias' => $opcao

                        ]);
                    }
                }

                   $dados = [
                       'msg_retorno' => 'Obrigado pelo seu voto, ' . $cliente['nome'] . '.',
                       'tipo_retorno' => 'info'
                   ];

                return redirect()->action('PromocoesController@paginaVotacao')->with($dados);
            }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function sorteioVotacao()
    {


            $votos = Voto::groupBY('diaVoto')
            ->groupBY('clienteId')
            ->get();

            $sorteio = $votos[mt_rand(0, count($votos) - 1)];
            
            $sortudo = Cliente::
            where('id', '=', $sorteio->clienteId)
            ->first();

            $ganhadores = DB::table('promocoes')
            ->where('clienteId');

            $sorteio = Promocoes::where('nome_promocao', '=', 'Votação')
                    ->where('ativo', '=', '1')
                    ->orderBy('id', 'desc')
                    ->first();

            $ticketsValidos = DB::table('votacaoPratosDoDia')->select(DB::raw('COUNT(DISTINCT clienteId, diaVoto) AS total'))->first();
            $participantes = DB::table('votacaoPratosDoDia')->select(DB::raw('COUNT(DISTINCT clienteId) AS total'))->first();
            $dias = DB::table('votacaoPratosDoDia')->select(DB::raw('COUNT(DISTINCT diaVoto) AS total'))->first();
    
            $media = $ticketsValidos->total / $dias->total;

            $listaSorteado = Promocoes::where('clienteId', '>', '0')->take(5)->get();


            $dados = [
                'sortudo' => $sortudo,
                'sorteio' => $sorteio,
                'participantes' => $participantes,
                'ticketsValidos' => $ticketsValidos,
                'mediaTickets' => $media,
                'lista' => $listaSorteado
            ];


           return view('adm/promocoes/indexPromocoes')->with($dados);
    }


    public function indexPromocoes()
    {

        $sorteio = Promocoes::where('nome_promocao', '=', 'Votação')
                    ->where('ativo', '=', '1')
                    ->orderBy('id', 'desc')
                    ->first();          

        $ticketsValidos = DB::table('votacaoPratosDoDia')->select(DB::raw('COUNT(DISTINCT clienteId, diaVoto) AS total'))->first();
        $participantes = DB::table('votacaoPratosDoDia')->select(DB::raw('COUNT(DISTINCT clienteId) AS total'))->first();
        $dias = DB::table('votacaoPratosDoDia')->select(DB::raw('COUNT(DISTINCT diaVoto) AS total'))->first();

        $media = $ticketsValidos->total / $dias->total;

        $listaSorteado = Promocoes::where('clienteId', '>', '0')->take(5)->get();

        $dados = [

            'participantes' => $participantes,
            'sorteio' => $sorteio,
            'ticketsValidos' => $ticketsValidos,
            'mediaTickets' => $media,
            'lista' => $listaSorteado

        ];

        return view('adm/promocoes/indexPromocoes')->with($dados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function salvaSorteado()
    {

        $verificaSorteio = Promocoes::where('id', '=', Request::input('sorteio'))
                                        ->where('clienteId', '>', 1)->first();

        if(is_null($verificaSorteio)){

        Promocoes::where('id', '=', Request::input('sorteio'))
                ->update([
                    'clienteId' => Request::input('sortudoId'),
                    'nomeCliente' => Request::input('sortudo'),
                    'ativo' => 0,
                    ]);

            return redirect()->action('PromocoesController@indexPromocoes')->with(['message' => 'Sucesso']);
        } else {

            return redirect()->action('PromocoesController@indexPromocoes')->with(['message' => 'Já foi sorteado']);
        }


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
