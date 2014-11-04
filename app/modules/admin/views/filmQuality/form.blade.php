@extends('admin::layouts.master')
@section('title','Modify Quality of Film')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Modify
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ Form::model($filmQuality, array('url' => URL::route('filmQuality.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
					<input type="hidden" name="id" value="{{ $id }}">

					<div class="form-group">
						{{ Form::label('name', 'Name', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-2 col-xs-12">
							{{ Form::text('name', null, array('class' => 'form-control input-sm', 'placeholder' => 'Quality name')) }}
							<span class="error">{{ @$error_messages['name'][0] }}</span>
						</div>
					</div>
					
					<div class="form-group">
						{{ Form::label('code', 'Code', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-2 col-xs-12">
							{{ Form::text('code', null, array('class' => 'form-control input-sm', 'placeholder' => 'Code')) }}
							<span class="error">{{ @$error_messages['code'][0] }}</span>
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