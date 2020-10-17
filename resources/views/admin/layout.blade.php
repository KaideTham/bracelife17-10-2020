<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" /> 
        <title>Bracelife - Siempre Contigo</title>
        <link href="{{ asset('/css/styles.css') }}" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
            <a class="navbar-brand" href="#">Bracelife</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button> 
            <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            </div>
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle"></i> Mi Cuenta</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('ajustesadmin') }}">Ajustes</a>
                    <a class="dropdown-item" href="{{ route('cerrarsesion') }}">Cerrar Sesión</a>
                    </div>
                </li>
            </ul> 
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Gestión VIF/Brazaletes</div>
                            <a class="nav-link" href="{{ route('usuarios') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Víctima/Victimario 
                            </a>
                            <a class="nav-link" href="{{ route('ordenes') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-compress-alt"></i></div>
                                Órdenes de Alejamiento
                            </a>
                            <a class="nav-link" href="{{ route('brazaletes') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-dot-circle"></i></div>
                                Brazaletes 
                            </a>
                            <a class="nav-link" href="{{ route('desacatos') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-exclamation-triangle"></i></div>
                                Desacatos 
                            </a>
                            <div class="sb-sidenav-menu-heading">Registros de Tablas</div>
                            <a class="nav-link" href="{{ route('regiones') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Regiones 
                            </a>
                            <a class="nav-link" href="{{ route('provincias') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Provincias 
                            </a>
                            <a class="nav-link" href="{{ route('comunas') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Comunas 
                            </a>
                            <a class="nav-link" href="{{ route('estadobrazalete') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Estados de Brazalete 
                            </a>
                            <a class="nav-link" href="{{ route('niveleducacional') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Niveles Educacionales
                            </a>
                            <a class="nav-link" href="{{ route('nacionalidades') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Nacionalidades 
                            </a>
                        </div> 
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        @yield('contenido')
                        @yield('detalle')
                        @yield('info')
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        @yield('js')
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('/js/scripts.js') }}"></script>
        <script src="{{ asset('/js/canvasjsmin.js') }}"></script>
        <script src="{{ asset('/js/jquery.canvasjsmin.js') }}"></script>
        <script src="{{ asset('/js/canvasjsreac.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    </body>
</html>