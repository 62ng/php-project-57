@extends('layouts.app')

@section('content')
    <div class="card-header">{{ __('interface.label_header_create') }}</div>

    <div class="card-body">

        {!! Form::open(['route' => 'labels.index']) !!}
            <div class="flex flex-col">
                <div class="pt-3">{{ Form::label('name', __('interface.task_label_name')) }}</div>
                <div>{{ Form::text('name', old('name'), ['class' => 'rounded-1 border border-secondary w-50 p-2']) }}</div>
                @if($errors->has('name')) <div class="text-danger">{{ $errors->first('name') }}</div> @endif
                <div class="pt-3">{{ Form::label('description', __('interface.task_label_description')) }}</div>
                <div>{{ Form::textarea('description', old('description'), ['class' => 'rounded-1 border border-secondary w-50 p-2']) }}</div>
                @if($errors->has('description')) <div class="text-danger">{{ $errors->first('description') }}</div> @endif
                <div class="mt-3">{{ Form::submit(__('interface.label_button_create'), ['class' => 'btn btn-primary']) }}</div>
            </div>
        {!! Form::close() !!}

    </div>
@endsection