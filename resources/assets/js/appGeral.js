$(function(){
	    var options = new Array();
	    options['language'] = 'pt-BR';
	    options['format'] = 'dd/mm/yyyy';
	    options['todayHighlight'] = 'true';
	    options['autoclose'] = 'true';
	    $('.datepicker').datepicker(options);
	});

$(function(){
	    var options = new Array();
	    options['language'] = 'pt-BR';
	    options['format'] = 'mm/yyyy';
	    options['todayHighlight'] = 'true';
	    options['autoclose'] = 'true';
	    $('.dataMesAno').datepicker(options);
	});

//configurações mascara
$('.phone_with_ddd').mask('(00) 0000-0000');
$('.cpf').mask('000.000.000-00');
$('.dataCompleta').mask('00/00/0000');
$('.dataMesAno').mask('00/0000');
$('.cep').mask('00000-000');
$('.hora').mask('00:00');
$('.maskValor').mask("#.##0,00", {reverse: true});

 $('div.alert').not('.alert-important').delay(3500).fadeOut();
