<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			Form Modify
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			{{ Form::model($filmEpData, array('url' => URL::route('filmEp.modify', array('id' => $id)) . '?' . $_SERVER['QUERY_STRING'], 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'modify-ep-form')) }}
				<input type="hidden" name="id" value="{{ $id }}">
				<input type="hidden" name="film_id" value="{{{ $_GET['film_id'] }}}">
				<input type="hidden" name="sec_id" value="{{{ $film->sec_id }}}">

				<div class="form-group">
					{{ Form::label('quality_id', 'Quality', array('class' => 'col-md-3 control-label')) }}
					<div class="col-md-9">
						{{ Form::select('quality_id', $filmQuality, null, array('class' => 'form-control input-sm select2')) }}
						<span class="error">{{ @$error_messages['quality_id'][0] }}</span>
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('release_date', 'Release Date', array('class' => 'col-md-3 control-label')) }}
					<div class="col-md-9">
						{{ Form::text('release_date', null, array('class' => 'form-control', 'placeholder' => 'Release Date')) }}
						<span class="error">{{ @$error_messages['release_date'][0] }}</span>
					</div>
				</div>
				<?php if($film->sec_id == 2){ ?>
				<div class="form-group">
					{{ Form::label('ep', 'Ep', array('class' => 'col-md-3 control-label')) }}
					<div class="col-md-9">
						{{ Form::text('ep', null, array('class' => 'form-control', 'placeholder' => 'Ep')) }}
						<span class="error">{{ @$error_messages['ep'][0] }}</span>
					</div>
				</div>
				<?php }else{ ?>
				<input type="hidden" name="ep" value="0">
				<?php } ?>

				<div class="form-group">
					{{ Form::label('ep_link', 'Ep Link', array('class' => 'col-md-3 control-label')) }}
					<div class="col-md-9">
						{{ Form::text('ep_link', null, array('class' => 'form-control browse-link', 'data-type' => 'ep_link', 'placeholder' => 'Ep Link')) }}
						<span class="error">{{ @$error_messages['ep_link'][0] }}</span>
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('vi_subtitle_url', 'Subtitle Url (Vietnamese)', array('class' => 'col-md-3 control-label')) }}
					<div class="col-md-9">
						{{ Form::text('vi_subtitle_url', null, array('class' => 'form-control browse-link', 'data-type' => 'vi_subtitle_url' ,'placeholder' => 'Url of subtitle')) }}
						<span class="error">{{ @$error_messages['vi_subtitle_url'][0] }}</span>
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('en_subtitle_url', 'Subtitle Url (English)', array('class' => 'col-md-3 control-label')) }}
					<div class="col-md-9">
						{{ Form::text('en_subtitle_url', null, array('class' => 'form-control browse-link', 'data-type' => 'en_subtitle_url' ,'placeholder' => 'Url of subtitle')) }}
						<span class="error">{{ @$error_messages['en_subtitle_url'][0] }}</span>
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('cn_subtitle_url', 'Subtitle Url (Chinese)', array('class' => 'col-md-3 control-label')) }}
					<div class="col-md-9">
						{{ Form::text('cn_subtitle_url', null, array('class' => 'form-control browse-link', 'data-type' => 'cn_subtitle_url' ,'placeholder' => 'Url of subtitle')) }}
						<span class="error">{{ @$error_messages['cn_subtitle_url'][0] }}</span>
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('time', 'Time', array('class' => 'col-md-3 control-label')) }}
					<div class="col-md-9">
						{{ Form::text('time', null, array('class' => 'form-control', 'placeholder' => 'Time')) }}
						<span class="error">{{ @$error_messages['time'][0] }}</span>
					</div>
				</div>
				<div  class="form-group">
					<div class="col-sm-2"></div>
					<div class="col-sm-10">
						{{ Form::submit('Submit', array('name' => 'ok', 'class' => 'btn btn-danger', 'id' => 'submit-btn')) }}
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>