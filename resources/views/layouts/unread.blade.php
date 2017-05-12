@if(count($users) > 0 )
	@foreach($users as $user)
		<li>
			<a href="{{ route('conversation.new', ['recipient_id' => $user->id]) }}" class="ajax-link conversation-new unread-conversation" data-conv-id="#conversation-{{ $user->id }}" title="Message to user">
				@include('user.avatar', ['user' => $user, 'size' => 48])
				{{ $user->name }}
			</a>
		</li>
	@endforeach
@else
	<p style="text-align: center; margin: 1em 0;">No new messages from strangers</p>
@endif