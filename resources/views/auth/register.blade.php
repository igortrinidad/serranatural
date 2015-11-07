<!-- resources/views/auth/register.blade.php -->

@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Novo usuário</h1>

<div class="panel panel-default">
        <div class="panel-heading"><h5>Dados do usuário</h5></div>
        <div class="panel-body">

        <form method="POST" action="/auth/register">
            {!! csrf_field() !!}

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control">
            </div>
            <br />
            <div class="form-group">
                <label>Tipo usuario</label>
                <input type="text" name="user_type" value="{{ old('user_type') }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>

    </div>
</div>

@stop