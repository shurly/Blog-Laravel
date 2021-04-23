@extends('auth.templates.template')

@section('content-login')



    {!! Form::open(['url' => '/login', 'class' => 'form-login']) !!}

    <
    {!! Form::email('email', null, ['placeholder' => 'E-mail:']) !!}
    {!! Form::password('password', ['placeholder' => 'Senha:']) !!}

    {!! Form::submit('Acessar', ['class' => 'btn-login']) !!}

    <a href="{{ url('/forgot-password') }}" class="rel-pass">Recuperar Senha?</a>

    {!! Form::close() !!}
@endsection
