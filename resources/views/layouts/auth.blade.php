<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <title>Laravel</title>

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
        </div>

        <div class="col text-end">
        </div>

    </div>
</div>
<div class="container mt-5">
    @yield('content')
</div>
</body>
</html>
