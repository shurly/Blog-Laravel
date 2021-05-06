@inject('categories', 'App\Models\Category')

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{$title ?? 'Blog Shirlei'}}</title>

    <!--Bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!--CSS Person-->
    <link rel="stylesheet" href="{{url ('assets/site/css/especializati.css')}}">

    <!--CSS Person-->
    <link rel="stylesheet" href="{{url ('assets/site/css/especializati-reset.css')}}">

    <!--CSS Person-->
    <link rel="stylesheet" href="{{url ('assets/site/css/especializati-responsive.css')}}">

    <!--Favicon-->
    <link rel="icon" type="image/png" href="{{url('assets/all/imgs/favicon.png')}}">
</head>
<body>

<header class="top">
    <div class="container">
        <div class="logo col-md-6">
            <a href="{{url('/')}}">
                <img src="{{url('assets/site/imgs/logo-especializati.png')}}" alt="EspecializaTi" class="logo">
            </a>
        </div>

        <div class="form col-md-6">
                {!! Form::open(['route' => 'search.blog', 'class' => 'form form-search form-inline' ]) !!}
                {!! Form::text('key-search', null, ['placeholder' => 'Pesquisar?', 'class' => 'form-control'] ) !!}
                <button>
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            {!! Form::close() !!}
        </div>
    </div><!--End Container-->
</header><!--End Header TOP-->


<div class="menu">
    <div class="container container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{url('/')}}">Home</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Categorias <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach( $categories->all() as $category)
                            <li><a href="{{url("/categorias/{$category->url}")}}">{{$category->name}}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li><a href="{{url('empresa')}}">Empresa</a></li>
                <li><a href="{{url('contato')}}">Contato</a></li>

            </ul>

        </div><!--/.nav-collapse -->
    </div>
</div><!--End Menu-->


<div class="container">

    @yield('content')

</div><!--End Container-->


<footer class="footer">
    <p class="footer">Todos os direitos reservados - Shirlei Domingos {{date('Y')}}</p>
</footer>


<!--jQuery-->
<script src="{{url('assets/all/js/jquery-3.1.1.min.js')}}"></script>

@stack('scripts')

<!--Bootstrap .js-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>
