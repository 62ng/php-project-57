@extends('layouts.app')

@section('content')
    <div class="card-header">{{ __('interface.status_header_create') }}</div>

    <div class="card-body">

        {!! Form::open(['route' => 'task_statuses.index']) !!}
            <div class="flex flex-col">
                <div class="pt-3">{{ Form::label('name', __('interface.task_label_name')) }}</div>
                <div>{{ Form::text('name', old('name'), ['class' => 'rounded-1 border border-secondary w-50 p-2']) }}</div>
                @if($errors->has('name')) <div class="text-danger">{{ $errors->first('name') }}</div> @endif
                <div class="mt-3">{{ Form::submit(__('interface.task_button_create'), ['class' => 'btn btn-primary']) }}</div>
            </div>
        {!! Form::close() !!}

    </div>
@endsection