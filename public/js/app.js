$(function(){var a=new Array;a.language="pt-BR",a.format="dd/mm/yyyy",a.todayHighlight="true",a.autoclose="true",$(".datepicker").datepicker(a)}),$(function(){var a=new Array;a.language="pt-BR",a.format="mm/yyyy",a.todayHighlight="true",a.autoclose="true",$(".dataMesAno").datepicker(a)}),$(".phone_with_ddd").mask("(00) 00000-0000"),$(".cpf").mask("000.000.000-00"),$(".dataCompleta").mask("00/00/0000"),$(".dataMesAno").mask("00/0000"),$(".cep").mask("00000-000"),$(".hora").mask("00:00"),$(".maskValor").mask("#.##0,00",{reverse:!0}),$("div.alert").not(".alert-important").delay(3500).fadeOut(),moment.locale("pt-BR");