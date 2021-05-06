@extends('painel.templates.template')
@section('content')

    <div class="bred">
        <a href="{{url('/painel')}}" class="bred">Home ></a>
        <a href="{{url('/painel/perfis')}}" class="bred">Perfis</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">Listagem dos Perfis</h1>
    </div>

    <div class="content-din bg-white">

        <div class="form-search">

            {!! Form::open(['route' => 'perfis.search', 'class' => 'form form-inline']) !!}
                {!! Form::text('key-search', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}

                {!! Form::submit('Filtrar', ['class' => 'btn']) !!}
            {!! Form::close() !!}
        </div>

        <div class="class-btn-insert">
            <a href="{{url('/painel/perfis/create')}}" class="btn-insert">
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
                <th width="300">Ações</th>
            </tr>

            @forelse($data as $profile)
                <tr>
                    <td>{{$profile->name}}</td>
                    <td>{{$profile->label}}</td>
                    <td>
                        <a href="{{route('perfis.edit', $profile->id)}}" class="edit "><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>Editar</a>
                        <a href="{{ route('perfis.show', $profile->id) }}" class="delete"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>Visualizar</a>
                        <a href="{{ route('profile.users', $profile->id) }}" class="edit"><i class="fa fa-id-card"></i> Usuários</a>
                        <a href="{{ route('permissoes.perfis', $profile->id) }}" class="delete"><i class="fa fa-unlock-alt"></i> Permissões</a>
                    </td>
                </tr>
            @empty
                <p>Nenhum perfil cadastrado</p>
            @endforelse
        </table>

        @if(isset ($dataForm))
            {!! $data->appends($dataForm)->links() !!}
        @else
            {!! $data->links()  !!}
        @endif

    </div><!--Content Dinâmico-->
@endsection
