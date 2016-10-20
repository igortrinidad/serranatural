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

                {!! csrf_field() !!}

                @include('flash::message')

                <div class="text-center">
                	<hr>
                    <h2 class="intro-text">
                        <strong>Cliente: {{$cliente->nome}}</strong>
                    </h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <label>Nome</label>
                            <p>{{$cliente->nome}}</p>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <label>Email</label>
                            <p>{{$cliente->email}}</p>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <label>Telefone</label>
                            <p>{{$cliente->telefone}}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <a href="/admin/clientes/reenviaSenha/{{$cliente->id}}" class="btn btn-default btn-block">Reenviar senha de resgate </a>
                            </div>
                        </div>
                    </div>

                    
                    
                    
                </div>

                <div class="row" >

                    <hr>
                    <h2 class="intro-text text-center">
                        <strong>Pontos válidos</strong>
                    </h2>
                    <hr>

                    <table class="table">
                        <thead>
                            <tr>
                                <td class="text-center">Data</td>
                                <td class="text-center">Produto</td>
                                <td class="text-center">Vencimento</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="ponto in pontos">
                                <td class="text-center">@{{ponto.data_coleta}}</td>
                                <td class="text-center">@{{ponto.produto}}</td>
                                <td class="text-center">@{{ponto.vencimento}}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="row" >

                    <hr>
                    <h2 class="intro-text text-center">
                        <strong>Vouchers válidos</strong>
                    </h2>
                    <hr>

                    <table class="table">
                        <thead>
                            <tr>
                                <td class="text-center">Data</td>
                                <td class="text-center">Produto</td>
                                <td class="text-center">Vencimento</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="voucher in vouchers">
                                <td class="text-center">@{{voucher.data_voucher}}</td>
                                <td class="text-center">@{{voucher.produto}}</td>
                                <td class="text-center">@{{voucher.vencimento}}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="row" >

                    <hr>
                    <h2 class="intro-text text-center">
                        <strong>Vouchers utilizados</strong>
                    </h2>
                    <hr>

                    <table class="table">
                        <thead>
                            <tr>
                                <td class="text-center">Data</td>
                                <td class="text-center">Produto</td>
                                <td class="text-center">Data utilizado</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="voucher in vouchersUtilizados">
                                <td class="text-center">@{{voucher.data_voucher}}</td>
                                <td class="text-center">@{{voucher.produto}}</td>
                                <td class="text-center">@{{voucher.data_utilizado}}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                

            </div>
        </div>
    </div>


    @section('scripts')
	    @parent
	        
		<script type="text/javascript">


                $('.phone').mask("(00) 0 0000-0000");

                Vue.config.debug = true;
                Vue.http.headers.common['X-CSRF-TOKEN'] = $('input[name="_token"]').val();
                var vm = new Vue({
                    el: '#elCliente',
                    data: 
                    {
                        interactions: {
                            
                        },
                        pontos: JSON.parse('{!!$pontosAll->toJson()!!}'),
                        vouchers: JSON.parse('{!!$vouchers->toJson()!!}'),
                        vouchersUtilizados: JSON.parse('{!!$vouchersUtilizados->toJson()!!}')
                    },
                    ready: function(){

                    }
                });


		</script>

	@stop

@stop