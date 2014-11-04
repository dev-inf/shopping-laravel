@extends('admin::layouts.master')
@section('title','Add New Subtitle')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Create
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ Form::model($filmSubtitle, array('url' => URL::route('filmSubtitle.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
					<input type="hidden" name="id" value="{{ $id }}">

					<div class="form-group">
						{{ Form::label('section', 'Section', array('class' => 'col-md-3 control-label')) }}
						<div class="col-md-9">
							{{ Form::select('sec_id', $sectionFilm, null, array('class' => 'form-control input-sm select2', 'id' => 'sectionFilm')) }}
							<span class="error">{{ @$error_messages['section'][0] }}</span>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('film_id', 'Tilte Film', array('class' => 'col-md-3 control-label')) }}
						<div class="col-md-9">
							{{ Form::hidden('film_id', null, array('id' => 'film', 'class' => 'form-control input-sm', 'id' => 'film')) }}
							<p>Choose section first</p>
							<span class="error">{{ @$error_messages['film_id'][0] }}</span>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('subtitle_url', 'Subtitle Url', array('class' => 'col-md-3 control-label')) }}
						<div class="col-md-9">
							{{ Form::text('subtitle_url', null, array('class' => 'form-control', 'placeholder' => 'Url of subtitle')) }}
							<span class="error">{{ @$error_messages['subtitle_url'][0] }}</span>
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('lang_id', 'Language', array('class' => 'col-md-3 control-label')) }}
						<div class="col-md-9">
							{{ Form::select('lang_id', $language, null, array('class' => 'form-control input-sm select2')) }}
							<span class="error">{{ @$error_messages['lang_id'][0] }}</span>
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