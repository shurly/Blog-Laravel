@extends('auth.templates.template')

@section('content-login')

{!! Form::open(['url' => '/forgot-password', 'class' => 'form-login']) !!}

{!! Form::email('email', null, ['placeholder' => 'E-mail:']) !!}

{!! Form::submit('Acessar', ['class' => 'btn-login']) !!}

<a href="{{ url('/login') }}" class="rel-pass">Login?</a>

{!! Form::close() !!}
@endsection
