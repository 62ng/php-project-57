@extends('layouts.app')

@section('content')
    <div class="card-header">{{ __('interface.status_header_edit') }}</div>

    <div class="card-body">

        {!! Form::open(['route' => ['task_statuses.update', $taskStatus->id], 'method' => 'patch']) !!}
            @include('flash::message')
            <div class="flex flex-col">
                <div>{{ Form::label('name', __('interface.task_label_name')) }}</div>
                <div>{{ Form::text('name', old('name') ?? $taskStatus->name) }}</div>
                <div class="mt-3">{{ Form::submit(__('interface.task_button_update')) }}</div>
            </div>
        {!! Form::close() !!}

    </div>
@endsection