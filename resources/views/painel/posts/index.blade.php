@extends('painel.templates.template')
@section('content')

    <div class="bred">
        <a href="{{url('/painel')}}" class="bred">Home ></a>
        <a href="{{url('/painel/posts')}}" class="bred">Posts</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">Listagem dos Posts</h1>
    </div>

    <div class="content-din bg-white">

        <div class="form-search">

            {!! Form::open(['route' => 'posts.search', 'class' => 'form form-inline']) !!}
            {!! Form::text('key-search', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}

            {!! Form::submit('Filtrar', ['class' => 'btn']) !!}
            {!! Form::close() !!}
        </div>

        <div class="class-btn-insert">
            <a href="{{url('/painel/posts/create')}}" class="btn-insert">
                <span class="glyphicon glyphicon-plus"></span>
                Cadastrar
            </a>
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success hide-msg" style="float: left; width: 100%; margin: 10px 0px;">
                {!! Session::get('success')  !!}
            </div>
        @endif

        <table class="table table-striped">
            <tr>
                <th>Nome</th>

                <th width="200">Ações</th>
            </tr>

            @forelse($data as $post)


                    <tr>
                        <td>{{$post->title}}</td>

                        <td>
                            @can('update', $post)
                            <a href="{{route('posts.edit', $post->id)}}" class="edit ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg>
                                Edit</a>
                            @endcan
                            <a href="{{ route('posts.show', $post->id) }}" class="delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path
                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                                </svg>Visualizar</a>
                        </td>
                    </tr>

            @empty
                <p>Nenhum posts cadastrado</p>
            @endforelse
        </table>

        @if(isset ($dataForm))
            {!! $data->appends($dataForm)->links() !!}
        @else
            {!! $data->links()  !!}
        @endif

    </div><!--Content Dinâmico-->
@endsection
