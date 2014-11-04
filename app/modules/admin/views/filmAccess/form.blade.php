@extends('admin::layouts.master')
@section('title','Modify User')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Modify
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ Form::model($user, array('url' => URL::route('users.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
					<input type="hidden" name="id" value="{{ $id }}">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-2 col-xs-12">
							<div class="btn-group" data-toggle="buttons">

								<label class="btn btn-default status btn-sm active">
									{{ Form::radio('status', '0', true) }}<i class="glyphicon glyphicon-off"></i>
								</label>

								<label class="btn btn-default status btn-sm">       
									{{ Form::radio('status', '1') }}<i class="glyphicon glyphicon-ok"></i>
								</label>

							</div>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('role', 'Level', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-2 col-xs-12">
							{{ Form::select('role', $roles, null, array('class' => 'form-control input-sm')) }}
							<span class="error">{{ @$error_messages['role'][0] }}</span>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('username', 'Username', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-2 col-xs-12">
							{{ Form::text('username', null, array('class' => 'form-control input-sm', 'placeholder' => 'Username')) }}
							<span class="error">{{ @$error_messages['username'][0] }}</span>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('password', 'Password', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-2 col-xs-12">
							{{ Form::password('password', array('class' => 'form-control input-sm', 'placeholder' => 'Password')) }}
							<span class="error">{{ @$error_messages['password'][0] }}</span>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('confirm_password', 'Confirm Password', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-2 col-xs-12">
							{{ Form::password('confirm_password', array('class' => 'form-control input-sm', 'placeholder' => 'Confirm Password')) }}
							<span class="error">{{ @$error_messages['confirm_password'][0] }}</span>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('email', 'Email', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-2 col-xs-12">
							{{ Form::text('email', null, array('class' => 'form-control input-sm', 'placeholder' => 'Email')) }}
							<span class="error">{{ @$error_messages['email'][0] }}</span>
						</div>
					</div>

					<div  class="form-group">
						<div class="col-sm-2"></div>
						<div class="col-sm-10">
							{{ Form::submit('Submit', array('name' => 'ok', 'class' => 'btn btn-danger')) }}
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop