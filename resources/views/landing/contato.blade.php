@extends('landing/template/landing')

@section('conteudo')

    <div class="row">
        <div class="box">
            <div class="col-lg-12">

                @include('flash::message')

                <hr>
                <h2 class="intro-text text-center">
                    <strong>Contato</strong>
                </h2>
                <hr>
                <p>Compartilhe conosco suas dúvidas ou sugestões.</p>

                <form role="form" method="POST" action="/contato/send">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Telefone</label>
                            <input type="tel" name="telefone" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-lg-12">
                            <label>Mensagem</label>
                            <textarea class="form-control" name="mensagem" rows="6" required></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-default">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @section('scripts')
	    @parent
	        
		<script type="text/javascript">

		</script>

	@stop

@stop