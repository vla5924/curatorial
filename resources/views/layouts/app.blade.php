<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/theme/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/theme/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/theme/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/theme/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/theme/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/theme/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!--div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/theme/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
                width="60">
        </div-->

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link p-0 my-0 ml-2" style="font-size: 1.6em">@yield('title')</span>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();"
                        class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" hidden>
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="/theme/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Curatorial</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/theme/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>
                        @can('view practices')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Practices
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('practice.index') }}" class="nav-link">
                                        <p>Recently added</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('practice.my') }}" class="nav-link">
                                        <p>My practices</p>
                                    </a>
                                </li>
                                @can('create practices')
                                <li class="nav-item">
                                    <a href="{{ route('practice.create') }}" class="nav-link">
                                        <p>Create practice</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('view pollbunches')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Pollbunches
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pollbunches.index') }}" class="nav-link">
                                        <p>Recently added</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pollbunches.my') }}" class="nav-link">
                                        <p>My pollbunches</p>
                                    </a>
                                </li>
                                @can('create pollbunches')
                                <li class="nav-item">
                                    <a href="{{ route('pollbunches.create') }}" class="nav-link">
                                        <p>Create pollbunch</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tree"></i>
                                <p>
                                    Tools
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('use blocker')
                                <li class="nav-item">
                                    <a href="pages/UI/icons.html" class="nav-link">
                                        <p>Blocker</p>
                                    </a>
                                </li>
                                @endcan
                                @can('use republisher')
                                <li class="nav-item">
                                    <a href="pages/UI/general.html" class="nav-link">
                                        <p>Republisher</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Settings
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('settings.index') }}" class="nav-link">
                                        <p>General settings</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('extra-token.index') }}" class="nav-link">
                                        <p>Extra token</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Help
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="pages/forms/general.html" class="nav-link">
                                        <p>FAQs</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="pages/forms/advanced.html" class="nav-link">
                                        <p>About</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @role('admin')
                        <li class="nav-header">ADMINISTRATION</li>
                        @can('view groups')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Groups
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('groups.index') }}" class="nav-link">
                                        <p>All groups</p>
                                    </a>
                                </li>
                                @can('assign groups')
                                <li class="nav-item">
                                    <a href="{{ route('groups.assign') }}" class="nav-link">
                                        <p>Assign groups</p>
                                    </a>
                                </li>
                                @endcan
                                @can('create groups')
                                <li class="nav-item">
                                    <a href="{{ route('groups.create') }}" class="nav-link">
                                        <p>Add group</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @endrole
                    </ul>
                </nav><!-- /.sidebar-menu -->

            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <div class="content-header mb-2"></div>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </footer>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <script src="/theme/plugins/jquery/jquery.min.js"></script>
    <script src="/theme/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="/theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/theme/plugins/chart.js/Chart.min.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/theme/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/theme/plugins/moment/moment.min.js"></script>
    <script src="/theme/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/theme/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script src="/theme/dist/js/adminlte.js"></script>
    <script src="/theme/dist/js/demo.js"></script>
    <script src="/theme/dist/js/pages/dashboard.js"></script>
    <script src="/js/misc.js"></script>
    <script>@yield('inline-script')</script>
</body>

</html>
