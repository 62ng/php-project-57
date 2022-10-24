@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Создать статус</div>

                    <div class="card-body">

                        {!! Form::open(['route' => 'task_statuses.index']) !!}
                            @include('flash::message')
                            {{ Form::label('name', 'Имя') }}
                            {{ Form::text('name', old('name')) }}
                            {{ Form::submit('Создать') }}
                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection