@extends('landing/template/landing')

@section('conteudo')

    <style>
        
        .insta-feed-serra{
            width: 200px;
            transition: 1s;
        }

        .insta-feed-serra:hover{
            opacity: 0.8;
        }

    </style>
    <div class="row">
        <div class="box">
            <div class="col-lg-12">

                @include('flash::message')

                <hr>
                <h2 class="intro-text text-center">
                    <strong>Instagram</strong>
                </h2>
                <hr>

                <p class="text-center">Acompanhe nossas novidades e promoções: @serranatural.</p>

                <div class="text-center" id="instafeed"></div>
            </div>
        </div>
    </div>


    @section('scripts')
	    @parent
	        
		<script type="text/javascript">
            var feed = new Instafeed({
                get: 'user',
                userId: '1143444084',
                accessToken: '1143444084.1677ed0.058f960556c24607805cd4de17f89f31',
                template: '<a href="@{{link}}" target="_blank"><img src="@{{image}}" class="insta-feed-serra" /></a>'
            });
            feed.run();
        </script>

	@stop

@stop