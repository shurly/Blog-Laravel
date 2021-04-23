@extends('auth.templates.template')

@section('content-login')


        {!! Form::open(['url' => '/confirm-password', 'class' => 'form-login']) !!}

        {!! Form::password('password_confirmation', ['placeholder' => 'Confirme a Senha:']) !!}

        {!! Form::submit('Confirmar', ['class' => 'btn-login']) !!}

        <a href="{{ url('/login') }}" class="rel-pass">Login?</a>

        {!! Form::close() !!}
@endsection
