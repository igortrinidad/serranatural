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

.card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    border-radius: 5px; /* 5px rounded corners */
    background-color: white;
    width: 180px;
    display: inline-block;
    vertical-align: bottom;
    margin: 20px;
}

.card-row{
    height: 300px;

}

/* On mouse-over, add a deeper shadow */
.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

/* Add some padding inside the card container */
.card-container {
    padding: 25px 16px;
}

/* Add rounded corners to the top left and the top right corner of the image */
img {
    border-radius: 5px 5px 0 0;
}
</style>

    <div class="row"  id="elFidelidade">

        <div class="box">
            <div class="col-lg-12">

                @include('flash::message')

                <div class="text-center">
                    <hr>
                    <h2 class="intro-text">
                        <strong>Podium Serra Natural</strong>
                    </h2>
                    <hr>
                    <p>*Em desenvolvimento</p>
                    <p>Periodo: {{$start->format('d/m/Y')}} - {{$end->format('d/m/Y')}}</p>
                    
                </div>

                
                <br>
                <div class="row">

                    <div class="col-md-10 col-md-offset-1 text-center">
                        <div class="card" style="height: 220px; background-color: #E0E5E5; ">
                            <div class="card-container">
                                <h2>2º</h2>
                                @if($p2)
                                    <h5><b>{{$p2->nome}}</b></h5>
                                    <p style="font-size: 20px">{{$p2->total}} pontos</p> 
                                @else
                                    <p>Contabilizando</p> 
                                @endif
                            </div>
                        </div>

                        <div class="card" style="height: 300px; background-color: #FED136; width: 220px;">
                            <div class="card-container">
                                <h2>1º</h2>
                                @if($p1)
                                <h5><b>{{$p1->nome}}</b></h5>
                                <p style="font-size: 20px">{{$p1->total}} pontos</p> 
                                @else
                                    <p>Contabilizando</p>
                                @endif
                            </div>
                        </div>
                        <div class="card" style="height: 180px; background-color: #BCB296;">
                            <div class="card-container">
                                <h2>3º</h2>
                                @if($p3)
                                    <h5><b>{{$p3->nome}}</b></h5>
                                    <p style="font-size: 20px">{{$p3->total}} pontos</p> 
                                @else
                                    <p>Contabilizando</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <br>

                </div>

                <br>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">

                        <hr>
                        <h2 class="intro-text">
                            <div class="" data-toggle="collapse" data-target="#rankingMes">
                                <label>Ranking do mês</label>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </h2>
                        <hr>
                        <div id="rankingMes" class="collapse">
                            
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>Ranking</td>
                                        <td>Cliente</td>
                                        <td>Quantidade de pontos</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($podiums as $key => $p)
                                    <tr>
                                        <td>{{ $key+1 }}º</td>
                                        <td>{{ $p->cliente->nome }}</td>
                                        <td>{{ $p->total }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>

        <div class="box">
            <div class="col-lg-12">

                <div class="text-center">
                	<hr>
                    <h2 class="intro-text">
                        <strong>Fidelidade</strong>
                    </h2>
                    <hr>
                    
                </div>

                
                <br>
                <div class="row" 
                    v-if="!interactions.cadastradoSelected" 
                    @click="interactions.cadastradoSelected = !interactions.cadastradoSelected"
                >
                    <br>
                    <div class="text-center">
                        <h4>Possui cadastro no programa fidelidade?</h4>
                    </div>
                    <br>
                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-block btn-default" @click="interactions.cadastrado = true">SIM</button>
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-block btn-default" @click="interactions.cadastrado = false">NÃO</button>
                    </div>

                </div>

                <div class="row" v-if="interactions.cadastradoSelected && interactions.cadastrado">

                        {!! csrf_field() !!}

                        <div >
                            <div class="col-lg-2">
                                
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="label-email">Email cadastrado</label>
                                <input type="text" v-model="emailCliente" class="form-control">
                            </div>
                            <div class="form-group col-lg-2">
                                <button class="btn btn-block btn-success" @click="goCliente($event)">Ir</button>
                            </div>
                        </div>
                </div>

                <div class="row" v-if="interactions.cadastradoSelected && !interactions.cadastrado">

                    <form role="form" method="POST" action="/fidelidade/cadastra/post">

                        {!! csrf_field() !!}

                        <input type="hidden" name="senha_resgate" value="{{ rand(1000, 9999)}}" />

                        <div class="row">
                            <div class="col-lg-3">
                                
                            </div>
                            <div class="col-lg-6">

                                <div class="text-center">
                                    <h4>Cadastre-se!</h4>
                                    <small>Receba informações da Serra Natural e participe de nossas promoções.</small>
                                </div>

                                <br><br>
                                <div class="form-group">
                                    <label class="label-email">Nome</label>
                                    <input type="text" name="nome" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label class="label-email">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label class="label-email">Telefone</label>
                                    <input type="text" name="telefone" class="form-control phone" required>
                                </div>
                                <div class="form-group">
                                    <label class="label-email">Aceito receber informações e promoções da Serra Natural.</label>
                                    <input type="checkbox" name="opt_email" class="checkbox" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-success">Cadastrar</button>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                </div>
                

            </div>
        </div>
    </div>


    @section('scripts')
	    @parent
	        
		<script type="text/javascript">

                $('#goCliente').on('click', function(){
                    window.location.href = '/cliente/' + $('#emailCliente').val();
                })

                $('.phone').mask("(00) 0 0000-0000");

                Vue.config.debug = true;
                Vue.http.headers.common['X-CSRF-TOKEN'] = $('input[name="_token"]').val();
                var vm = new Vue({
                    el: '#elFidelidade',
                    data: 
                    {
                        interactions: {
                            cadastradoSelected: false,
                            cadastrado: true,
                        },
                        emailCliente: '',
                    },
                    methods: {
                        goCliente: function(ev){
                            ev.preventDefault()

                            window.location.href = '/cliente/' + this.emailCliente;
                        }
                    }
                });

		</script>

	@stop

@stop