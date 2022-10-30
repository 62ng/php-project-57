@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Метки</div>

                    <div class="card-body">

                        @auth
                        <a class="btn btn-outline-primary mt-3 mb-3" href="{{ route('labels.create') }}" role="button">Создать метку</a>
                        @endauth

                        @include('flash::message')

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">Описание</th>
                                    <th scope="col">Дата создания</th>
                                    <th scope="col">@auth Действия @endauth</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($labels as $label)
                                    <tr>
                                        <th scope="row">{{ $label->id }}</th>
                                        <td>{{ $label->name }}</td>
                                        <td>{{ $label->description }}</td>
                                        <td>{{ date('d.m.Y', strtotime($label->created_at)) }}</td>
                                        <td>
                                            @auth
                                                <a href="{{ route('labels.edit', $label->id) }}">Изменить</a>
                                                <a href="{{ route('labels.destroy', $label->id) }}" data-confirm="Вы уверены?" data-method="delete" rel="nofollow">Удалить</a>
                                            @endauth
                                        </td>
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