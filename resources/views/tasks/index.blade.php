@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Статусы</div>

                    <div class="card-body">

                        @auth
                        <a class="btn btn-outline-primary mt-3 mb-3" href="{{ route('tasks.create') }}" role="button">Создать задачу</a>
                        @endauth

                        @include('flash::message')

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Статус</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">Автор</th>
                                    <th scope="col">Исполнитель</th>
                                    <th scope="col">Дата создания</th>
                                    <th scope="col">@auth Действия @endauth</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <th scope="row">{{ $task->id }}</th>
                                        <td>{{ $task->status->name }}</td>
                                        <td>
                                            <a href="{{ route('tasks.show', $task->id) }}">{{ $task->name }}</a>
                                        </td>
                                        <td>{{ $task->creator->name }}</td>
                                        <td>{{ $task->assignee->name }}</td>
                                        <td>{{ date('d.m.Y', strtotime($task->created_at)) }}</td>
                                        <td>
                                            @auth
                                                <a href="{{ route('tasks.edit', $task->id) }}">Изменить</a>
                                            @endauth
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection