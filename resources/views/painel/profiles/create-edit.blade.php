@extends('painel.templates.template')
@section('content')

    <div class="bred">
        <a href="{{url('/painel')}}" class="bred">Home ></a>
        <a href="{{url('/painel/perfis')}}" class="bred">Perfis</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">Gestão de Perfis: <b>{{ $data->name ?? 'Novo' }}</b></h1>
    </div>

    <div class="content-din">


        @if(isset($errors) && count($errors) > 0)
            <div class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach
            </div>
        @endif


        @if(isset($data))

            {{ Form::model($data, ['route' => ['perfis.update', $data->id], 'class' => 'form form-search form-ds', 'method' => 'put']) }}

        @else

            {{ Form::open(['route'=>'perfis.store', 'class' => 'form form-search form-ds']) }}

        @endif

        <div class="form-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('label', null, ['class' => 'form-control', 'placeholder' => 'Label:']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Enviar', ['class' => 'btn']) !!}
        </div>

    </div><!--Content Dinâmico-->




    {{ Form::close() }}
@endsection
