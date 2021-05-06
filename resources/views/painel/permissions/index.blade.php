@extends('painel.templates.template')
@section('content')

    <div class="bred">
        <a href="{{url('/painel')}}" class="bred">Home ></a>
        <a href="{{url('/painel/permissoes')}}" class="bred">Permissões</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">Listagem das Permissões</h1>
    </div>

    <div class="content-din bg-white">

        <div class="form-search">

            {!! Form::open(['route' => 'permissions.search', 'class' => 'form form-inline']) !!}
                {!! Form::text('key-search', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}

                {!! Form::submit('Filtrar', ['class' => 'btn']) !!}
            {!! Form::close() !!}
        </div>

        <div class="class-btn-insert">
            <a href="{{route('permissoes.create')}}" class="btn-insert">
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

            @forelse($data as $permission)
                <tr>
                    <td>{{$permission->name}}</td>
                    <td>{{$permission->label}}</td>
                    <td>
                        <a href="{{route('permissoes.edit', $permission->id)}}" class="edit "><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>Editar</a>
                        <a href="{{ route('permissoes.show', $permission->id) }}" class="delete"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>Visualizar</a>
                        <a href="{{ route('permissoes.perfis', $permission->id) }}" class="delete"><i class="fa fa-users"></i> Perfis</a>
                    </td>
                </tr>
            @empty
                <p>Nenhuma permissão cadastrada</p>
            @endforelse
        </table>

        @if(isset ($dataForm))
            {!! $data->appends($dataForm)->links() !!}
        @else
            {!! $data->links()  !!}
        @endif

    </div><!--Content Dinâmico-->
@endsection
