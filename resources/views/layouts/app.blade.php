<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="stylesheet" type="text/css" href="semantic-ui/semantic.min.css">
    <script src="semantic-ui/jquery-3.3.1.min.js"></script>
    <script src="semantic-ui/semantic.min.js"></script>

</head>
<body>


    <div class="ui container">

        <div class="ui secondary  menu">
            <a class="active item" href="{{ url('/') }}">
                Home
            </a>
            <div class="right menu">
                <div class="item">
                    <div class="ui icon input">
                        <input type="text" placeholder="Search...">
                        <i class="search link icon"></i>
                    </div>
                </div>

                @auth
                    <a class="ui item" href="{{ url('/home') }}">Home</a>
                @else
                    <a class="ui item active" href="{{ route('login') }}">Login</a>
                    <a class="ui item" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>


        @yield('content')


    </div>

</body>
</html>
