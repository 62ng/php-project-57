@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('interface.label_header_index') }}</div>

                    <div class="card-body">

                        @auth
                            <a class="btn btn-outline-primary mt-3 mb-3" href="{{ route('labels.create') }}" role="button">{{ __('interface.label_button_to_create') }}</a>
                        @endauth

                        @include('flash::message')

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
                                        <th scope="row">{{ $label->id }}</th>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection