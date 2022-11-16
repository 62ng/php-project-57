@extends('layouts.app')

@section('content')
    <div class="card-header">{{ __('interface.label_header_index') }}</div>

    <div class="card-body">

        @include('flash::message')

        @auth
            <a class="btn btn-outline-primary mt-3 mb-3" href="{{ route('labels.create') }}" role="button">{{ __('interface.label_button_to_create') }}</a>
        @endauth

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">{{ __('interface.task_label_name') }}</th>
                    <th scope="col">{{ __('interface.task_label_description') }}</th>
                    <th scope="col">{{ __('interface.task_label_date_create') }}</th>
                    @auth
                        <th scope="col">{{ __('interface.task_label_actions') }}</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($labels as $label)
                    <tr>
                        <td>{{ $label->id }}</td>
                        <td>{{ $label->name }}</td>
                        <td>{{ $label->description }}</td>
                        <td>{{ date('d.m.Y', strtotime($label->created_at)) }}</td>
                        @auth
                            <td>
                                <a href="{{ route('labels.edit', $label->id) }}">{{ __('interface.task_link_update') }}</a>
                                <a href="{{ route('labels.destroy', $label->id) }}" data-confirm="{{ __('interface.are_you_sure') }}" data-method="delete" rel="nofollow">{{ __('interface.task_link_delete') }}</a>
                            </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $labels->links() }}
        </div>

    </div>
@endsection