@extends('admin::layouts.master')
@section('title','Modify Ribbon')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Modify
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="media">
					<div class="ribbon pull-left">
						<div class="container">
							<div class="base"></div>
							<div class="left_corner"></div>
							<div class="right_corner"></div>
						</div>
					</div>
					<div class="media-body">
						{{ Form::model($ribbon, array('url' => URL::route('ribbon.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
							<input type="hidden" name="id" value="{{ $id }}">

							<div class="form-group">
								{{ Form::label('name', 'Name', array('class' => 'col-md-2 col-xs-12 control-label')) }}
								<div class="col-md-2 col-xs-12">
									{{ Form::text('name', null, array('class' => 'form-control input-sm', 'placeholder' => 'Ribbon name')) }}
									<span class="error">{{ @$error_messages['name'][0] }}</span>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('from', 'From color', array('class' => 'col-md-2 col-xs-12 control-label')) }}
								<div class="col-md-2 col-xs-12">
									<div class="input-group">
										<span class="input-group-addon">#</span>
										{{ Form::text('from', null, array('class' => 'form-control', 'placeholder' => 'From color')) }}
										<span class="input-group-btn">
											<button class="btn btn-default" type="button" id="colorpickerField1">Color</button>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('to', 'To color', array('class' => 'col-md-2 col-xs-12 control-label')) }}
								<div class="col-md-2 col-xs-12">
									<div class="input-group">
										<span class="input-group-addon">#</span>
										{{ Form::text('to', null, array('class' => 'form-control', 'placeholder' => 'To color')) }}
										<span class="input-group-btn">
											<button class="btn btn-default" type="button" id="colorpickerField2">Color</button>
										</span>
									</div>
								</div>
							</div>

							<div  class="form-group">
								<div class="col-sm-2"></div>
								<div class="col-sm-10">
									<button type="button" class="btn btn-info" id="testView">View</button>
									{{ Form::submit('Submit', array('name' => 'ok', 'class' => 'btn btn-danger')) }}
								</div>
							</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</div>
@stop