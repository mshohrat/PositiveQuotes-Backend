<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}
    <script src="{{ asset('js/core/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>

    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('js/now-ui-dashboard.js') }}" type="text/javascript"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.css') }}" rel="stylesheet" />
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

{{--        <div class="wrapper">--}}
{{--            <div class="sidebar" data-color="orange">--}}
{{--                <!----}}
{{--                    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"--}}
{{--                -->--}}
{{--                <div class="logo">--}}
{{--                    <a href="http://www.creative-tim.com" class="simple-text logo-mini">--}}
{{--                        CT--}}
{{--                    </a>--}}

{{--                    <a href="http://www.creative-tim.com" class="simple-text logo-normal">--}}
{{--                        Creative Tim--}}
{{--                    </a>--}}
{{--                </div>--}}

{{--                <div class="sidebar-wrapper" id="sidebar-wrapper">--}}
{{--                    <ul class="nav">--}}
{{--                        <li class="active ">--}}
{{--                            <a href="../dashboard.html">--}}

{{--                                <i class="now-ui-icons design_app"></i>--}}

{{--                                <p>Dashboard</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li>--}}
{{--                            <a href="../icons.html">--}}

{{--                                <i class="now-ui-icons education_atom"></i>--}}

{{--                                <p>Icons</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li>--}}
{{--                            <a href="../map.html">--}}

{{--                                <i class="now-ui-icons location_map-big"></i>--}}

{{--                                <p>Maps</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li>--}}
{{--                            <a href="../notifications.html">--}}

{{--                                <i class="now-ui-icons ui-1_bell-53"></i>--}}

{{--                                <p>Notifications</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li>--}}
{{--                            <a href="../user.html">--}}

{{--                                <i class="now-ui-icons users_single-02"></i>--}}

{{--                                <p>User Profile</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li>--}}
{{--                            <a href="../tables.html">--}}

{{--                                <i class="now-ui-icons design_bullet-list-67"></i>--}}

{{--                                <p>Table List</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li>--}}
{{--                            <a href="../typography.html">--}}

{{--                                <i class="now-ui-icons text_caps-small"></i>--}}

{{--                                <p>Typography</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="active-pro">--}}
{{--                            <a href="../upgrade.html">--}}

{{--                                <i class="now-ui-icons arrows-1_cloud-download-93"></i>--}}

{{--                                <p>Upgrade to PRO</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</body>
</html>
