<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Login Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Le styles -->
		<link href="{{ asset('/public/libraries/bootstrap/css/bootstrap.css') }}" media="screen" rel="stylesheet" type="text/css">
		<link href="{{ asset('/public/styles/auth/style.css') }}" media="screen" rel="stylesheet" type="text/css">
	</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<h1 class="text-center login-title">Đăng nhập vào quản trị</h1>
				<div class="account-wall">
					<img class="profile-img" src="{{ asset('/public/images/auth/photo.png') }}" alt="">
					{{ Form::open(array('class' => 'form-horizontal form-signin', 'role' => 'form', 'method' => 'post', 'url' => URL::route('login'))) }}
						<?php
							if($errors->first('error') != ''){ 
								echo '<div class="alert alert-warning">'.$errors->first('error').'</div>';
							}
						?>
<!--						<div class="form-group">-->
<!--							{{ Form::label('username', 'Username', array('class' => 'col-sm-4 control-label')) }}-->
<!--							<div class="col-sm-8">-->
								{{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Username')) }}
<!--							</div>-->
<!--						</div>-->
<!--						<div class="form-group">-->
<!--							{{ Form::label('password', 'Password', array('class' => 'col-sm-4 control-label')) }}-->
<!--							<div class="col-sm-8">-->
								{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
<!--							</div>-->
<!--						</div>-->
						<!--<div class="col-sm-4">-->
							{{ Form::submit('Login', array('name' => 'login', 'class' => 'btn btn-lg btn-primary btn-block')) }}
<!--							<label class="checkbox pull-left"><input type="checkbox" value="remember-me">Remember me</label>
							<a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>-->
						<!--</div>-->
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</body>
<!--[if lt IE 9]><script type="text/javascript" src="http://odcvoyage.com/js/html5.js"></script><![endif]-->
<script type="text/javascript" src="{{ asset('/public/libraries/jquery/jquery-2.0.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/libraries/bootstrap/js/bootstrap.min.js') }}"></script>
</html>
