<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/pace.js') }}"></script>
    <script src="{{ asset('js/handlebars.min.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body class="app header-fixed sidebar-fixed sidebar-lg-show">
@auth
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <img class="navbar-brand-full" src="/img/teste.png" width="70" height="50" alt="PUC Minas">
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
            </li>
            @if (Auth::user()->hasRole(['recepcao', 'admin']))
                <li class="nav-item px-3">
                    <a class="nav-link" href="{{ route('registrar.entrada') }}">Entrada Paciente</a>
                </li>

            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('pacientes.create') }}">Paciente</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('avaliacoes.create') }}">Avaliação</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('medicos.create') }}">Médicos</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('fisioterapeutas.create') }}">Fisioterapeutas/Recepção</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('fechamento-mensal.create') }}">Fechamento Mensal</a>
            </li>
            @endif
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="nav-icon fa fa-user-o"></i> Minha Conta</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Minha Conta</strong>
                    </div>
                    <a class="dropdown-item" href="{{ route('usuario.minha-conta') }}">
                        <i class="fa fa-wrench"></i> Configurações</a>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="fa fa-lock"></i> Logout</a>
                </div>
            </li>
        </ul>
    </header>
    <div class="app-body">
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title">{{Auth::user()->getRoleNames()[0]}}</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="nav-icon icon-speedometer"></i> Dashboard
                        </a>
                    </li>
                    @if (Auth::user()->hasRole(['recepcao', 'admin']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('registrar.entrada') }}">
                            <i class="nav-icon icon-login"></i> Registrar Entrada
                        </a>
                    </li>
                    @endif
                    <li class="nav-title">Sistema</li>
                    @if (Auth::user()->hasRole(['recepcao', 'admin']))
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fa fa-users"></i> Pacientes</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pacientes.index') }}">
                                    <i class="nav-icon fa fa-list"></i> Listar</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pacientes.create') }}">
                                    <i class="nav-icon fa fa-user-plus"></i> Cadastrar</a>
                            </li>

                        </ul>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole(['recepcao', 'admin']))
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fa fa-user-md"></i> Médicos</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('medicos.index') }}">
                                    <i class="nav-icon fa fa-list"></i> Listar</a>
                            </li>
                            <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('medicos.create') }}">
                                    <i class="nav-icon fa fa-user-plus"></i> Cadastrar</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fa fa-user-o"></i> Fisioterapeutas</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('fisioterapeutas.index') }}">
                                    <i class="nav-icon fa fa-list"></i> Listar</a>
                            </li>
                            <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('fisioterapeutas.create') }}">
                                    <i class="nav-icon fa fa-user-plus"></i> Cadastrar</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole(['admin']))
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fa fa-calendar-o"></i> Fechamento Mensal</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('fechamento-mensal.index') }}">
                                    <i class="nav-icon fa fa-list"></i> Listar</a>
                            </li>
                            <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('fechamento-mensal.create') }}">
                                    <i class="nav-icon fa fa-calendar-plus-o"></i> Cadastrar</a>
                            </li>
                        </ul>
                    </li>
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon fa fa-calendar-o"></i> Relatórios</a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('relatorio.pacientes-ausentes') }}">
                                        <i class="nav-icon fa fa-list"></i> Ausentes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('relatorio.mensal') }}">
                                        <i class="nav-icon fa fa-list"></i> Mensal</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fa fa-ambulance"></i> Avaliaçoes & Evoluçoes</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('avaliacoes.index') }}">
                                    <i class="nav-icon fa fa-list"></i> Listar</a>
                            </li>
                            <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('avaliacoes.create') }}">
                                    <i class="nav-icon fa fa-user-plus"></i> Cadastrar</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">
                            <i class="nav-icon icon-logout"></i> Sair
                        </a>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
        @endauth
        <main class="main">
            @yield('content')
        </main>
    </div>
    @auth
        <footer class="app-footer">
            <div>
                <a href="https://www.linkedin.com/in/bruno-leyne-a462a2123">PUC Minas - Projeto Integrado</a>
                <span>© 2023</span>
            </div>
        </footer>
    @endauth
    @yield('script')
</body>
</html>
