@extends('painel.templates.template')
@section('content')

    <div class="bred">
        <a href="{{url('/painel')}}" class="bred">Home ></a>
        <a href="{{url('/painel/usuarios')}}" class="bred">Usuários</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">Usuário: <b>{{ $user->name }}</b></h1>
    </div>

    <div class="content-din">


        @if(isset($errors) && count($errors) > 0)
            <div class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach
            </div>
        @endif


        <h2><strong>Nome: </strong>{{ $user->name }}</h2>
        <h2><strong>Email: </strong>{{ $user->email }}</h2>
        <h2><strong>Facebook: </strong>{{ $user->facebook }}</h2>
        <h2><strong>Twitter: </strong>{{ $user->twitter }}</h2>
        <h2><strong>Github: </strong>{{ $user->github }}</h2>
        <h2><strong>Bibliografia: </strong>{{ $user->bibliography }}</h2>



            {{ Form::open(['route'=> ['usuarios.destroy', $user->id], 'class' => 'form form-search form-ds', 'method' => 'DELETE']) }}
        <div class="form-group">
            {!! Form::submit("Excluir Usuário: $user->name", ['class' => 'btn btn-danger']) !!}
        </div>

    </div><!--Content Dinâmico-->




    {{ Form::close() }}
@endsection
