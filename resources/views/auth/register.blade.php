<!-- resources/views/auth/register.blade.php -->

@extends('layout/admin')

@section('conteudo')

<form method="POST" action="/auth/register">
    {!! csrf_field() !!}

    <div>
        Name
        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
    </div>

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}" class="form-control">
    </div>
    <br />
    <div>
        Tipo usuario
        <input type="text" name="tipo_usuario" value="{{ old('tipo_usuario') }}" class="form-control">
    </div>
    <div>
        Password
        <input type="password" name="password" class="form-control">
    </div>

    <div>
        Confirm Password
        <input type="password" name="password_confirmation" class="form-control">
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </div>
</form>

@stop