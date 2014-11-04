@extends('admin::layouts.master')
@section('title','Modify Video')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Modify
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ Form::model($video, array('url' => URL::route('video.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
					<input type="hidden" name="id" value="{{ $id }}">

					<div class="form-group">
						{{ Form::label('url', 'Url', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-4 col-xs-12">
							<div class="input-group">
								{{ Form::text('url', null, array('id' => 'video', 'class' => 'form-control', 'placeholder' => 'Url')) }}
								<span class="input-group-btn">
									<a class="btn btn-success browse-video"><i class="glyphicon glyphicon-zoom-in"></i> Browse</a>
								</span>
							</div>
							<span class="error">{{ @$error_messages['image'][0] }}</span>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('title', 'Title', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-4 col-xs-12">
							{{ Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Title')) }}
							<span class="error">{{ @$error_messages['title'][0] }}</span>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('description', 'Description', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-10 col-xs-12">
							{{ Form::textarea('description', null, array('class' => 'form-control', 'placeholder' => 'Description')) }}
							<span class="error">{{ @$error_messages['description'][0] }}</span>
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
{{ View::make('admin::partials.file-modal', array('type' => '3', 'id' => 'video')) }}
@stop