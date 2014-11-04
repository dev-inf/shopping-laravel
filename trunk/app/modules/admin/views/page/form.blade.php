@extends('admin::layouts.master')
@section('title','Modify Page')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Modify
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ Form::model($page, array('url' => URL::route('pages.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
					<input type="hidden" name="id" value="{{ $id }}">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-4 col-xs-12">
							<div class="btn-group" data-toggle="buttons">

								<label class="btn btn-default status btn-sm {{ !isset($page->status) || $page->status == 0 ? 'active' : '' }}">
									{{ Form::radio('status', '0', true) }}<i class="glyphicon glyphicon-off"></i>
								</label>

								<label class="btn btn-default status btn-sm {{ @$page->status == 1 ? 'active' : '' }}">       
									{{ Form::radio('status', '1') }}<i class="glyphicon glyphicon-ok"></i>
								</label>

							</div>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('code', 'Code', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-4 col-xs-12">
							{{ Form::text('code', null, array('class' => 'form-control', 'placeholder' => 'Code')) }}
							<span class="error">{{ @$error_messages['code'][0] }}</span>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('image', 'Image', array('class' => 'col-md-2 col-xs-12 control-label')) }}
						<div class="col-md-4 col-xs-12">
							<div class="input-group">
								{{ Form::text('image', null, array('id' => 'image', 'class' => 'form-control', 'placeholder' => 'Image')) }}
								<span class="input-group-btn">
									<a class="btn btn-success browse-image"><i class="glyphicon glyphicon-zoom-in"></i> Browse</a>
								</span>
							</div>
							<span class="error">{{ @$error_messages['image'][0] }}</span>
						</div>
					</div>
	
					{{ View::make('admin::partials.multilanguage-form', array(
						'error_messages' => @$error_messages,
			        	'langs' => $langs,
			        	'items' => array(
			        		array(
			        			'name' => 'alias',
			        			'data-type' => 'seo',
			        			'title' => 'Alias',
			        			'type' => 'text',
			        		),
			        		array(
			        			'name' => 'meta_key',
			        			'data-type' => 'seo',
			        			'title' => 'Meta Key',
			        			'type' => 'text',
			        		),
			        		array(
			        			'name' => 'meta_description',
			        			'data-type' => 'seo',
			        			'title' => 'Meta Description',
			        			'type' => 'text',
			        		),
			        		array(
			        			'name' => 'title',
			        			'data-type' => 'content',
			        			'title' => 'Title',
			        			'type' => 'text',
			        		),
			        		array(
			        			'name' => 'short_description',
			        			'data-type' => 'content',
			        			'title' => 'Short Description',
			        			'type' => 'textarea',
			        		),
			        		array(
			        			'name' => 'full_description',
			        			'data-type' => 'content',
			        			'title' => 'Full Description',
			        			'type' => 'textarea',
			        		),
			        	),
			        )) }}

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
{{ View::make('admin::partials.file-modal', array('type' => '1', 'id' => 'image')) }}
@stop