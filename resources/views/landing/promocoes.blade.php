@extends('landing/template/landing')

@section('conteudo')

<style>


</style>

	        <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="box">
                        <div class="col-lg-12 text-center">

                            @include('flash::message')

                        	<hr>
                            <h2 class="intro-text text-center">
                                <strong>Promoções</strong>
                            </h2>
                            <hr>

                            <p>Confira abaixo as promoções válidas da Serra Natural.</p>

                        </div>
                    </div>
                </div>
            </div>

            @foreach($promocoes as $promo)

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="box">
                        <div class="col-lg-12 text-center">

                            <hr>
                            <h2 class="intro-text text-center">
                                <strong>{{$promo->titulo}}</strong>
                            </h2>
                            <hr>
                            
                            @if($promo->foto)
                            <img class="img-responsive img-full" src="https://s3.amazonaws.com/serranatural-production/{{$promo->foto}}" alt="{{$promo->titulo}}">
                            <br>
                            @endif

                            <label>Validade</label>
                            <p>Início: {{$promo->inicio}} | Término: {{$promo->fim}}</p>
                            <label>Descrição</label>
                            <p>{!!$promo->descricao !!}</p>

                            <div class="" data-toggle="collapse" data-target="#regulamento{{$promo->id}}">
                                <label>Regulamento</label>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                            <div id="regulamento{{$promo->id}}" class="collapse">
                                <p>{!! $promo->regulamento !!}</p>
                            </div>

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