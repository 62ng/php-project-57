@extends('layouts.app')

@section('content')
    <div class="card-header">{{ __('interface.task_header_create') }}</div>

    <div class="card-body">

        {!! Form::open(['route' => 'tasks.index']) !!}
            <div class="flex flex-col">
                <div class="pt-3">{{ Form::label('name', __('interface.task_label_name')) }}</div>
                <div>{{ Form::text('name', old('name'), ['class' => 'rounded-1 border border-secondary w-50 p-2']) }}</div>
                @if($errors->has('name')) <div class="text-danger">{{ $errors->first('name') }}</div> @endif
                <div class="pt-3">{{ Form::label('description', __('interface.task_label_description')) }}</div>
                <div>{{ Form::textarea('description', old('description'), ['rows' => 5, 'class' => 'rounded-1 border border-secondary w-50 p-2']) }}</div>
                @if($errors->has('description')) <div class="text-danger">{{ $errors->first('description') }}</div> @endif
                <div class="pt-3">{{ Form::label('status_id', __('interface.task_label_status')) }}</div>
                <div>{{ Form::select('status_id', $statuses, null, ['placeholder' => '----------', 'class' => 'rounded-1 border border-secondary w-50 p-2']) }}</div>
                @if($errors->has('status_id')) <div class="text-danger">{{ $errors->first('status_id') }}</div> @endif
                <div class="pt-3">{{ Form::label('assigned_to_id', __('interface.task_label_assignee')) }}</div>
                <div>{{ Form::select('assigned_to_id', $users, null, ['placeholder' => '----------', 'class' => 'rounded-1 border border-secondary w-50 p-2']) }}</div>
                @if($errors->has('assigned_to_id')) <div class="text-danger">{{ $errors->first('assigned_to_id') }}</div> @endif
                <div class="pt-3">{{ Form::label('labels', __('interface.task_label_labels')) }}</div>
                <div>{{ Form::select('labels', $labels, null, ['multiple' => 'multiple', 'name' => 'labels[]', 'placeholder' => '', 'class' => 'rounded-1 border border-secondary w-50 p-2']) }}</div>
                @if($errors->has('labels')) <div class="text-danger">{{ $errors->first('labels') }}</div> @endif
                <div class="mt-3">{{ Form::submit(__('interface.task_button_create'), ['class' => 'btn btn-primary']) }}</div>
            </div>
        {!! Form::close() !!}

    </div>
@endsection