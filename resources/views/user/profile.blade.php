<div class="user-profile">
	<div class="avatar">
		<h2>{{ $user->name }}</h2>
		@include('user.avatar', ['user' => $user, 'size'=> 128])
	</div>
	<div class="info">
		<p class="city">City: {{ $user->city }}</p>
		<p class="birth">Birthdate: {{ $user->birthdate }}</p>
		<div class="buttons">
			@if($user->id === Auth::user()->id)
				<a href="{{ route('user.edit') }}" title="Edit profile" class="btn btn-primary ajax-link user-edit">
					<span class="glyphicon glyphicon-edit"></span>
				</a>
			@else
				@if(Auth::user()->hasContact($user->id) === false)
					<a href="{{ route('contact.new', ['user_id' => $user->id]) }}" class="ajax-link btn btn-success contact-new" title="Add to contact">
						<span class="glyphicon glyphicon-plus"></span>
					</a>
				@else
					<a href="{{ route('contact.delete', ['user_id' => $user->id]) }}" class="ajax-link contact-delete btn btn-danger" title="Remove from contacts" data-target="#contact-{{ $user->id }}">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
				@endif
				<a href="{{ route('conversation.new', ['recipient_id' => $user->id]) }}" class="ajax-link btn btn-primary conversation-new" data-conv-id="#conversation-{{ $user->id }}" title="Message to user">
					<span class="glyphicon glyphicon-envelope"></span>
				</a>
			@endif
		</div>
	</div>
</div>