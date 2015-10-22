var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.scripts([

		'/../bower_components/jquery/dist/jquery.js',
		'/../bower_components/bootstrap/dist/js/bootstrap.js',
		'/../bower_components/metisMenu/dist/metisMenu.js',
		'/../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
		'/../bower_components/jquery-mask-plugin/dist/jquery.mask.js',
		'/../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.pt-BR.js',
		'sb-admin-2.js',
		'appGeral.js',

		], 'public/js/vendor.js');

	mix.scripts([
		'appGeral.js'
		], 'public/js/app.js');

	mix.scripts([
		'votacao.js',
		'/../bower_components/jquery-easing/jquery.easing.js',
		'/../bower_components/bootstrap-toggle/js/bootstrap-toggle.js',
		], 'public/js/votacao.js');


	mix.styles([
		'/../bower_components/bootstrap/dist/css/bootstrap.css',
		'/../bower_components/font-awesome/css/font-awesome.css',
		'/../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css',
		'/../bower_components/metisMenu/dist/metisMenu.css',
		'/../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.standalone.css',
		'sb-admin-2.css',
		], 'public/css/vendor.css');

	mix.styles([

		'estilos/estilosAdmin.css'
		],'public/css/app.css');

	mix.styles([

		'/../bower_components/bootstrap-toggle/css/bootstrap-toggle.css',
		'estilos/votacao.css',
		'estilos/scrolling-nav.css',
		],'public/css/votacao.css');

	mix.styles('estilos/login.css', 'public/css/login.css');

	mix.version(['js/app.js', 'js/votacao.js'])
});
