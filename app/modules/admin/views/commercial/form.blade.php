@extends('admin::layouts.master')
@section('title','Modify Commercial')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Modify
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ Form::model($commercial, array('url' => URL::route('commercial.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
					<input type="hidden" name="id" value="{{ $id }}">
					<input type="hidden" name="banner" id="image">
					<div class="media">
						<a class="pull-left" href="#" data-target=".file-modal" data-toggle="modal">
							<div class="thumbnail">
								<img class="media-object banner" data-src="holder.js/260x350" alt="...">
								<span class="file-input btn btn-primary btn-file">
									Upload
								</span>
							</div>
						</a>
						<div class="media-body">

							<div class="form-group">
								{{ Form::label('begin_at', 'Begin', array('class' => 'col-md-1 col-xs-12 control-label')) }}
								<div class="col-md-3 col-xs-12">
									<div class="input-group">
										{{ Form::text('begin_at', null, array('class' => 'form-control', 'placeholder' => 'Time begin')) }}
										<span class="input-group-btn">
											<button class="btn btn-default" type="button">Time</button>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('end_at', 'End', array('class' => 'col-md-1 col-xs-12 control-label')) }}
								<div class="col-md-3 col-xs-12">
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
					</div>
					
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop