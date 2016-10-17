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

    <div class="row"  id="elFidelidade">
        <div class="box">
            <div class="col-lg-12">

                @include('flash::message')

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