@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Изменение метки</div>

                    <div class="card-body">

                        {!! Form::open(['route' => ['labels.update', $label->id], 'method' => 'patch']) !!}
                            @include('flash::message')
                            <div class="flex flex-col">
                                <div>{{ Form::label('name', 'Имя') }}</div>
                                <div>{{ Form::text('name', old('name') ?? $label->name) }}</div>
                                <div>{{ Form::label('description', 'Описание') }}</div>
                                <div>{{ Form::textarea('description', old('description') ?? $label->description) }}</div>
                                <div>{{ Form::submit('Обновить') }}</div>
                            </div>
                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection