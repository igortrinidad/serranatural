@extends('landing/template/landing')

@section('conteudo')

	@include('errors.messages')

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

                    <h1>Em breve</h1>

                </div>
            </div>
        </div>


    @section('scripts')
	    @parent
	        
		<script type="text/javascript">

		</script>

	@stop

@stop