@extends('admin::layouts.master')
@section('title','Modify Event')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Modify
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ Form::model($event, array('url' => URL::route('events.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
					<input type="hidden" name="id" value="{{ $id }}">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('title', 'Title', array('class' => 'col-md-3 col-xs-12 control-label')) }}
								<div class="col-md-9 col-xs-12">
									{{ Form::text('title', null, array('class' => 'form-control input-sm', 'placeholder' => 'Event title')) }}
									<span class="error">{{ @$error_messages['title'][0] }}</span>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('begin_at', 'Begin', array('class' => 'col-md-3 col-xs-12 control-label')) }}
								<div class="col-md-6 col-xs-12">
									<div class="input-group">
										{{ Form::text('begin_at', null, array('class' => 'form-control', 'placeholder' => 'Time begin')) }}
										<span class="input-group-btn">
											<button class="btn btn-default" type="button">Time</button>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('end_at', 'End', array('class' => 'col-md-3 col-xs-12 control-label')) }}
								<div class="col-md-6 col-xs-12">
									<div class="input-group">
										{{ Form::text('end_at', null, array('class' => 'form-control', 'placeholder' => 'Time end')) }}
										<span class="input-group-btn">
											<button class="btn btn-default" type="button">Time</button>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-2"></div>
								<div class="col-sm-10">
									{{ Form::submit('Submit', array('name' => 'ok', 'class' => 'btn btn-danger')) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('description', 'Description', array('class' => 'col-md-2 control-label')) }}
								<div class="col-md-10">
									{{ Form::textarea('description', (isset($event['description']) ? $event['description'] : null), array('class' => 'form-control')) }}
									<span class="error">{{ @$error_messages['description'][0] }}</span>
								</div>
							</div>
						</div>
					</div>
					
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop