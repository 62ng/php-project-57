<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <title>Laravel</title>

        @yield('token')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container text-center">
            <div class="row border-bottom">
                <div class="col">

                    <div class="container-fluid mt-2">
                        <a class="navbar-brand" href="/"><p class="h3">Менеджер задач</p></a>
                    </div>

                </div>
                <div class="col">

                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Задачи</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/task_statuses">Статусы</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled">Метки</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>

                </div>

                <div class="col text-end">

                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/login">Вход</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/register">Регистрация</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>

                </div>

            </div>
        </div>
        <div class="container mt-5 text-start">
            @yield('content')
        </div>
    </body>
</html>
