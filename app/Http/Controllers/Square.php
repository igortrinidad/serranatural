<?php

namespace serranatural\Http\Controllers;

trait Square {

	public function headers()
    {
        $token = '5bDwfv16l7I02iePbc2GcQ';
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
}