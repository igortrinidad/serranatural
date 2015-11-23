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
		'/../bower_components/select2/dist/js/select2.js',
		'/../bower_components/summernote/dist/summernote.js',
		'/../bower_components/jrumble/jquery.jrumble.js',
		'/../bower_components/lightbox-rotate/lightbox-plus-jquery.js',
		'/../bower_components/lightbox-rotate/lightbox-rotate.js',
		'/../bower_components/moment/moment.js',
		'/../bower_components/bootstrap-daterangepicker/daterangepicker.js',
		'sb-admin-2.js',
		'appGeral.js',
		'notify.js',

		], 'public/js/vendor.js');

	mix.scripts([
		'appGeral.js'
		], 'public/js/app.js');

	mix.scripts([
		'clientes.js'
		], 'public/js/clientes.js');

	mix.scripts([
		'financeiro.js'
		], 'public/js/financeiro.js');

	mix.scripts([
		'financeiro.js'
		], 'public/js/funcionarios.js');

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
		'/../bower_components/select2/dist/css/select2.css',
		'/../bower_components/select2-bootstrap-css/select2-bootstrap.css',
		'/../bower_components/summernote/dist/summernote.css',
		'/../bower_components/lightbox-rotate/lightbox-rotate.css',
		'/../bower_components/bootstrap-daterangepicker/daterangepicker.css',
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

	mix.version(['js/app.js', 'js/votacao.js', 'js/clientes.js', 'js/financeiro.js', 'js/funcionarios.js'])
});
