@extends('landing/template/landing')

@section('conteudo')

	@include('errors.messages')

	        <div class="row">
                <div class="box">
                    <div class="col-lg-12 text-center">

                    	<hr>
                        <h2 class="intro-text text-center">
                            <strong>Promoções</strong>
                        </h2>
                        <hr>

                        <p>Confira abaixo todas as promoções válidas que a Serra Natural oferece para você.</p>

                    </div>
                </div>
            </div>

            @foreach($promocoes as $promo)

            <div class="row">
                <div class="box">
                    <div class="col-lg-12 text-center">

                        <hr>
                        <h2 class="intro-text text-center">
                            <strong>{{$promo->titulo}}</strong>
                        </h2>
                        <hr>
                        
                        @if($promo->foto)
                        <img class="img-responsive img-full" src="/uploads/promocoes/{{$promo->foto}}" alt="{{$promo->titulo}}">
                        <br>
                        @endif

                        <label>Validade</label>
                        <p>Início: {{$promo->inicio}} | Término: {{$promo->fim}}</p>
                        <label>Descrição</label>
                        <p>{{$promo->descricao}}</p>

                        <div class="" data-toggle="collapse" data-target="#regulamento{{$promo->id}}">
                            <label>Regulamento</label>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div id="regulamento{{$promo->id}}" class="collapse">
                            <p>{{$promo->regulamento}}</p>
                        </div>

                    </div>
                </div>
            </div>

            @endforeach


    @section('scripts')
	    @parent
	        
		<script type="text/javascript">

		</script>

	@stop

@stop