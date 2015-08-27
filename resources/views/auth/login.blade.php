@extends('layout/adm')



@section('conteudo')
        <br><br>
        <div class="row">
            <div class="col-md-3"></div>

            <div class="col-md-6">

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="/auth/login">
    {!! csrf_field() !!}

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}" class="form-control">
    </div>

    <div>
        Password
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div>
        <input type="checkbox" name="remember" class="form-control"> Lembrar-me
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Logins</button>
    </div>
</form>

        </div>
        </div>

@stop