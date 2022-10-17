<div>
    <form method="POST" action="{{ route('task_statuses.update', $taskStatus->id) }}">
        @csrf
        @method('patch')
        @include('flash::message')
        <label>Имя</label>
        <input type="text" name="name" value="{{ old('name') ?? $taskStatus->name }}">
        <input type="submit" value="Обновить">
    </form>
</div>