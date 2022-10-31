@extends('layouts.app')

@section('content')
    <div class="card-header">{{ __('interface.status_header_edit') }}</div>

    <div class="card-body">

        {!! Form::open(['route' => ['task_statuses.update', $taskStatus->id], 'method' => 'patch']) !!}
            @include('flash::message')
            <div class="flex flex-col">
                <div class="pt-3">{{ Form::label('name', __('interface.task_label_name')) }}</div>
                <div>{{ Form::text('name', old('name') ?? $taskStatus->name, ['class' => 'rounded-1 border border-secondary w-50 p-2']) }}</div>
                <div class="mt-3">{{ Form::submit(__('interface.task_button_update'), ['class' => 'btn btn-primary']) }}</div>
            </div>
        {!! Form::close() !!}

    </div>
@endsection