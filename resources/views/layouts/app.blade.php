<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | @lang('misc.curatorial')</title>

    <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="57x57" href="/images/icons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" type="image/png" sizes="57x57" href="/images/icons/apple-touch-icon-57x57.png">
    <link rel="icon" type="image/png" sizes="72x72" href="/images/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" type="image/png" sizes="72x72" href="/images/icons/apple-touch-icon-72x72.png">
    <link rel="icon" type="image/png" sizes="76x76" href="/images/icons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" type="image/png" sizes="76x76" href="/images/icons/apple-touch-icon-76x76.png">
    <link rel="icon" type="image/png" sizes="114x114" href="/images/icons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" type="image/png" sizes="114x114" href="/images/icons/apple-touch-icon-114x114.png">
    <link rel="icon" type="image/png" sizes="120x120" href="/images/icons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" type="image/png" sizes="120x120" href="/images/icons/apple-touch-icon-120x120.png">
    <link rel="icon" type="image/png" sizes="144x144" href="/images/icons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" type="image/png" sizes="144x144" href="/images/icons/apple-touch-icon-144x144.png">
    <link rel="icon" type="image/png" sizes="152x152" href="/images/icons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" type="image/png" sizes="152x152" href="/images/icons/apple-touch-icon-152x152.png">
    <link rel="icon" type="image/png" sizes="180x180" href="/images/icons/apple-touch-icon-180x180.png">
    <link rel="apple-touch-icon" type="image/png" sizes="180x180" href="/images/icons/apple-touch-icon-180x180.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="/theme/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/theme/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/theme/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="/theme/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/theme/plugins/daterangepicker/daterangepicker.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/images/icons/apple-touch-icon.png" alt="Logo" height="60"
                width="60">
        </div>

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
                                <input class="form-control form-control-navbar" type="search" placeholder="@lang('misc.search')"
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
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="@lang('misc.full_screen')">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <!--li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li-->
                <li class="nav-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();"
                        class="nav-link" title="@lang('misc.logout')">
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
            <a href="{{ route('home') }}" class="brand-link">
                <img src="/images/icons/apple-touch-icon.png" alt="Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">@lang('misc.curatorial')</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ Auth::user()->avatar }}" class="img-circle elevation-2">
                    </div>
                    <div class="info">
                        <a href="{{ route('users.show', Auth::user()->id) }}" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    @lang('home.home')
                                </p>
                            </a>
                        </li>
                        @can('view posts')
                        <li class="nav-item">
                            <a href="{{ route('posts.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>
                                    @lang('posts.posts')
                                </p>
                            </a>
                        </li>
                        @endcan
                        @can('view profiles')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    @lang('users.community')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.show', Auth::user()->id) }}" class="nav-link">
                                        <p>@lang('users.my_profile')</p>
                                    </a>
                                </li>
                                @can('view rating')
                                <li class="nav-item">
                                    <a href="{{ route('users.rating.index') }}" class="nav-link">
                                        <p>@lang('users.rating')</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('view practices')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    @lang('practice.practices')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('practice.index') }}" class="nav-link">
                                        <p>@lang('practice.recently_added')</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('practice.my') }}" class="nav-link">
                                        <p>@lang('practice.my_practices')</p>
                                    </a>
                                </li>
                                @can('create practices')
                                <li class="nav-item">
                                    <a href="{{ route('practice.create') }}" class="nav-link">
                                        <p>@lang('practice.create_practice')</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('view pollbunches')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>
                                    @lang('pollbunches.pollbunches')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pollbunches.index') }}" class="nav-link">
                                        <p>@lang('pollbunches.recently_added')</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pollbunches.my') }}" class="nav-link">
                                        <p>@lang('pollbunches.my_pollbunches')</p>
                                    </a>
                                </li>
                                @can('create pollbunches')
                                <li class="nav-item">
                                    <a href="{{ route('pollbunches.create') }}" class="nav-link">
                                        <p>@lang('pollbunches.create_pollbunch')</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    @lang('tools.tools')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('use blocker')
                                <li class="nav-item">
                                    <a href="{{ route('tools.blocker') }}" class="nav-link">
                                        <p>@lang('tools.blocker')</p>
                                    </a>
                                </li>
                                @endcan
                                @can('use republisher')
                                <li class="nav-item">
                                    <a href="{{ route('tools.republisher') }}" class="nav-link">
                                        <p>@lang('tools.republisher')</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    @lang('settings.settings')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('settings.index') }}" class="nav-link">
                                        <p>@lang('settings.general_settings')</p>
                                    </a>
                                </li>
                                @can('view profiles')
                                <li class="nav-item">
                                    <a href="{{ route('information.index') }}" class="nav-link">
                                        <p>@lang('settings.information')</p>
                                    </a>
                                </li>
                                @endcan
                                <li class="nav-item">
                                    <a href="{{ route('extra-token.index') }}" class="nav-link">
                                        <p>@lang('settings.extra_token')</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-question-circle"></i>
                                <p>
                                    @lang('help.help')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('help.index') }}" class="nav-link">
                                        <p>@lang('help.manuals_and_faq')</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('help.about') }}" class="nav-link">
                                        <p>@lang('help.about')</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @role('admin')
                        <li class="nav-header">@lang('misc.administration')</li>
                        @can('edit points')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-star-half-alt"></i>
                                <p>
                                    @lang('points.points')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('adjust points')
                                <li class="nav-item">
                                    <a href="{{ route('points.adjust') }}" class="nav-link">
                                        <p>@lang('points.adjust_points')</p>
                                    </a>
                                </li>
                                @endcan
                                @can('nullify points')
                                <li class="nav-item">
                                    <a href="{{ route('points.nullify') }}" class="nav-link">
                                        <p>@lang('points.nullify_points')</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('view groups')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>
                                    @lang('groups.groups')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('groups.index') }}" class="nav-link">
                                        <p>@lang('groups.all_groups')</p>
                                    </a>
                                </li>
                                @can('assign groups')
                                <li class="nav-item">
                                    <a href="{{ route('groups.assign') }}" class="nav-link">
                                        <p>@lang('groups.assign_groups')</p>
                                    </a>
                                </li>
                                @endcan
                                @can('create groups')
                                <li class="nav-item">
                                    <a href="{{ route('groups.create') }}" class="nav-link">
                                        <p>@lang('groups.add_group')</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('view groups')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-lock"></i>
                                <p>
                                    @lang('permissions.permissions')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('assign roles')
                                <li class="nav-item">
                                    <a href="{{ route('roles.assign') }}" class="nav-link">
                                        <p>@lang('permissions.assign_roles')</p>
                                    </a>
                                </li>
                                @endcan
                                @can('assign permissions')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <p>
                                            @lang('permissions.assign_permissions')
                                            <span class="right badge badge-danger">@lang('misc.soon')</span>
                                        </p>
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

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <script src="/theme/plugins/jquery/jquery.min.js"></script>
    <script src="/theme/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="/theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/theme/plugins/chart.js/Chart.min.js"></script>
    <script src="/theme/plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="/theme/plugins/moment/moment.min.js"></script>
    <script src="/theme/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="/theme/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script src="/theme/dist/js/adminlte.js"></script>
    <script src="/theme/dist/js/demo.js"></script>
    <script src="/theme/dist/js/pages/dashboard.js"></script>

    <script src="/js/misc.js"></script>
    <script>
        Utils.i18n({
            'fields_cannot_be_empty': '@lang('misc.fields_cannot_be_empty')',
            'form_is_not_completed': '@lang('misc.form_is_not_completed')',
        });
    </script>
    <script>@yield('inline-script')</script>
</body>

</html>
