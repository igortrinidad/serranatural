@extends('landing/template/landing')

@section('conteudo')

<style>

.btn-success{
    margin-top: 26px;
    height: 32px;
}

.label-email{
    text-align: left;
}
</style>

    <div class="row"  id="elCliente">
        <div class="box">
            <div class="col-lg-12">



                <div class="row text-center">
                    <hr>
                    <h2 class="intro-text text-center">
                        <strong>REGULAMENTO DO PROGRAMA DE RELACIONAMENTO DO RESTAURANTE SERRA NATURAL</strong>
                    </h2>
                    <hr>

                    <div>

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

                        <p class="p1">3.5 Para efetuar o cadastro, o cliente precisará preencher o formulário no endereço web <a href="http://www.serranatural.com">www.serranatural.com</a> com seus dados pessoais e de contato (nome completo, email e telefone). - os quais serão protegidos).</p>

                        <p class="p1">3.6 Os dados fornecidos pelo cliente apenas serão alterados mediante sua solicitação ou, o cliente pode fazer as alterações no site, após acessar seu cadastro.</p>

                        <p class="p1">3.7 Ao se inscrever, o cliente automaticamente aceita todas condições presentes neste instrumento, ficando responsável por consultar eventualmente atualizações no REGULAMENTO DO PROGRAMA DE RELACIONAMENTO DO RESTAURANTE SERRA NATURAL.</p>

                        <p class="p1">IV. DA POLÍTICA DE PONTOS&nbsp;</p>

                        <p class="p1">4.1 A cada compra de um dos produtos participantes (Almoço ou Açai, independente do tamanho) o cliente receberá 1 (um) ponto do Programa Fidelidade Serra Natural de acordo com sua compra.</p>

                        <p class="p1">4.2 Cada 1 ponto recebido terá validade de 2 (dois) meses após sua aquisição.</p>

                        <p class="p1">4.3 Os pontos recebidos serão contabilizados em “contas correntes” de acordo com o produto adquirido correspondente da promoção (AÇAÍ OU ALMOÇO). Ex 1. Na compra de um açaí o cliente ganhará um ponto do Programa Fidelidade Serra Natural correspondente ao açaí. Ex 2. Na compra de um almoço o cliente ganhará um ponto do Programa Fidelidade Serra Natural correspondente ao almoço.</p>

                        <p class="p1">4.4 A acumulação total de 15 pontos válidos (não vencidos) de algum produto (açaí ou almoço) irá gerar um voucher do produto correspondente aos pontos acmulados.</p>

                        <p class="p1">4.5 O voucher convertido deverá ser de acordo com os pontos acumulados do produto e terá o direito de troca pelo produto correspondente sendo <b>AÇAÍ 300ML (AQUI OU VIAGEM)</b>, para os pontos acumulados com a compra de açaí’s e <b>ALMOÇO PEQUENO (AQUI OU VIAGEM)</b>, para os pontos acumulados com a compra de almoços.</p>

                        <p class="p1">4.6 Os pontos serão creditados no prazo máximo de 24 horas a contar de cada consumo, salvo na hipótese de problemas operacionais, como falhas na conexão de internet ou servidores de rede. Estes atrasos não invalidam o programa, e não geram nenhuma espécie de indenização.&nbsp;</p>

                        <p class="p1">4.7 Os pontos concedidos serão registrados numa "conta corrente" única. Em caso de multiplicidade de contas, todos os pontos serão consolidados numa única conta.</p>

                        <p class="p1">4.8 Quando efetuada a compra dentro do estabelecimento Serra Natural, o cliente deverá apresentar o seu cartão fidelidade, ou; informar o numero do cadastro, ou ou; informar seu e-mail, ou; seu numero de telefone, ou; seu nome completo; desde que os dados fornecidos sejam idênticos aos informados no preenchimento do formulário de adesão, caso contrario os pontos podem não ser computados corretamente.</p>

                        <p class="p1">4.9 O Restaurante Serra Natural&nbsp; reserva o direito de encerrar o Programa Fidelidade Serra Natural a qualquer tempo, imotivadamente, bem como alterar, limitar, modificar ou adicionar regras, termos e condições, sem qualquer prévio aviso aos clientes. Estas mudanças podem incluir o cancelamento do programa, tempo de utilização do pontos e vouchers, adição e/ou exclusão de produtos participantes, alteração da quantidade de pontos necessários, dentre outras, não sendo devida, em qualquer hipótese, nenhuma indenização ao cliente ou restituição do valor.</p>

                        <p class="p1">4.10 Os Pontos Programa Fidelidade Serra Natural sempre e somente podem ser trocados por produtos e/ou descontos do Restaurante Serra Natural, na forma prevista neste regulamento, sem a possibilidade de conversão em dinheiro. Terminado o programa, todo e qualquer crédito de pontos do Programa Fidelidade Serra Natural perderá automaticamente a validade.&nbsp;</p>

                        <p class="p1">4.11 Não será permitida a utilização de pontos nas seguintes hipóteses:</p>

                        <p class="p1">a. nos casos de clientes que tenham problemas de inadimplência com o Serra Natural, sendo que, nesses casos, todos os pontos desses clientes permanecerão bloqueados até a total regularização de sua situação.</p>

                        <p class="p1">b. nos casos de clientes com cadastro desatualizado, incompleto ou com erros. 4.10 O cliente poderá consultar sua conta-corrente de pontos no Site do Sistema serranatural.com/cliente/(email do cliente).&nbsp;</p>

                        <p class="p1">V. DOS RESGATES</p>

                        <p class="p1">5.1 Quando o cliente desejar realizar a a troca deverá contatar o atendente ou gerente da casa, apresentar um documento oficial com foto, assinando o “recibo de controle interno programa fidelidade” e informar a senha de resgate enviada para o email do cadastro. O voucher somente será liberado após a confirmação da senha de resgate.&nbsp;</p>

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


    @section('scripts')
	    @parent
	        
		<script type="text/javascript">



		</script>

	@stop

@stop