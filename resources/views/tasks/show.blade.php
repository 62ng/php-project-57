@extends('layouts.app')

@section('content')
    <div class="card-header">{{ __('interface.task_header_show', ['name' => $task->name]) }}</div>

    <div class="card-body">

        @auth
            <a class="btn btn-outline-primary mt-3 mb-3" href="{{ route('tasks.edit', $task->id) }}" role="button">{{ __('interface.task_button_to_update') }}</a>
        @endauth

        <p>
            <span class="font-bold">{{ __('interface.task_label_name') }}:</span>
            {{ $task->name }}
        </p>
        <p>
            <span class="accent-red-600">{{ __('interface.task_label_status') }}:</span>
            {{ $task->status->name }}
        </p>
        <p>
            <span class="font-black">{{ __('interface.task_label_description') }}:</span>
            {{ $task->description }}
        </p>
        <p>
            <span class="font-black">{{ __('interface.task_label_labels') }}:</span>
            {{ implode(', ', $task->labels->pluck('name', 'id')->toArray()) }}
        </p>

    </div>
@endsection