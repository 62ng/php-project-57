@extends('layouts.app')

@section('content')
    <div class="card-header">{{ __('interface.label_header_edit') }}</div>

    <div class="card-body">

        {!! Form::open(['route' => ['labels.update', $label->id], 'method' => 'patch']) !!}
            @include('flash::message')
            <div class="flex flex-col">
                <div>{{ Form::label('name', __('interface.task_label_name')) }}</div>
                <div class="rounded w-1/2">{{ Form::text('name', old('name') ?? $label->name) }}</div>
                <div>{{ Form::label('description', __('interface.task_label_description')) }}</div>
                <div>{{ Form::textarea('description', old('description') ?? $label->description) }}</div>
                <div class="mt-3">{{ Form::submit(__('interface.label_button_update')) }}</div>
            </div>
        {!! Form::close() !!}

    </div>
@endsection