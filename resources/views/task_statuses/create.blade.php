<div>
    <form method="POST" action="{{ route('task_statuses.index') }}">
        @csrf
        @include('flash::message')
        <label>Имя</label>
        <input type="text" name="name" value="{{ old('name') }}">
        <input type="submit" value="Содать">
    </form>
</div>