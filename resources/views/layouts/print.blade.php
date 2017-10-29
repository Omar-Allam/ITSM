<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HubDesk</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{asset('/css/print.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @yield('stylesheets')
</head>
<body>

<div>

    @yield('body')

</div>

@yield('javascript')
</body>
</html>
