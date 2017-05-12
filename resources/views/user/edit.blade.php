<form action="{{ route('user.save') }}" class="ajax-form user-edit" enctype="multipart/form-data" method="POST">
	{{ csrf_field() }}
	<div class="form-group">
		<label for="avatar">Avatar</label>
		<input type="file" class="form-control" name="avatar" id="avatar">
	</div>
	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" name="name" id="name" value="{{ Auth::user()->name }}">
	</div>
	<div class="form-group">
		<label for="city">City</label>
		<input type="text" class="form-control" name="city" id="city" value="{{ Auth::user()->city }}">
	</div>
	<div class="form-group">
		<label for="Birthdate">Birthdate (DD/MM/YYYY)</label><br>
		<input type="text" class="form-control bdate-input" name="b_day" placeholder="DD" minlength="2" maxlength="2" value="{{ substr(Auth::user()->birthdate, 8, 2) }}">
		<input type="text" class="form-control bdate-input" name="b_month" placeholder="MM" minlength="2" maxlength="2" value="{{ substr(Auth::user()->birthdate, 5, 2) }}">
		<input type="text" class="form-control bdate-input" name="b_year" placeholder="YYYY" minlength="4" maxlength="4" value="{{ substr(Auth::user()->birthdate, 0, 4) }}">
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Save</button>
	</div>
</form>