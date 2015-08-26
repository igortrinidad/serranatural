<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/votacao', 'VotacaoController@index');
Route::post('/votacao/addVotoCliente', 'VotacaoController@addVotoCliente');
Route::post('/votacao/addVotoCadastro', 'VotacaoController@addVotoCadastro');

Route::get('/', function () {
    return view('welcome');
});

