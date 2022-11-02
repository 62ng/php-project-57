@extends('layouts.app')

@section('content')
    <div class="card-header">{{ __('interface.status_header_index') }}</div>

    <div class="card-body">

        @include('flash::message')

        @auth
            <a class="btn btn-outline-primary mt-3 mb-3" href="{{ route('task_statuses.create') }}" role="button">{{ __('interface.status_button_to_create') }}</a>
        @endauth

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">{{ __('interface.task_label_name') }}</th>
                    <th scope="col">{{ __('interface.task_label_date_create') }}</th>
                    @auth
                        <th scope="col">{{ __('interface.task_label_actions') }}</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($statuses as $status)
                    <tr>
                        <th scope="row">{{ $status['id'] }}</th>
                        <td>{{ $status['name'] }}</td>
                        <td>{{ date('d.m.Y', strtotime($status['created_at'])) }}</td>
                        @auth
                            <td>
                                <a href="{{ route('task_statuses.destroy', $status['id']) }}" data-confirm="{{ __('interface.are_you_sure') }}" data-method="delete" rel="nofollow">{{ __('interface.task_link_delete') }}</a>
                                <a href="{{ route('task_statuses.edit', $status['id']) }}">{{ __('interface.task_link_update') }}</a>
                            </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection