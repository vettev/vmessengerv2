@if($user->avatar)
	<img src="/storage/avatars/avatar-{{ $user->id }}.{{ $user->avatar }}" alt="User avatar" class="user-avatar" width="{{ $size }}" height="{{ $size }}" />
@else
	<img src="/img/default-avatar.png" alt="User avatar" class="user-avatar" width="{{ $size }}" height="{{ $size }}" />
@endif