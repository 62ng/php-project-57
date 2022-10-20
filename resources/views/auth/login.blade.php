@extends('layouts/auth')

@section('content')
    <div class="container">
        <div class="w-25 m-auto border border-1 rounded rounded-3 p-3">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        @include('flash::message')
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">{{ __('Email') }}</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="exampleInputEmail1">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">{{ __('Password') }}</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
    </form>
        </div>
    </div>
@endsection
