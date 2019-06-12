$('.phone_with_ddd').mask('(00) 0000-0000');


$('#retorno').attr('onload',function(){
        $( ".painel_teste" ).fadeIn();
        $( "#escurece" ).fadeIn();
    });

    

    setTimeout(function(){
        $( ".painel_teste" ).fadeOut();
        $( "#escurece" ).fadeOut();

    }, 5000);

    $("#fecha").click(function(){
        $( ".painel_teste" ).fadeOut();
        $( "#escurece" ).fadeOut();
    });

$(".botao").click(function(){
        $( "#loading" ).fadeIn();
        $( "#escurece" ).fadeIn();

$(function() {
        var $elie = $(".fa-spinner"), degree = 0, timer;
        rotate();
        function rotate() {

            $elie.css({ WebkitTransform: 'rotate(' + degree + 'deg)'});  
            $elie.css({ '-moz-transform': 'rotate(' + degree + 'deg)'});                      
            timer = setTimeout(function() {
                ++degree; rotate();
            },5);
        }
        }); 
setTimeout(function(){
        $( "#loading" ).fadeOut();
        $( "#escurece" ).fadeOut();
    }, 5000);

    });

setTimeout(function(){
        location.reload();
    }, 500000);