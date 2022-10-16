<div>
    <ul>
        @foreach($statuses as $status)
            <li>{{ $status['name'] }}</li>
        @endforeach
    </ul>
</div>