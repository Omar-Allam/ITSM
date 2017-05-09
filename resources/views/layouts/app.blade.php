<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HubDesk</title>

    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700">
    @yield('stylesheets')
</head>
<body>

<header>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-brand"><a href="{{url('/')}}"><i class="fa fa-bolt"></i> HubDesk</a></div>

            @if (!\Auth::guest())
                <ul class="nav navbar-nav">
                    <li><a href="{{route('ticket.index')}}"><i class="fa fa-ticket"></i> Tickets</a></li>
                    @if (Auth::user()->isTechnician())
                        <li><a href="{{url('/report')}}"><i class="fa fa-bar-chart"></i> Report</a></li>
                    @endif
                    @if (Auth::user()->isAdmin())
                        <li><a href="{{url('/admin')}}"><i class="fa fa-cogs"></i> Admin</a></li>
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->name}}
                            <i class="caret"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>
    </nav>

    <div class="title-bar">
        <div class="container-fluid title-container">
            @yield('header')
        </div>
    </div>
</header>

<div id="wrapper">
<main class="container-fluid">
    <div class="row">
        {{-- @todo: Move this to a view composer --}}
        {{-- @if (Route::current()->getPrefix() == '/admin')
            <aside class="col-md-3">
                @include('admin.partials._sidebar')
            </aside>
        @endif --}}

        @hasSection('sidebar')
            @yield('sidebar')
        @endif
        
        @if(Session::has('flash-message'))
            @include('partials.alert', [
                'type' => Session::get('flash-type', 'danger'),
                'message' => Session::get('flash-message')
            ])
        @endif

        @yield('body')
    </div>
</main>

<footer>
    <div class="container-fluid">
        <p class="text-muted">Copyright &copy; <a href="http://hubtech.sa">Hubtech</a> {{date('Y')}}</p>
    </div>
</footer>
</div>

<script src="{{asset('/js/app.js')}}"></script>
@yield('javascript')
</body>
</html>
