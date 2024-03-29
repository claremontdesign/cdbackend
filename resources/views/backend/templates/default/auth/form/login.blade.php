
<form class="form-horizontal" role="form" method="POST" action="{{ cd_route('postLogin') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="form-group">
		<label class="col-md-4 control-label">E-Mail Address</label>
		<div class="col-md-6">
			<input type="email" class="form-control" name="email" value="dennes.b.abing@gmail.com">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Password</label>
		<div class="col-md-6">
			<input type="password" class="form-control" value="onedge" name="password">
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="remember"> Remember Me
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn btn-primary">Login</button>
			<a class="btn btn-link" href="{{ url('password/email') }}">Forgot Your Password?</a>
		</div>
	</div>
</form>