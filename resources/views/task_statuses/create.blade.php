@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('interface.status_header_create') }}</div>

                    <div class="card-body">

                        {!! Form::open(['route' => 'task_statuses.index']) !!}
                            @include('flash::message')
                            <div class="flex flex-col">
                                <div>{{ Form::label('name', __('interface.task_label_name')) }}</div>
                                <div>{{ Form::text('name', old('name')) }}</div>
                                <div class="mt-3">{{ Form::submit(__('interface.task_button_create')) }}</div>
                            </div>
                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection