<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 64px;
            }

            h2.title {
                font-size: 40px;
                margin-bottom: 50px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 16px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
{{--            @if (Route::has('login'))--}}
{{--                <div class="top-right links">--}}
{{--                    <a href="{{ route('login') }}">Login</a>--}}
{{--                    <a href="{{ route('register') }}">Register</a>--}}
{{--                </div>--}}
{{--            @endif--}}

            <div class="content">
                <h1 class="title">
                    Welcome to the website of <br> Kateryna Popova and Martijn Jager.
                </h1>
                <h2 class="title">
                    This website contains a project management system. <br>
                    This project system is accessible after logging in.
                </h2>
                <h3 class="links mt-5">
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                </h3>
            </div>
        </div>
    </body>
</html>
