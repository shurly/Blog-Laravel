@extends('painel.templates.template')
@section('content')

    <div class="bred">
        <a href="{{url('/painel')}}" class="bred">Home ></a>
        <a href="{{url('/painel/posts')}}" class="bred">Posts</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">Gestão de Posts: <b>{{ $data->title ?? 'Novo Post' }}</b></h1>
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

            {{ Form::model($data, ['route' => ['posts.update', $data->id], 'class' => 'form form-search form-ds', 'files' => true, 'method' => 'put']) }}

        @else

            {{ Form::open(['route'=>'posts.store', 'class' => 'form form-search form-ds', 'files' => true]) }}

        @endif

        <div class="form-group">
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Título do Post:']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'URL:']) !!}
        </div>
        <div class="form-group">
            Selecione a categoria:
            {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::date('date', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::time('hour', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>
                {!! Form::checkbox('featured', null) !!}
                Destaque?
            </label>
        </div>
        <div class="form-group">
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Descrição:']) !!}
        </div>
        <div class="form-group">
            Selecione o status do Post
            {!! Form::select('status', ['A' => 'Ativo', 'R' => 'Rascunho'], null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::file('image', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Enviar', ['class' => 'btn']) !!}
        </div>

    </div><!--Content Dinâmico-->




    {{ Form::close() }}
@endsection

@push('scripts')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea'
        });
    </script>
@endpush
