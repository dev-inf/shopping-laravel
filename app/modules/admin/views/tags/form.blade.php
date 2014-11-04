@extends('admin::layouts.master')
@section('title','Modify Tags')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Modify
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ Form::model($tags, array('url' => URL::route('tags.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'formTags')) }}
					<input type="hidden" name="id" value="{{ $id }}">
					<div class="form-group">
						{{ Form::label('name', 'Tags', array('class' => 'col-md-1 control-label')) }}
						<div class="col-md-4">
							{{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Tags')) }}
							<span class="error">{{ @$error_messages['name'][0] }}</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-11"></div>
						<div class="col-sm-1">
							{{ Form::submit('Submit', array('name' => 'ok', 'class' => 'btn btn-danger')) }}
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
{{ View::make('admin::partials.file-modal', array('type' => '1', 'id' => 'image')) }}
@stop