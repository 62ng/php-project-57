@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Создать задачу</div>

                    <div class="card-body">

                        {!! Form::open(['route' => 'tasks.index']) !!}
                            @include('flash::message')
                            <div class="flex flex-col">
                                <div>{{ Form::label('name', 'Имя') }}</div>
                                <div>{{ Form::text('name', old('name')) }}</div>
                                <div>{{ Form::label('description', 'Описание') }}</div>
                                <div>{{ Form::textarea('description', old('description')) }}</div>
                                <div>{{ Form::label('status_id', 'Статус') }}</div>
                                <div>{{ Form::select('status_id', $statuses, null, ['placeholder' => '----------']) }}</div>
                                <div>{{ Form::label('assigned_to_id', 'Исполнитель') }}</div>
                                <div>{{ Form::select('assigned_to_id', $users, null, ['placeholder' => '----------']) }}</div>
                                <div>{{ Form::label('labels', 'Метки') }}</div>
                                <div>{{ Form::select('labels', $labels, null, ['multiple' => 'multiple', 'name' => 'labels[]', 'placeholder' => '']) }}</div>
                                <div>{{ Form::submit('Создать') }}</div>
                            </div>
                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection