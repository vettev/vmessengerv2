<div class="conversation panel" id="conversation-{{ $recipient_id }}">
    <div class="panel-heading">
            <a href="{{ route('user.show', ['id' => $recipient_id]) }}" class="ajax-link user-show">
            @include('user.avatar', ['user' => $users[$recipient_id], 'size' => 32])
            {{ $users[$recipient_id]->name }}
        </a>
    </div>
    <button class="close-window">
        <span class="glyphicon glyphicon-off"></span>
    </button>
    <ul class="messages">
        @foreach($messages as $message)
            {{--@if($loop->index > 0 && $messages[$loop->index]->created_at->day != 
            $messages[$loop->index-1]->created_at->day || $loop->index == 0)
                <p class="day">{{ $message->created_at->toFormattedDateString() }}</p>
            @endif --}}
            <li>
                <p class="date">{{ $message->created_at->format('H:i') }}</p>
                <p class="sender">{{ $users[$message->sender_id]->name }}</p>
                <p class="content">{{ $message->content }}</p>
            </li>
        @endforeach
    </ul>
    <form action="{{ route('message.new') }}" method="POST" class="ajax-form message-form">
        {{ csrf_field() }}
        <input type="hidden" name="recipient_id" value="{{ $recipient_id }}">
        <input type="text" class="form-control message-input" placeholder="Your message..." name="content" autocomplete="off" />
    </form>
</div>