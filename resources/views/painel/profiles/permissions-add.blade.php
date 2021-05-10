@extends('painel.templates.template')
@section('content')

    <div class="bred">
        <a href="{{url('/painel')}}" class="bred">Home ></a>
        <a href="{{url('/painel/perfis')}}" class="bred">Perfis</a>
        <a href="{{route('profile.permissions', $profile->id)}}" class="bred">{{$profile->name}}</a>

    </div>

    <div class="title-pg">
        <h1 class="title-pg">Adicionar novo usuário ao perfil: <b>{{ $profile->name }}</b></h1>
    </div>

    <div class="content-din">


        @if(isset($errors) && count($errors) > 0)
            <div class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach
            </div>
        @endif

        {{ Form::open(['route'=>['profiles.permissions.add', $profile->id], 'class' => 'form form-search form-ds']) }}
        @foreach($users as $user)
                <div class="form-group">
                   <label>
                       {!! Form::checkbox('users[]', $user->id) !!}
                       {{$user->name}}
                   </label>
                </div>
        @endforeach
            <div class="form-group">
                {!! Form::submit('Enviar', ['class' => 'btn']) !!}
            </div>

    </div><!--Content Dinâmico-->




    {{ Form::close() }}
@endsection
