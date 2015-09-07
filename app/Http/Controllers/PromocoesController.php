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
        $pratos = Pratos::where('ativo', '=', 1)->get();
        
        $votos = Voto::select(DB::raw('pratos_id, COUNT(*) as qtdVoto'))
                     ->from('votacaoPratosDoDia')
                     ->join('promocoes', 'votacaoPratosDoDia.promocaoID', '=', 'promocoes.id')
                     ->where('promocoes.ativo', '=', 1)
                     ->groupBY('pratos_id')
                     ->orderBY('qtdVoto', 'DESC')
                     ->take(5)
                     ->get();
        
        $totalVotos = DB::table('votacaoPratosDoDia')
                     ->select(DB::raw('pratos_id, COUNT(*) as total'))
                     ->from('votacaoPratosDoDia')
                     ->join('promocoes', 'votacaoPratosDoDia.promocaoID', '=', 'promocoes.id')
                     ->where('promocoes.ativo', '=', 1)
                     ->first();
        
        $dados = [
        'pratos' => $pratos,
        'votos' => $votos,
        'totalVotos' => $totalVotos
        ];

        return view('votacao/votacao')->with($dados);
    }
    
    // Cadastra o cliente e adiciona o voto e preferencias.
    public function addVotoCadastro()
    {
        $opcoesEscolhidas = Request::get('opcaoEscolhida');

        if($opcoesEscolhidas == '' OR Request::get('emailCadastro') == ''){

           $dados = [
           'msg_retorno' => 'Por favor, preencha o formulário e vote.',
           'tipo_retorno' => 'danger'
       ];

       return redirect()->action('PromocoesController@paginaVotacao')->with($dados); 

        }
        
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

            $diaVoto = date('Y-m-d');
    
            foreach ($opcoesEscolhidas as $opcao){
                Voto::create([
                    'pratos_id' => $opcao,
                    'clienteId' => $id['id'],
                    'diaVoto' => $diaVoto,
                    'promocaoID' => $idPromocao->id
                    ]);

                Preferencias::create([
                    'clienteId' => $id['id'],
                    'preferencias' => $opcao,
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



        //Adiciona o voto do cliente cadastrado e preferencias
        public function addVotoCliente()
    {

        $opcoesEscolhidas = Request::get('opcaoEscolhida');

        if($opcoesEscolhidas == '' OR Request::get('emailCliente') == ''){

           $dados = [
           'msg_retorno' => 'Por favor, escolha uma opção e vote!',
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
                $diaVoto = date('Y-m-d');

               foreach ($opcoesEscolhidas as $opcao){
                   Voto::create([
                       'pratos_id' => $opcao,
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
            // Seleciona os votos válidos da promoção com determinado ID
            $votos = Voto::groupBY('diaVoto')
            ->groupBY('clienteId')
            ->where('promocaoID', '=', Request::input('sorteioID'))
            ->get();

            // Faz os sorteio dos votos válidos
            $sorteio = $votos[mt_rand(0, count($votos) - 1)];
            
            // Busco o sorteado de acordo com o ID
            $sortudo = Cliente::
            where('id', '=', $sorteio->clienteId)
            ->first();
            // Busca os ganhadores para a tabela da direita
            $ganhadores = DB::table('promocoes')
            ->where('clienteId');
            // Retorna a promoção valida para lista novamente
        $sorteio = Promocoes::where('nome_promocao', '=', 'Votação')
                    ->where('ativo', '=', '1')
                    ->orderBy('id', 'desc')
                    ->first();          

        $ticketsValidos = Voto::select(DB::raw('COUNT(DISTINCT clienteId, diaVoto) AS total'))
                        ->where('promocaoID', '=', $sorteio->id)
                        ->first();
        $participantes = Voto::select(DB::raw('COUNT(DISTINCT clienteId) AS total'))
                        ->where('promocaoID', '=', $sorteio->id)
                        ->first();
        $dias = Voto::select(DB::raw('COUNT(DISTINCT diaVoto) AS total'))
                        ->where('promocaoID', '=', $sorteio->id)
                        ->first();

        // Verifica se existem tickets válidos e calcula a média de tickets válidos por dia
        if($ticketsValidos->total >= 1){
            $media = $ticketsValidos->total / $dias->total;
        } else {}

        // Lista dos ultimos cinco sorteados
        $listaSorteado = Promocoes::join('clientes', 'promocoes.clienteId', '=', 'clientes.id')
                            ->where('promocoes.clienteId', '>', 0)
                            ->orderBy('promocoes.id', 'desc')
                            ->take(5)
                            ->get();


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

        $ticketsValidos = Voto::select(DB::raw('COUNT(DISTINCT clienteId, diaVoto) AS total'))
                        ->where('promocaoID', '=', $sorteio->id)
                        ->first();
        $participantes = Voto::select(DB::raw('COUNT(DISTINCT clienteId) AS total'))
                        ->where('promocaoID', '=', $sorteio->id)
                        ->first();
        $dias = Voto::select(DB::raw('COUNT(DISTINCT diaVoto) AS total'))
                        ->where('promocaoID', '=', $sorteio->id)
                        ->first();

        // Verifica se existem tickets válidos e calcula a média de tickets válidos por dia
        if($ticketsValidos->total >= 1){
            $media = $ticketsValidos->total / $dias->total;
        }

        // Lista dos ultimos cinco sorteados
        $listaSorteado = Promocoes::join('clientes', 'promocoes.clienteId', '=', 'clientes.id')
                            ->where('promocoes.clienteId', '>', 0)
                            ->orderBy('promocoes.id', 'desc')
                            ->take(5)
                            ->get();

        $dados = [

            'participantes' => $participantes,
            'sorteio' => $sorteio,
            'ticketsValidos' => $ticketsValidos,
            'mediaTickets' => isset($media) ? $media : $media = 0,
            'mediaTickets' => $media,
            'lista' => $listaSorteado,

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

        $verificaSorteio = Promocoes::where('id', '=', Request::input('sorteioID'))
                                        ->where('clienteId', '>', 1)->first();

        if(is_null($verificaSorteio)){

        //Grava os dados do sorteado e desativa a promoção sorteada
        Promocoes::where('id', '=', Request::input('sorteioID'))
                ->update([
                    'clienteId' => Request::input('sortudoID'),
                    'nomeCliente' => Request::input('sortudoNOME'),
                    'ativo' => 0,
                    'ticketsValidos' => Request::input('ticketsValidos'),
                    'participantesUnicos' => Request::input('participantes'),
                    'mediaTicketDia' => Request::input('mediaTickets')
                    ]);

        // Determina o inicio e fim da próxima promoção
        $inicioPromo = date('Y-m-d');
        $fimPromo = date('Y-m-d', strtotime("+6 days"));

        //Cria a nova promoção com as respectivas datas
        $votos = Promocoes::create([
            'nome_promocao' => 'Votação',
            'data_inicio' => $inicioPromo,
            'data_termino' => $fimPromo,
            'ativo' => '1'
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
