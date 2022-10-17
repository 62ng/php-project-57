<html>
    <head>
        <meta charset="utf-8">
        <title>Анализатор страниц</title>
        <meta name="csrf-token" content="<?= csrf_token() ?>" />
        <meta name="csrf-param" content="_token" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <div>
            @include('flash::message')
            <ul>
                @foreach($statuses as $status)
                    <li>{{ $status['name'] }} (
                        <a href="{{ route('task_statuses.edit', $status['id']) }}">реактировать</a>
                        <a href="{{ route('task_statuses.destroy', $status['id']) }}" data-confirm="Вы уверены?" data-method="delete" rel="nofollow">удалить</a>
                        )</li>
                @endforeach
            </ul>
        </div>
    </body>
</html>