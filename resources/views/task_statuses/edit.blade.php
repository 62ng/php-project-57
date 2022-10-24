@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Изменение статуса</div>

                    <div class="card-body">

                        {!! Form::open(['route' => ['task_statuses.update', $taskStatus->id], 'method' => 'patch']) !!}
                            @include('flash::message')
                            {{ Form::label('name', 'Имя') }}
                            {{ Form::text('name', old('name') ?? $taskStatus->name) }}
                            {{ Form::submit('Обновить') }}
                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection