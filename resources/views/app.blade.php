<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Todo App</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="/css/app.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div class="position-ref full-height">

            <div id="app">
                                 
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <a class="navbar-brand" href="#">Todo App</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <div class="navbar-nav mr-auto">
                            <router-link class="nav-item nav-link" to="/">List</router-link>
                            <router-link class="nav-item nav-link" to="/add">Add</router-link>
                            <router-link class="nav-item nav-link" to="/calendar">Calendar</router-link>
                            @if (Route::has('login'))
                                @auth
                                    <a class="nav-item nav-link" href="{{ route('logout') }}">Logout</a>
                                @endauth
                            @endif
                        </div>
                    </div>
                </nav>

                <alert-messages></alert-messages>
                
                @auth
                <router-view></router-view>
                @endauth
            </div>
        </div>
        <script type="text/javascript" src="/js/app.js"></script>
    </body>
</html>
