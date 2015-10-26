;(function($)
{
	'use strict';
	$(document).ready(function()
	{
		window.console.log('executado está');
		var $clientes = $('#clientes')

		$clientes.select2();

		$('#summernote').summernote({
		height: "350px"
	});
	
	});

	var postForm = function() {
	var content = $('textarea[name="content"]').html($('#summernote').code());
}

})(window.jQuery);

//# sourceMappingURL=clientes.js.map
