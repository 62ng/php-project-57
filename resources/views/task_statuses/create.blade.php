@extends('layouts.app')

@section('content')
    <h1>Создать статус</h1>
    <form method="POST" action="{{ route('task_statuses.index') }}">
        @csrf
        @include('flash::message')
        <label>Имя</label>
        <input type="text" name="name" value="{{ old('name') }}">
        <input type="submit" value="Содать">
    </form>
@endsection