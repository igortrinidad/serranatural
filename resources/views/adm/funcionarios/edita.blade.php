@extends('adm.funcionarios.formulario')

@section('title')
Edita funcionario
@stop

@section('action')

	<form action="{{route('admin.funcionarios.update', $funcionario->id)}}" class="" method="POST">

@stop