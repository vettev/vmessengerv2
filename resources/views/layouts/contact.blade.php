<li id="contact-{{ $contact->userSaved->id }}">
    <span class="unread" @if ($contact->getUnread() <= 0)
    style="display: none"
    @endif>
        {{ $contact->getUnread() }}
    </span>
    <a href="{{ route('conversation.new', ['recipient_id' => $contact->userSaved->id]) }}" class="ajax-link contact" data-conv-id="#conversation-{{ $contact->userSaved->id }}">
        @include('user.avatar', ['size' => 48, 'user' => $contact])
        {{ $contact->userSaved->name }}
    </a>
</li>