<?php

function inserePreferencias($id, $opcao){


	$consultaPreferencias = DB::table('preferenciaClientes')->where('id', '=', $id)->where('preferencias', '=', $opcao);

	if($consultaPreferencias == ''){

		DB::table('preferenciaClientes')->insert([

			'clienteId' => $id,
			'preferencias' => $opcao

			]);
	}

	return true;

}