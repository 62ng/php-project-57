<div>
    <ul>
        @foreach($statuses as $status)
            <li>{{ $status['name'] }} (<a href="{{ route('task_statuses.edit', $status['id']) }}">реактировать</a> )</li>
        @endforeach
    </ul>
</div>