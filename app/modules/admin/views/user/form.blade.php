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
					<input type="hidden" name="avatar" id="image">
					
					<div class="media">
						<a class="pull-left" href="#" data-target=".file-modal" data-toggle="modal">
							<div class="thumbnail">
								<img class="media-object avatar" data-src="holder.js/260x350" alt="...">
								<span class="file-input btn btn-primary btn-file">
									Upload
								</span>
							</div>
						</a>
						<div class="media-body">
							<div class="row">
								<div class="col-md-6">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title">Login Information</h3>
										</div>
										<div class="panel-body">
											<div class="form-group">
												<div class="col-md-offset-4 col-md-2 col-xs-12">
													<div class="btn-group" data-toggle="buttons">

														<label class="btn btn-default status btn-sm {{ !isset($user->status) || $user->status == 0 ? 'active' : '' }}">
															{{ Form::radio('status', '0', true) }}<i class="glyphicon glyphicon-off"></i>
														</label>

														<label class="btn btn-default status btn-sm {{ @$user->status == 1 ? 'active' : '' }}">       
															{{ Form::radio('status', '1') }}<i class="glyphicon glyphicon-ok"></i>
														</label>

													</div>
												</div>
											</div>

											<div class="form-group">
												{{ Form::label('role', 'Level', array('class' => 'col-md-4 control-label')) }}
												<div class="col-md-8">
													{{ Form::select('role', $roles, null, array('class' => 'form-control select2')) }}
													<span class="error">{{ @$error_messages['role'][0] }}</span>
												</div>
											</div>

											<div class="form-group">
												{{ Form::label('username', 'Username', array('class' => 'col-md-4 control-label')) }}
												<div class="col-md-8">
													{{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Username')) }}
													<span class="error">{{ @$error_messages['username'][0] }}</span>
												</div>
											</div>

											<div class="form-group">
												{{ Form::label('password', 'Password', array('class' => 'col-md-4 control-label')) }}
												<div class="col-md-8">
													{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
													<span class="error">{{ @$error_messages['password'][0] }}</span>
												</div>
											</div>

											<div class="form-group">
												{{ Form::label('confirm_password', 'Confirm Password', array('class' => 'col-md-4 control-label')) }}
												<div class="col-md-8">
													{{ Form::password('confirm_password', array('class' => 'form-control input-sm', 'placeholder' => 'Confirm Password')) }}
													<span class="error">{{ @$error_messages['confirm_password'][0] }}</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title">User Information</h3>
										</div>
										<div class="panel-body">
											<div class="form-group">
												{{ Form::label('fullname', 'Fullname', array('class' => 'col-md-2 control-label')) }}
												<div class="col-md-10">
													{{ Form::text('fullname', null, array('class' => 'form-control', 'placeholder' => 'Fullname')) }}
													<span class="error">{{ @$error_messages['fullname'][0] }}</span>
												</div>
											</div>

											<div class="form-group">
												{{ Form::label('gender_id', 'Gender', array('class' => 'col-md-2 control-label')) }}
												<div class="col-md-10">
													{{ Form::select('gender_id', $gender, null, array('class' => 'form-control select2')) }}
													<span class="error">{{ @$error_messages['gender_id'][0] }}</span>
												</div>
											</div>

											<div class="form-group">
												{{ Form::label('email', 'Email', array('class' => 'col-md-2	 control-label')) }}
												<div class="col-md-10">
													{{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email')) }}
													<span class="error">{{ @$error_messages['email'][0] }}</span>
												</div>
											</div>
											
											<div class="form-group">
												{{ Form::label('phone', 'Phone', array('class' => 'col-md-2	 control-label')) }}
												<div class="col-md-10">
													{{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Phone')) }}
													<span class="error">{{ @$error_messages['phone'][0] }}</span>
												</div>
											</div>

											<div  class="form-group">
												<div class="col-sm-2"></div>
												<div class="col-sm-10">
													{{ Form::submit('Submit', array('name' => 'ok', 'class' => 'btn btn-danger')) }}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
{{ View::make('admin::partials.file-modal', array('type' => '1', 'id' => 'image')) }}
@stop