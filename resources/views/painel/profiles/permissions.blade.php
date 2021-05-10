@extends('painel.templates.template')
@section('content')

    <div class="bred">
        <a href="{{url('/painel')}}" class="bred">Home ></a>
        <a href="{{url('/painel/perfis')}}" class="bred">Perfis</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">Usuários do Perfil: <b>{{$profile->name}}</b></h1>
    </div>

    <div class="content-din bg-white">

        <div class="form-search">

            {!! Form::open(['route' => ['profile.permissions.search', $profile->id], 'class' => 'form form-inline']) !!}
                {!! Form::text('key-search', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}

                {!! Form::submit('Filtrar', ['class' => 'btn']) !!}
            {!! Form::close() !!}
        </div>

        <div class="class-btn-insert">
            <a href="{{route('profiles.permissions.list', $profile->id)}}" class="btn-insert">
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
                <th>Label</th>
                <th width="150">Ações</th>
            </tr>

            @forelse($permissions as $permission)
                <tr>
                    <td>{{$permission->name}}</td>
                    <td>{{$permission->label}}</td>
                    <td>
                        <a href="{{ route('profiles.permissions.delete', [$profile->id, $permission->id]) }}" class="delete"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i>Excluir</a>
                    </td>
                </tr>
            @empty
                <p>Nenhum perfil cadastrado</p>
            @endforelse
        </table>


    </div><!--Content Dinâmico-->
@endsection
