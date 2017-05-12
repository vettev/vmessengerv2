<ul id="search-results">
	@foreach($users as $user)
		<li>
			@if(Auth::user()->id !== $user->id)
				<a href="{{ route('conversation.new', ['recipient_id' => $user->id]) }}" class="ajax-link btn btn-primary conversation-new" data-conv-id="#conversation-{{ $user->id }}" title="Message to user">
					<span class="glyphicon glyphicon-envelope"></span>
				</a>
				@if(Auth::user()->hasContact($user->id) === false)
					<a href="{{ route('contact.new', ['user_id' => $user->id]) }}" class="ajax-link btn btn-success contact-new" title="Add to contact">
						<span class="glyphicon glyphicon-plus"></span>
					</a>
				@endif
			@endif
			<a href="{{ route('user.show', ['id' => $user->id]) }}" class="ajax-link user-show">
				@include('user.avatar', ['user' => $user, 'size' => 48])
			</a>
			<div class="user-info">
				<p class="name">{{ $user->name }}</p>
				<p class="city">{{ $user->city }}</p>
			</div>
			<div class="clearfix"></div>
		</li>
	@endforeach
</ul>