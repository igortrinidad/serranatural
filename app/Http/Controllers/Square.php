<?php

namespace serranatural\Http\Controllers;

trait Square {

	public function headers()
    {
        $token = 'EAAAEHz3dirTeuQQe4xaEE1OFBcnRO35f38p1u8GYEaqHWGfQDD_kN9DhmEAHCO8';
        \Unirest\Request::defaultHeader("Authorization", "Bearer ".$token);
        \Unirest\Request::defaultHeader("Content-Type", "application/json");
    }


    public function squareItemsList()
	{
		$this->headers();
		
        $response = \Unirest\Request::get("https://connect.squareup.com/v1/me/items");

        $produtosSquare = $response->body;

        return $produtosSquare;
	}

    public function squareItemsForSelect()
    {
        $produtos = $this->squareItemsList();

        foreach ($produtos as $key => $value) {
            $result[$value->id] = $value->name;
        }

        return $result;
    }

	public function payments($begin, $end)
	{

		$this->headers();

		$response = \Unirest\Request::get("https://connect.squareup.com/v1/me/payments?".$begin.'&'.$end);
		
		return $response;
	}

    public function paymentsResume($begin, $end)
    {
        $this->headers();

        $response = \Unirest\Request::get("https://connect.squareup.com/v1/me/payments?".$begin.'&'.$end);

        $valor = 0;
        $tax = 0;
        $vendas = [];
        $index = 0;
        $vendaLiquida = 0;
        if(is_array($response->body)){
               foreach($response->body as $body) {
                $valor = $valor + $body->net_total_money->amount;
                $tax = $tax + $body->tax_money->amount;
                $vendaLiquida = $valor - $tax;
                $vendas[$index]['id'] = $body->id;
                $vendas[$index]['valor'] = $body->total_collected_money->amount;
                $vendas[$index]['data'] = $body->created_at;
                $vendas[$index]['url'] = $body->receipt_url;
            $index++;
            } 
        }
        
        $return['vendaBruta'] = number_format(($valor/100),2);
        $return['taxa_dia'] = number_format(($tax/100),2);
        $return['venda_liquida'] = number_format(($vendaLiquida/100),2);
        $return['begin_time'] = $begin;
        $return['end_time'] = $end;
        $return['vendas_resumo'] = $vendas;

        return $venda_total = $return;
        
    }
}