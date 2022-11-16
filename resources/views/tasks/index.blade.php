@extends('layouts.app')

@section('content')
    <div class="card-header">{{ __('interface.task_header_index') }}</div>

    <div class="card-body">

        @include('flash::message')

        @auth
            <a class="btn btn-outline-primary mt-3 mb-3" href="{{ route('tasks.create') }}" role="button">{{ __('interface.task_button_to_create') }}</a>
        @endauth

        <div class="mt-2 mb-2">
            {!! Form::open(['route' => 'tasks.index', 'method' => 'GET']) !!}
                {{ Form::select('filter[status_id]', $statuses, $filters['status_id'] ?? null, ['placeholder' => __('interface.task_label_status'), 'class' => 'rounded-1 border border-secondary p-2']) }}
                {{ Form::select('filter[created_by_id]', $creators, $filters['created_by_id'] ?? null, ['placeholder' => __('interface.task_label_creator'), 'class' => 'rounded-1 border border-secondary p-2']) }}
                {{ Form::select('filter[assigned_to_id]', $assignees, $filters['assigned_to_id'] ?? null, ['placeholder' => __('interface.task_label_assignee'), 'class' => 'rounded-1 border border-secondary p-2']) }}
                {{ Form::submit(__('interface.task_button_filter'), ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">{{ __('interface.task_label_status') }}</th>
                    <th scope="col">{{ __('interface.task_label_name') }}</th>
                    <th scope="col">{{ __('interface.task_label_creator') }}</th>
                    <th scope="col">{{ __('interface.task_label_assignee') }}</th>
                    <th scope="col">{{ __('interface.task_label_date_create') }}</th>
                    @auth
                        <th scope="col">{{ __('interface.task_label_actions') }}</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->status->name }}</td>
                        <td>
                            <a href="{{ route('tasks.show', $task->id) }}">{{ $task->name }}</a>
                        </td>
                        <td>{{ $task->creator->name }}</td>
                        <td>{{ $task->assignee ? $task->assignee->name : '' }}</td>
                        <td>{{ date('d.m.Y', strtotime($task->created_at)) }}</td>
                        @auth
                            <td>
                                <a href="{{ route('tasks.edit', $task->id) }}">{{ __('interface.task_link_update') }}</a>
                                @can('delete', $task)
                                    <a href="{{ route('tasks.destroy', $task->id) }}" data-confirm="{{ __('interface.are_you_sure') }}" data-method="delete" rel="nofollow">{{ __('interface.task_link_delete') }}</a>
                                @endcan
                            </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>

    </div>
@endsection