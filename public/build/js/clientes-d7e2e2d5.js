;(function($)
{
	'use strict';
	$(document).ready(function()
	{
		window.console.log('JS clientes rodando ok, ufa!');
		var $clientes = $('#clientes')

		$clientes.select2();

		$('#summernote').summernote({
			height: "350px"
	});

		$("#clientes").change(function() 
		{
			var id = $(this).val();
		 	var href = '/admin/clientes/' + id + '/mostra';
		    //adiciona o valor do id recebido como parametro na funcao
			$('#linkCliente').prop("href", href);
		});
	
	});

	var postForm = function() {
	var content = $('textarea[name="content"]').html($('#summernote').code());
}

})(window.jQuery);

//# sourceMappingURL=clientes.js.map
