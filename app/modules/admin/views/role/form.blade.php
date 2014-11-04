@extends('admin::layouts.master')
@section('title','Modify Role')
@section('content')
	{{ Form::model($role, array('url' => URL::route('modify_role', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
		<input type="hidden" name="id" value="{{ $id }}">
		<div class="form-group">
			{{ Form::label('name', 'Role', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-10">
				{{ Form::text('name', null, array('class' => 'form-control input-sm', 'style' => 'width: 20%')) }}
				<span class="error">{{ @$error_messages['name'][0] }}</span>
			</div>
		</div>
		<div  class="form-group">
			<div class="col-sm-2"></div>
			<div class="col-sm-10">
				{{ Form::submit('Submit', array('name' => 'ok', 'class' => 'btn btn-danger')) }}
			</div>
		</div>
	{{ Form::close() }}
@stop