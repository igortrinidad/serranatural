@extends('landing/template/landing')

@section('conteudo')

	@include('errors.messages')

    <div id="elCardapio">
        

        @if($pratoDeHoje)
	    <div class="row">
            <div class="box">
                <div class="col-lg-12 text-center">

                	<hr>
                    <h2 class="intro-text text-center">
                        <strong>Prato de hoje</strong>
                    </h2>
                    <hr>

                    <h1>{{$pratoDeHoje->pratos->prato}}</h1>
                    <small>Acompanhamentos</small>
                    <p>{!! nl2br($pratoDeHoje->pratos->acompanhamentos) !!}</p>

                </div>
            </div>
        </div>
        @endif

        @if($pratoDeAmanha)
        <div class="row">
            <div class="box">
                <div class="col-lg-12 text-center">

                    <hr>
                    <h2 class="intro-text text-center">
                        <strong>Prato de amanhã</strong>
                    </h2>
                    <hr>

                    <h1>{{$pratoDeAmanha->pratos->prato}}</h1>
                    <small>Acompanhamentos</small>
                    <p>{!! nl2br($pratoDeAmanha->pratos->acompanhamentos) !!}</p>
                    
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="box">
                <div class="col-lg-12 text-center">

                    <hr>
                    <h2 class="intro-text text-center">
                        <strong>Cardápio</strong>
                    </h2>
                    <hr>
        
                    <button class="btn btn-default" v-for="menu in sections" @click="interactions.cardapioSelected = menu">@{{menu.name}}</button> 

                    <br>
                    <br>
                    <div v-for="menu in sections" class="row">
                        <div v-if="interactions.cardapioSelected == menu" transition="fade">
                            <div class="col-md-6 col-xs-12 ">
                                <img v-bind:src="menu.url1" width="80%" alt="Serra Natural"/>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <img :src="menu.url2" width="80%" alt="Serra Natural"/>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>

    </div>


    @section('scripts')
	    @parent
	        
		<script type="text/javascript">
                Vue.config.debug = true;
                Vue.http.headers.common['X-CSRF-TOKEN'] = $('input[name="_token"]').val();
                var vm = new Vue({
                    el: '#elCardapio',
                    data: 
                    {
                        interactions: {
                            cardapioSelected: {}
                        },
                        sections: [
                            {
                                url1: '/landing/cardapio/out-2016/CARDAPIO_2.png',
                                url2: '/landing/cardapio/out-2016/CARDAPIO_3.png',
                                name: 'Açaí'
                            },
                            {
                                url1: '/landing/cardapio/out-2016/CARDAPIO_4.png',
                                url2: '/landing/cardapio/out-2016/CARDAPIO_5.png',
                                name: 'Salada de Frutas'
                            },
                            {
                                url1: '/landing/cardapio/out-2016/CARDAPIO_6.png',
                                url2: '/landing/cardapio/out-2016/CARDAPIO_7.png',
                                name: 'Sucos especiais'
                            },
                            {
                                url1: '/landing/cardapio/out-2016/CARDAPIO_8.png',
                                url2: '/landing/cardapio/out-2016/CARDAPIO_9.png',
                                name: 'Sucos montados'
                            },
                            {
                                url1: '/landing/cardapio/out-2016/CARDAPIO_10.png',
                                url2: '/landing/cardapio/out-2016/CARDAPIO_11.png',
                                name: 'Café e comidinhas'
                            },
                            {
                                url1: '/landing/cardapio/out-2016/CARDAPIO_12.png',
                                url2: '/landing/cardapio/out-2016/CARDAPIO_13.png',
                                name: 'Smoothies'
                            },
                            {
                                url1: '/landing/cardapio/out-2016/CARDAPIO_14.png',
                                url2: '/landing/cardapio/out-2016/CARDAPIO_15.png',
                                name: 'Saladas'
                            },
                            {
                                url1: '/landing/cardapio/out-2016/CARDAPIO_16.png',
                                url2: '/landing/cardapio/out-2016/CARDAPIO_17.png',
                                name: 'Drinks'
                            },
                            {
                                url1: '/landing/cardapio/out-2016/CARDAPIO_21.png',
                                url2: '/landing/cardapio/out-2016/CARDAPIO_20.png',
                                name: 'Sandwichs'
                            }
                        ]
                    },
                    ready: function(){
                        var that = this

                        that.interactions.cardapioSelected = that.sections[0];
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