formatarValor = function(element) {
    element.priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        thousandsSeparator: '.'        
    });
};

formatarValor($('.dinheiro'));

