<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>App Name - @yield('title')</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('libs/bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('libs/font-awesome/css/font-awesome.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
    </head>
    <body>
        @yield('content')
        
        <script src="{{ asset('libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('libs/bootstrap/js/bootstrap.js') }}"></script>
        <script src="{{ asset('libs/vue/vue.js') }}"></script>
        @stack('scripts')
    </body>
</html>