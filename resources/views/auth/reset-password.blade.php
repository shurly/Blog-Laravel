@extends('auth.templates.template')

@section('content-login')


            {!! Form::open(['url' => '/reset-password', 'class' => 'form-login']) !!}

            {!! Form::hidden('token', $token) !!}
            {!! Form::email('email', null, ['placeholder' => 'E-mail:']) !!}
            {!! Form::password('password', ['placeholder' => 'Senha:']) !!}
            {!! Form::password('password_confirmation', ['placeholder' => 'Confirme a Senha:']) !!}

            {!! Form::submit('Resetar', ['class' => 'btn-login']) !!}

            <a href="{{ url('/login') }}" class="rel-pass">Login?</a>

        {!! Form::close() !!}
@endsection
