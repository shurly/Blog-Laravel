@extends('painel.templates.template')
@section('content')

    <div class="bred">
        <a href="{{url('/painel')}}" class="bred">Home ></a>
        <a href="{{url('/painel/usuarios')}}" class="bred">Usuários > Meu Perfil</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">Meu Perfil</h1>
    </div>
    <div class="content-din">


        @if(isset($errors) && count($errors) > 0)
            <div class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach
            </div>
        @endif

        @if(Session::has('success'))
            <div class="alert alert-success hide-msg" style="float: left; width: 100%; margin: 10px 0px;">
                {{ Session::get('success') }}
            </div>
        @endif


        {{ Form::model($user, ['route' => ['profile.update', $user->id], 'class' => 'form form-search form-ds', 'files' => true]) }}


        <div class="form-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}
        </div>
        <div class="form-group">
            {!! Form::hidden('email', null) !!}
        </div>
        <div class="form-group">
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Senha:']) !!}
        </div>
        <div class="form-group">
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirmar Senha:']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('facebook', null, ['class' => 'form-control', 'placeholder' => 'Facebook:']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('twitter', null, ['class' => 'form-control', 'placeholder' => 'Twitter:']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('github', null, ['class' => 'form-control', 'placeholder' => 'Github:']) !!}
        </div>
        <div class="form-group">
            {!! Form::textarea('bibliography', null, ['class' => 'form-control', 'placeholder' => 'Biografia:']) !!}
        </div>
        <div class="form-group">
            {!! Form::file('image', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Enviar', ['class' => 'btn']) !!}
        </div>

    </div><!--Content Dinâmico-->




    {{ Form::close() }}
@endsection
