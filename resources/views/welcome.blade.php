<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel 5.6 | Docker | Semantic - UI | Custom RBAC</title>

        <link rel="stylesheet" type="text/css" href="semantic-ui/semantic.min.css">
        <script src="semantic-ui/jquery-3.3.1.min.js"></script>
        <script src="semantic-ui/semantic.min.js"></script>

    </head>
    <body>
    <div class="ui container">

        <div class="ui secondary  menu">
            <a class="active item" href="{{ url('/home') }}">
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
                    <a class="ui item" href="{{ route('login') }}">Login</a>
                    <a class="ui item" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>

        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <h2 class="ui center aligned icon header">
            <i class="circular commenting icon"></i>
            {{"Laravel 5.6 | Docker | Semantic - UI | Custom RBAC"}}
        </h2>

        <p>&nbsp;</p>
        <p>&nbsp;</p>


        <div class="ui grid ordered steps">
            <div class="completed step">
                <div class="content">
                    <div class="title">Laravel 5.6</div>
                    <div class="description">including docker</div>
                </div>
            </div>
            <div class="completed step">
                <div class="content">
                    <div class="title">Semantic - UI </div>
                    <div class="description">custom RBAC</div>
                </div>
            </div>
            <div class="active step">
                <div class="content">
                    <div class="title">Production</div>
                    <div class="description">coming soon ... ... ... </div>
                </div>
            </div>
        </div>


    </div>






    </body>
</html>
