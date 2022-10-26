@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Изменение задачи</div>

                    <div class="card-body">

                        {!! Form::open(['route' => ['tasks.update', $task->id], 'method' => 'patch']) !!}
                            @include('flash::message')
                            <div class="flex flex-col">
                                <div>{{ Form::label('name', 'Имя') }}</div>
                                <div>{{ Form::text('name', old('name') ?? $task->name) }}</div>
                                <div>{{ Form::label('description', 'Описание') }}</div>
                                <div>{{ Form::textarea('description', old('description') ?? $task->description) }}</div>
                                <div>{{ Form::label('status_id', 'Статус') }}</div>
                                <div>{{ Form::select('status_id', $statuses, $task->status_id, ['placeholder' => '----------']) }}</div>
                                <div>{{ Form::label('assigned_to_id', 'Исполнитель') }}</div>
                                <div>{{ Form::select('assigned_to_id', $users, $task->assigned_to_id, ['placeholder' => '----------']) }}</div>
                                <div>{{ Form::submit('Обновить') }}</div>
                            </div>
                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection