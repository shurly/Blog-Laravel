@extends('painel.templates.template')
@section('content')

    <div class="bred">
        <a href="{{url('/painel')}}" class="bred">Home ></a>
        <a href="{{url('/painel/perfis')}}" class="bred">Perfis</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">Perfis: <b>{{ $data->name }}</b></h1>
    </div>

    <div class="content-din">


        @if(isset($errors) && count($errors) > 0)
            <div class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach
            </div>
        @endif


        <h2><strong>Nome: </strong>{{ $data->name }}</h2>
        <h2><strong>Label: </strong>{{ $data->label }}</h2>


            {{ Form::open(['route'=> ['perfis.destroy', $data->id], 'class' => 'form form-search form-ds', 'method' => 'DELETE']) }}
        <div class="form-group">
            {!! Form::submit("Excluir Perfil: $data->name", ['class' => 'btn btn-danger']) !!}
        </div>

    </div><!--Content Dinâmico-->




    {{ Form::close() }}
@endsection
