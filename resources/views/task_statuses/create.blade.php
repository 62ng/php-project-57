@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Создать статус</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('task_statuses.index') }}">
                            @csrf
                            @include('flash::message')
                            <label>Имя</label>
                            <input type="text" name="name" value="{{ old('name') }}">
                            <input type="submit" value="Содать">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection