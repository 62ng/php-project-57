@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Изменение статуса</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('task_statuses.update', $taskStatus->id) }}">
                            @csrf
                            @method('patch')
                            @include('flash::message')
                            <label>Имя</label>
                            <input type="text" name="name" value="{{ old('name') ?? $taskStatus->name }}">
                            <input type="submit" value="Обновить">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection