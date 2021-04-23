<!DOCTYPE html>
<html>
<head>
    <title>{{$title ?? 'Dashboard do Blog'}}</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!--Fonts-->
    <link rel="stylesheet" href="{{url('assets/painel/css/font-awesome.css')}}">

    <!--CSS Person-->
    <link rel="stylesheet" href="{{url('assets/painel/css/especializati.css')}}">
    <link rel="stylesheet" href="{{url('assets/painel/css/especializati-reset.css')}}">

    <!--Favicon-->
    <link rel="icon" type="image/png" href="{{url('assets/all/imgs/favicon.png')}}">
</head>
<body>

<section class="menu">

    <div class="logo">
        <img src="{{url('assets/painel/imgs/icone-especializati.png')}}" alt="EspecializaTi" class="logo-painel">
    </div>

    <div class="list-menu">
        <ul class="menu-list">
            <li>
                <a href="{{ url('/painel') }}">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Home
                </a>
            </li>

            <li>
                <a href="{{ url('painel/usuarios') }}">
                    <i class="fa fa-id-card" aria-hidden="true"></i>
                    Usuários
                </a>
            </li>

            <li>
                <a href="{{ url('painel/categorias') }}">
                    <i class="fas fa-boxes" aria-hidden="true"></i>
                   Categorias
                </a>
            </li>
        </ul>
    </div>

</section><!--End Menu-->

<section class="content">
    <div class="top-dashboard">

        <div class="dropdown user-dash">
            <div class="dropdown-toggle" id="dropDownCuston" data-toggle="dropdown" aria-haspopup="true"
                 aria-expanded="true">
                <img src="{{url('assets/painel/imgs/user-carlos-ferreira.png')}}" alt="Carlos Ferreira" class="user-dashboard img-circle">
                <p class="user-name">Nome User</p>
                <span class="caret"></span>
            </div>
            <ul class="dropdown-menu dp-menu" aria-labelledby="dropDownCuston">
                <li><a href="#">Perfil</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </div>
    </div><!--Top Dashboard-->

    <div class="content-ds">




       @yield('content')


    </div><!--End Content DS-->

</section><!--End Content-->


<!--jQuery-->
<script src="{{url('assets/all/js/jquery-3.1.1.min.js')}}"></script>

<!-- Ocultar mensagem de sucesso depois de um tempo -->
<script>
    $(function(){
       setTimeout(" $('.hide-msg').fadeOut();", 3000)
    })
</script>

<!-- jS Bootstrap -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>
