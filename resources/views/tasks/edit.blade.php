@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('interface.task_header_edit') }}</div>

                    <div class="card-body">

                        {!! Form::open(['route' => ['tasks.update', $task->id], 'method' => 'patch']) !!}
                            @include('flash::message')
                            <div class="flex flex-col">
                                <div>{{ Form::label('name', __('interface.task_label_name')) }}</div>
                                <div>{{ Form::text('name', old('name') ?? $task->name) }}</div>
                                <div>{{ Form::label('description', __('interface.task_label_description')) }}</div>
                                <div>{{ Form::textarea('description', old('description') ?? $task->description) }}</div>
                                <div>{{ Form::label('status_id', __('interface.task_label_status')) }}</div>
                                <div>{{ Form::select('status_id', $statuses, $task->status_id, ['placeholder' => '----------']) }}</div>
                                <div>{{ Form::label('assigned_to_id', __('interface.task_label_assignee')) }}</div>
                                <div>{{ Form::select('assigned_to_id', $users, $task->assigned_to_id, ['placeholder' => '----------']) }}</div>
                                <div>{{ Form::label('labels', __('interface.task_label_labels')) }}</div>
                                <div>{{ Form::select('labels', $labels, $task->labels, ['multiple' => 'multiple', 'name' => 'labels[]', 'placeholder' => '']) }}</div>
                                <div class="mt-3">{{ Form::submit(__('interface.task_button_update')) }}</div>
                            </div>
                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection