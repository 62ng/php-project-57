@foreach (session('flash_notification', collect())->toArray() as $message)
    <div class="alert
                alert-{{ $message['level'] }}
                {{ $message['important'] ? 'alert-important' : '' }}"
                role="alert"
    >
        @if ($message['level'] !== 'success')
            <div>Упс! Что-то пошло не так:</div>
        @endif
        {!! $message['message'] !!}
    </div>
@endforeach

{{ session()->forget('flash_notification') }}
