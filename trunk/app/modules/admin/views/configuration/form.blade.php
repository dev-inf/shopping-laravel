@extends('admin::layouts.master')
@section('title','Modify Configuration')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Modify
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ Form::model($configuration, array('url' => URL::route('configuration.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
					<input type="hidden" name="id" value="{{ $id }}">

					<div class="form-group">
						{{ Form::label('key', 'Key', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-2 col-xs-12">
							{{ Form::text('key', null, array('class' => 'form-control input-sm', 'placeholder' => 'Key')) }}
							<span class="error">{{ @$error_messages['key'][0] }}</span>
						</div>
					</div>
					
					<div class="form-group">
						{{ Form::label('value', 'Value', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-2 col-xs-12">
							{{ Form::text('value', null, array('class' => 'form-control input-sm', 'placeholder' => 'Value')) }}
							<span class="error">{{ @$error_messages['value'][0] }}</span>
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