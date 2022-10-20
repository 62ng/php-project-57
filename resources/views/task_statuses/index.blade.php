@extends('layout')

@section('token')
    <meta name="csrf-token" content="<?= csrf_token() ?>" />
    <meta name="csrf-param" content="_token" />
@endsection

@section('content')
    <h1>Статусы</h1>
    <a class="btn btn-outline-primary mt-3 mb-3" href="{{ route('task_statuses.create') }}" role="button">Создать статус</a>

    @include('flash::message')

    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Имя</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($statuses as $status)
            <tr>
                <th scope="row">{{ $status['id'] }}</th>
                <td>{{ $status['name'] }}</td>
                <td>{{ $status['updated_at'] }}</td>
                <td>
                    <a href="{{ route('task_statuses.destroy', $status['id']) }}" data-confirm="Вы уверены?" data-method="delete" rel="nofollow">Удалить</a>
                    <a href="{{ route('task_statuses.edit', $status['id']) }}">Изменить</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection