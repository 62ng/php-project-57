<div>
    <form method="PUT" action="{{ route('task_statuses.update', $taskStatus->id) }}">
        @csrf
        @include('flash::message')
        <label>Имя</label>
        <input type="text" name="name" value="{{ old('name') ?? $taskStatus->name }}">
        <input type="submit" value="Обновить">
    </form>
</div>