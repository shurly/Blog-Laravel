@extends('painel.templates.template')
@section('content')

    <div class="bred">
        <a href="{{url('/painel')}}" class="bred">Home ></a>
        <a href="{{url('/painel/categorias')}}" class="bred">Categorias</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">Gestão de Categoria: <b>{{ $data->name ?? 'Nova' }}</b></h1>
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

            {{ Form::model($data, ['route' => ['categorias.update', $data->id], 'class' => 'form form-search form-ds', 'files' => true, 'method' => 'put']) }}

        @else

            {{ Form::open(['route'=>'categorias.store', 'class' => 'form form-search form-ds', 'files' => true]) }}

        @endif

        <div class="form-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}
        </div>
        <div class="form-group">
            {!! Form::email('url', null, ['class' => 'form-control', 'placeholder' => 'URL:']) !!}
        </div>
        <div class="form-group">
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Descrição:']) !!}
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
