<!-- resources/views/auth/register.blade.php -->

@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Novo usuário</h1>

<div class="col-md-3">
    
</div>

<div class="col-md-6">
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
                <label>Senha</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label>Confirma senha de acesso</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="form-group">
                <label>Senha de operação (caixa)</label>
                <input type="password" name="senha_operacao" class="form-control">
            </div>

            <div class="form-group">
                Tipo de usuário
                <select name="user_type">
                    <option value="operacao">Operação</option>
                    <option value="consulta">Consulta</option>
                    <option value="admin">Admin</option>
                    <option value="super_adm">Super admin</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>

    </div>
</div>
</div>



@stop