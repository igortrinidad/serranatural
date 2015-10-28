@extends('layout/layoutVotacao')

@section('conteudo')


    <section id="cadastro" class="services-section">
        <div class="container">

                        <h1>Cadastro</h1>
                        <p>Olá <strong>{{ isset($cliente) ? $cliente->nome : ''}}</strong>, confira seus pontos e cadastro.</p>
                        

            <div class="row">
                <div class="col-lg-1"></div>
                    <div class="col-lg-6">

                        <div class="panel painel_cadastro paineis">
                            <div class="panel-body">
                                <h4 class="text-left">Dados</h4>

                                	@if(Session::has('msg_retorno'))
									<div class="alert alert-{{Session::get('tipo_retorno')}}">
									     {{Session::get('msg_retorno')}}
									 </div>
									@endif

                                    <img class="img-circle block text-center" src="{{get_gravatar($cliente->email, 150)}}" alt="Não tem avatar? Adicione um pelo serviço Gravatar" title="Não tem avatar? Adicione um pelo serviço Gravatar.com" />

                                    
                                    @yield('formEditaOuMostra')
                                        

                                    </div>
                                </div>
 
                        </div>

                        <div class="col-lg-4">

                            <div class="panel painel_cadastro paineis">
                                <div class="panel-body">
                                    <h4 class="text-left">Pontos</h4>
                                    
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <p>Açaí</p>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <p>Almoço</p>
                                        </div>
                                    </div>

                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <p style="font-weight:700;font-size:50px">{{$qtdPontosAcai}}
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <p style="font-weight:700;font-size:50px">{{$qtdPontosAlmoco}}
                                            </div>
                                        </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70"
                                                    aria-valuemin="0" aria-valuemax="100" style="width:{{calculaPorcentagem(15, $qtdPontosAcai)}}%">
                                                    <span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">                                            <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70"
                                                    aria-valuemin="0" aria-valuemax="100" style="width:{{calculaPorcentagem(15, $qtdPontosAlmoco)}}%">
                                                    <span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                            
                                      <div class="" data-toggle="collapse" data-target="#demo"> Seus pontos <i class="fa fa-chevron-down"></i></div>
                                      <div id="demo" class="collapse">
                                            
                                            <table class="table">
                                          <col width="50%">
                                            <col width="50%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Compra</th>
                                                <th class="text-center">Vencimento</th>
                                                <th class="text-center">Produto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pontosAll as $ponto)
                                            <tr>
                                                <th class="text-center">{{$ponto->data_coleta}}</th>
                                                <th class="text-center">{{$ponto->vencimento}}</th>
                                                <th class="text-center">{{$ponto->produto}}</th>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>


                                        </div>
                        

                                    


                                </div>
                            </div>

                            <div class="panel painel_cadastro paineis">
                                <div class="panel-body">
                                    <h4 class="text-left">Vouchers</h4>


                                    <table class="table">
                                          <col width="10%">
                                            <col width="45%">
                                            <col width="50%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">Produto</th>
                                                <th class="text-center">Vencimento</th>
                                                <th class="text-center">Data utilizado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($vouchers as $voucher)
                                            <tr>
                                                <th class="text-center">{{$voucher->id}}</th>
                                                <th class="text-center">{{$voucher->produto}}</th>
                                                <th class="text-center">{{$voucher->vencimento}}</th>
                                                <th class="text-center">@if($voucher->data_utilizado <= '2015-01-01'){{$voucher->data_utilizado}} @endif</th>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>


                                </div>
                            </div>



                        </div>
             
            </div>
            
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <div class="panel painel_cadastro paineis">
                        <div class="panel-body">
                            <h4 class="text-left">Regulamento</h4>
                            <div class="text-left">

                            <div class="" data-toggle="collapse" data-target="#collapseRegulamento"> <p class="p1"><b>REGULAMENTO DO PROGRAMA DE RELACIONAMENTO DO RESTAURANTE SERRA NATURAL – PROGRAMA FIDELIDADE</b></p>Clique aqui <i class="fa fa-chevron-down"></i></div>
                            <div id="collapseRegulamento" class="collapse">
                            

                            

<p class="p1">I. PROGRAMA FIDELIDADE SERRA NATURAL&nbsp;</p>

<p class="p1">1.1 O PROGRAMA FIDELIDADE SERRA NATURAL é um programa de benefícios, dirigido à clientela do Restaurante Serra Natural, criado, desenvolvido e administrado por Igor Trindade, e é regido pelas regras deste regulamento.</p>

<p class="p1">&nbsp;1.2 Para participar do programa, o participante toma conhecimento e adere a este regulamento, efetua seu cadastro no programa, recebendo pontos a partir do seu consumo, na forma aqui descrita, visando a obtenção de benefícios.</p>

<p class="p1">&nbsp;</p>

<p class="p1">II. DEFINIÇÕES&nbsp;</p>

<p class="p1">2.1 O Programa Fidelidade Serra Natural é um programa que concede a pessoas físicas brindes e descontos com base em suas compras freqüentes no restaurante, através da concessão de um cadastro e obtenção de pontos.</p>

<p class="p1">2.2 O Programa Fidelidade Serra Natural é um cadastro pessoal e instransferível, de propriedade do titular e de uso restrito conforme as regras determinadas neste regulamento.</p>

<p class="p1">&nbsp;</p>

<p class="p1">III. COMO ADERIR AO PROGRAMA FIDELIDADE SERRA NATURAL&nbsp;</p>

<p class="p1">3.1 Poderão inscrever-se como titulares todas as pessoas físicas maiores de 18 anos.&nbsp;</p>

<p class="p1">3.2 Cada participante poderá ter um único cadastro.&nbsp;</p>

<p class="p1">3.3. Menores de 18 anos poderão inscrever-se como titulares, desde que comprovem que preenchem um dos requisitos do Parágrafo Único do artigo 5º, da Lei 10.406 de 10/01/2002.&nbsp;</p>

<p class="p1">3.4 Não é necessária a efetivação de uma compra para associar-se ao Programa Fidelidade Serra Natural.&nbsp;</p>

<p class="p1">3.5 Para efetuar o cadastro, o cliente precisará preencher o formulário no endereço web <a href="http://www.admin.serranatural.com">www.admin.serranatural.com</a> com seus dados pessoais e de contato (nome completo, email e telefone). - os quais serão protegidos).</p>

<p class="p1">3.6 Os dados fornecidos pelo cliente apenas serão alterados mediante sua solicitação ou, o cliente pode fazer as alterações no site, após acessar seu cadastro.</p>

<p class="p1">IV. DA POLÍTICA DE PONTOS&nbsp;</p>

<p class="p1">4.1 A cada compra de um dos produtos participantes (Almoço ou Açai, independente do tamanho) o cliente receberá 1 (um) ponto do Programa Fidelidade Serra Natural de acordo com sua compra.</p>

<p class="p1">4.2 Cada 1 ponto recebido terá validade de 2 (dois) meses após sua aquisição.</p>

<p class="p1">4.3 Os pontos recebidos serão contabilizados em “contas correntes” de acordo com o produto adquirido correspondente da promoção (AÇAÍ OU ALMOÇO). Ex 1. Na compra de um açaí o cliente ganhará um ponto do Programa Fidelidade Serra Natural correspondente ao açaí. Ex 2. Na compra de um almoço o cliente ganhará um ponto do Programa Fidelidade Serra Natural correspondente ao almoço.</p>

<p class="p1">4.4 A acumulação total de 15 pontos válidos (não vencidos) de algum produto (açaí ou almoço) irá gerar um voucher do produto correspondente aos pontos acmulados.</p>

<p class="p1">4.5 O voucher convertido deverá ser de acordo com os pontos acumulados do produto e terá o direito de troca pelo produto correspondente sendo <b>AÇAÍ 300ML (AQUI OU VIAGEM)</b>, para os pontos acumulados com a compra de açaí’s e <b>ALMOÇO PEQUENO (AQUI OU VIAGEM)</b>, para os pontos acumulados com a compra de almoços.</p>

<p class="p1">4.6 Os pontos serão creditados no prazo máximo de 24 horas a contar de cada consumo, salvo na hipótese de problemas operacionais, como falhas na conexão de internet ou servidores de rede. Estes atrasos não invalidam o programa, e não geram nenhuma espécie de indenização.&nbsp;</p>

<p class="p1">4.7 Os pontos concedidos serão registrados numa "conta corrente" única. Em caso de multiplicidade de contas, todos os pontos serão consolidados numa única conta.</p>

<p class="p1">4.8 Quando efetuada a compra dentro do estabelecimento Serra Natural, o cliente deverá apresentar o seu cartão fidelidade, ou; informar o numero do cadastro, ou ou; informar seu e-mail, ou; seu numero de telefone, ou; seu nome completo; desde que os dados fornecidos sejam idênticos aos informados no preenchimento do formulário de adesão, caso contrario os pontos podem não ser computados corretamente.</p>

<p class="p1">4.9 O Restaurante Serra Natural&nbsp; reserva o direito de encerrar o Programa Fidelidade Serra Natural a qualquer tempo, imotivadamente, bem como alterar, limitar, modificar ou adicionar regras, termos e condições, sem qualquer prévio aviso aos clientes. Estas mudanças podem incluir o tempo de utilização do cartão, adição e/ou exclusão de brindes, alteração da taxa de conversão do valor em Reais para Pontos Programa Fidelidade Serra Natural, dentre outras, não sendo devida, em qualquer hipótese, nenhuma indenização ao cliente.</p>

<p class="p1">4.10 Os Pontos Programa Fidelidade Serra Natural sempre e somente podem ser trocados por produtos e/ou descontos do Restaurante Serra Natural, na forma prevista neste regulamento, sem a possibilidade de conversão em dinheiro. Terminado o programa, todo e qualquer crédito de pontos do Programa Fidelidade Serra Natural perderá automaticamente a validade.&nbsp;</p>

<p class="p1">4.11 Não será permitida a utilização de pontos nas seguintes hipóteses:</p>

<p class="p1">a. nos casos de clientes que tenham problemas de inadimplência com o Serra Natural, sendo que, nesses casos, todos os pontos desses clientes permanecerão bloqueados até a total regularização de sua situação.</p>

<p class="p1">b. nos casos de clientes com cadastro desatualizado, incompleto ou com erros. 4.10 O cliente poderá consultar sua conta-corrente de pontos no Site do Sistema admin.serranatural.com/me/(email do cliente).&nbsp;</p>

<p class="p1">V. DOS RESGATES</p>

<p class="p1">5.1 Quando o cliente desejar realizar a a troca deverá contatar o atendente ou gerente da casa, apresentar um documento oficial com foto, assinando o “recibo de controle interno programa fidelidade”. Contra assinatura do citado documento, os pontos serão debitados da respectiva conta.&nbsp;</p>

<p class="p1">5.2 Caso o brinde solicitado não estiver disponível no local, ou mesmo não existir em estoque, os pontos não serão debitados e o voucher permacerá válido até a data de seu vencimento.</p>

<p class="p1">5.3 O cliente pode, atrás do site do Programa, fazer a solicitação do brinde desejado com antecedência e informar em qual dos estabelecimentos do Restaurante Macarronada Italiana deseja fazer o resgate.</p>

<p class="p1">&nbsp;</p>

<p class="p1">VI. DISPOSIÇÕES GERAIS&nbsp;</p>

<p class="p1">6.1 O uso fraudulento do Programa ou em desacordo com este regulamento, determinará o seu cancelamento no programa e a perda dos pontos acumulados, independentemente da adoção das medidas legais cabíveis para o ressarcimento de todos e quaisquer danos sofridos por Serra Natural.</p>

<p class="p1">6.2 Ao constatar qualquer alteração ou erro no sistema do programa de fidelidade Serra Natural, o cliente deverá entrar em contato com o estabelecimento para averiguação.</p>

<p class="p1">6.3 O cancelamento do cartão de fidelidade, ainda que de forma imotivada (pela Serra Natural), não gerará ao cliente qualquer tipo de indenização, sendo certo que o cartão concedido constitui-se em mera liberalidade.</p>

<p class="p1">6.4 O Restaurante Serra Natural reserva o direito de descontinuar o Programa Fidelidade eliminando toda pontuação de seu cliente se os mesmos ou em parte forem adquiridos por meios fraudulentos, erro na entrada de dados, roubo ou qualquer outro meio que não o oficial do Programa Fidelidade Serra Natural.</p>

<p class="p1">6.4.1. O Restaurante Serra Natural reserva-se o direito de debitar, sem a anuência do respectivo titular, todos e quaisquer pontos do Cartão Fidelidade creditados indevidamente (em razão de duplicidade, erro, dolo etc.).</p>

<p class="p1">6.5 Os pontos não podem ser cedidos, trocados por dinheiro ou comercializados sob qualquer forma, sendo esta prática considerada fraudulenta, provocando o imediato cancelamento da inscrição no programa e a perda de todos os pontos acumulados.</p>

<p class="p1">6.6 Os pontos acumulados são pessoais e intransferíveis, não negociáveis e sem valor monetário.</p>

<p class="p1">6.7 Os empregados do Restaurante Serra Natural, seus dependentes e familiares não poderão participar desta promoção. Bem como os parceiros e fornecedores que fizerem &nbsp;o pagamento em forma de requisição e/ou permuta.</p>

<p class="p1">6.9 Este regulamento poderá ser modificado a qualquer tempo, sem aviso prévio, a exclusivo critério do Serra Natural. As eventuais modificações poderão ser oportunamente informadas aos clientes, inclusive através de meio eletrônico.</p>

<p class="p1">6.10 Os casos omissos serão tratados pelo Programa de Fidelidade Serra Natural.</p>

</div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
</section>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div id="escurece" hidden="true"></div>
<div id="loading" hidden="true"><i id="spinner" class="fa fa-spinner fa-4x"></i></div>

<div class="fundoLogo">
  <img class="logo" src="/img/logo.png" alt="Serra Natural"/>
</div>

@stop