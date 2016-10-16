@extends('landing/template/landing')

@section('conteudo')

	@include('errors.messages')

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