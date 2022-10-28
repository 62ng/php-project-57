@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Просмотр задачи: {{ $task->name }}</div>
@dump($task)
                    <div class="card-body">

                        @auth
                            <a class="btn btn-outline-primary mt-3 mb-3" href="{{ route('tasks.edit', $task->id) }}" role="button">Изменить задачу</a>
                        @endauth

                        <p>
                            <span class="font-bold">Имя:</span>
                            {{ $task->name }}
                        </p>
                        <p>
                            <span class="accent-red-600">Статус:</span>
                            {{ $statuses[$task->status_id] }}
                        </p>
                        <p>
                            <span class="font-black">Описание:</span>
                            {{ $task->description }}
                        </p>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection