<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KWizard</title>

    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    @yield('stylesheets')
</head>
<body>

<header class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-brand"><a href="{{url('/')}}"><i class="fa fa-bolt"></i> KWizard</a></div>

        <ul class="nav navbar-nav">
            <li><a href="{{route('ticket.index')}}"><i class="fa fa-ticket"></i> Tickets</a></li>
            <li><a href="#"><i class="fa fa-cogs"></i> Admin</a></li>
        </ul>
    </div>
</header>

<section class="container-fluid">
    <div class="row">
        {{-- @todo: Move this to a view composer --}}
        @if (Route::current()->getPrefix() == '/admin')
        <aside class="col-md-3">
            @include('admin.partials._sidebar')
        </aside>
        @endif

        <div class="col-md-{{Route::current()->getPrefix() == '/admin'? 9 : 12}}">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    @yield('header')
                </div>

                <div class="panel-body">
                    @if(Session::has('flash-message'))
                        @include('partials.alert', [
                            'type' => Session::get('flash-type', 'danger'),
                            'message' => Session::get('flash-message')
                        ])
                    @endif

                    @yield('body')
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container-fluid">
        <p class="text-muted">Copyright &copy; AlKifah Holding Company {{date('Y')}}</p>
    </div>
</footer>

<script src="{{asset('/js/app.js')}}"></script>
@yield('javascript')
</body>
</html>
