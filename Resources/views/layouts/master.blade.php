<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{Module::asset('consultas:plugins/bootstrap/css/bootstrap.min.css')}}">
        @yield('addCss')
        <title>Module Consultas</title>
    </head>
    <body>
    <div class="container">
        @yield('content')
    </div>

    </body>
    <script src="{{Module::asset('consultas:js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{Module::asset('consultas:plugins/bootstrap/js/bootstrap.min.js')}}"></script>
@yield('addJs')
</html>
