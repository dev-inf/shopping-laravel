@extends('admin::layouts.master')
@section('title','Modify Film')
@section('content')
	<div class="col-lg-12">
		<button type="button" class="btn btn-info btn-lg btn-fix-top-right" id="getDetailImdb">Search detail IMDB</button>
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Modify
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ Form::model($filmData, array('url' => URL::route('film'.$method.'.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'formFilm')) }}
				
				<input type="hidden" name="id" value="{{ $id }}">
				<input type="hidden" name="banner" id="banner" value="{{ (isset($filmData['banner']) ? $filmData['banner'] : '') }}">
				<input type="hidden" name="poster" id="poster" value="{{ (isset($filmData['poster']) ? $filmData['poster'] : '') }}">
					<div class="row">
					  	<div class="col-md-6">
					  		<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Panel title</h3>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												{{ Form::label('status', 'Active', array('class' => 'col-md-5 control-label')) }}
												<div class="col-md-7">
													<div class="btn-group" data-toggle="buttons">

														<label class="btn btn-default status btn-sm {{ !isset($filmData->status) || $filmData->status == 0 ? 'active' : '' }}">
															{{ Form::radio('status', '0', true) }}<i class="glyphicon glyphicon-off"></i>
														</label>

														<label class="btn btn-default status btn-sm {{ @$filmData->status == 1 ? 'active' : '' }}">       
															{{ Form::radio('status', '1') }}<i class="glyphicon glyphicon-ok"></i>
														</label>

													</div>
												</div>
											</div>

											<div class="form-group">
												{{ Form::label('depute', 'Depute', array('class' => 'col-md-5 control-label')) }}
												<div class="col-md-7">
													<div class="btn-group" data-toggle="buttons">

														<label class="btn btn-default depute btn-sm {{ !isset($filmData->depute) || $filmData->depute == 0 ? 'active' : '' }}">
															{{ Form::radio('depute', '0', true) }}<i class="glyphicon glyphicon-off"></i>
														</label>

														<label class="btn btn-default depute btn-sm {{ @$filmData->depute == 1 ? 'active' : '' }}">       
															{{ Form::radio('depute', '1') }}<i class="glyphicon glyphicon-ok"></i>
														</label>

													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												{{ Form::label('coming', 'Coming', array('class' => 'col-md-3 control-label')) }}
												<div class="col-md-9">
													<div class="btn-group" data-toggle="buttons">

														<label class="btn btn-default depute btn-sm {{ !isset($filmData->coming) || $filmData->coming == 0 ? 'active' : '' }}">
															{{ Form::radio('coming', '0', true) }}<i class="glyphicon glyphicon-off"></i>
														</label>

														<label class="btn btn-default depute btn-sm {{ @$filmData->coming == 1 ? 'active' : '' }}">       
															{{ Form::radio('coming', '1') }}<i class="glyphicon glyphicon-ok"></i>
														</label>

													</div>
												</div>
											</div>
											
											<div class="form-group">
												{{ Form::label('ribbon_id', 'Ribbon', array('class' => 'col-md-3 control-label')) }}
												<div class="col-md-9">
													{{ Form::select('ribbon_id', $ribbon, (isset($filmData['ribbon_id']) ? $filmData['ribbon_id'] : array()), array('id' => 'ribbon', 'class' => 'form-control input-sm select2')) }}
													<span class="error">{{ @$error_messages['ribbon_id'][0] }}</span>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										{{ Form::label('section', 'Section', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-9">
											{{ Form::select('sec_id', $sectionFilm, (isset($filmData['sec_id']) ? $filmData['sec_id'] : array()), array('id' => 'sectionFilm', 'class' => 'form-control input-sm select2')) }}
											<span class="error">{{ @$error_messages['section'][0] }}</span>
										</div>
									</div>

									<div class="form-group">
										{{ Form::label('catalogue', 'Catalogue', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-9">
											{{ Form::select('cata_id[]', $catalogueFilm, (isset($filmData['cata_id']) ? explode(',',$filmData['cata_id']): array()), array('id' => 'catalogueFilm', 'class' => 'form-control input-sm select2', 'multiple'=>'multiple')) }}
											<span class="error">{{ @$error_messages['catalogue'][0] }}</span>
										</div>
									</div>

									<div class="form-group">
										{{ Form::label('en_title', 'Title EN', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-9">
											{{ Form::text('en_title', (isset($filmData['en_title']) ? $filmData['en_title'] : null), array('class' => 'form-control', 'placeholder' => 'Title of English')) }}
											<span class="error">{{ @$error_messages['en_title'][0] }}</span>
										</div>
									</div>

									<div class="form-group">
										{{ Form::label('vn_title', 'Title VN', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-9">
											{{ Form::text('vn_title', (isset($filmData['vn_title']) ? $filmData['vn_title'] : null), array('class' => 'form-control', 'placeholder' => 'Title of Vietnames')) }}
											<span class="error">{{ @$error_messages['vn_title'][0] }}</span>
										</div>
									</div>
								</div>
							</div>	
					  	</div>
					  	<div class="col-md-6">
					  		<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Panel title</h3>
								</div>
								<div class="panel-body">
							  		<div class="form-group">
										{{ Form::label('release_date', 'Release date', array('class' => 'col-md-4 control-label')) }}
										<div class="col-md-8">
											{{ Form::text('release_date', (isset($filmData['release_date']) ? $filmData['release_date'] : null), array('class' => 'form-control', 'placeholder' => 'Release date')) }}
											<span class="error">{{ @$error_messages['release_date'][0] }}</span>
										</div>
									</div>

									<div class="form-group">
										{{ Form::label('imdb_rating', 'IMDB Rating', array('class' => 'col-md-4 control-label')) }}
										<div class="col-md-8">
											{{ Form::text('imdb_rating', (isset($filmData['imdb_rating']) ? $filmData['imdb_rating'] : null), array('class' => 'form-control', 'placeholder' => 'IMDB Point')) }}
											<span class="error">{{ @$error_messages['imdb_rating'][0] }}</span>
										</div>
									</div>

									<div class="form-group">
										{{ Form::label('imdb_vote', 'IMDB Vote', array('class' => 'col-md-4 control-label')) }}
										<div class="col-md-8">
											{{ Form::text('imdb_vote', (isset($filmData['imdb_vote']) ? $filmData['imdb_vote'] : null), array('class' => 'form-control', 'placeholder' => 'IMDB Vote')) }}
											<span class="error">{{ @$error_messages['imdb_vote'][0] }}</span>
										</div>
									</div>

									<div class="form-group">
										{{ Form::label('imdb_link', 'IMDB Link', array('class' => 'col-md-4 control-label')) }}
										<div class="col-md-8">
											{{ Form::text('imdb_link', (isset($filmData['imdb_link']) ? $filmData['imdb_link'] : null), array('class' => 'form-control', 'placeholder' => 'IMDB Link')) }}
											<span class="error">{{ @$error_messages['imdb_link'][0] }}</span>
										</div>
									</div>
									
									<div class="form-group">
										{{ Form::label('idIMDB', 'IMDB ID', array('class' => 'col-md-4 control-label')) }}
										<div class="col-md-8">
											{{ Form::text('idIMDB', (isset($filmData['idIMDB']) ? $filmData['idIMDB'] : null), array('class' => 'form-control', 'placeholder' => 'IMDB ID')) }}
											<span class="error">{{ @$error_messages['idIMDB'][0] }}</span>
										</div>
									</div>
								</div>
							</div>
					  	</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Panel title</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										{{ Form::label('trailer', 'Trailer Link', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-9">
											{{ Form::text('trailer', (isset($filmData['trailer']) ? $filmData['trailer'] : null), array('class' => 'form-control', 'placeholder' => 'Trailer Link')) }}
											<span class="error">{{ @$error_messages['trailer'][0] }}</span>
										</div>
									</div>		
								</div>
								<div class="col-md-6">
									<div class="form-group">
										{{ Form::label('producer', 'Producer', array('class' => 'col-md-2 control-label')) }}
										<div class="col-md-10">
											<?php 
												if(isset($filmData['producer_id'])){
													$dataProducer = \Functions::getDataPosition($filmData['producer_id']);
												}else{
													$dataProducer = null; 
												}
											?>
											{{ Form::text('producer', $dataProducer, array('class' => 'form-control', 'placeholder' => 'Producer')) }}
											<p class="help-block">Between producer use separators is ','</p>
											<span class="error">{{ @$error_messages['producer'][0] }}</span>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('director', 'Director', array('class' => 'col-md-1 control-label')) }}
								<div class="col-md-11">
									<?php 
										if(isset($filmData['director_id'])){
											$dataDirector = \Functions::getDataPosition($filmData['director_id']);
										}else{
											$dataDirector = null; 
										}
									?>
									{{ Form::text('director', $dataDirector, array('class' => 'form-control', 'placeholder' => 'Director')) }}
									<p class="help-block">Between director use separators is ','</p>
									<span class="error">{{ @$error_messages['director'][0] }}</span>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('cast', 'Cast', array('class' => 'col-md-1 control-label')) }}
								<div class="col-md-11">
									<?php 
										if(isset($filmData['cast_id'])){
											$dataCast = \Functions::getDataPosition($filmData['cast_id']);
										}else{
											$dataCast = null; 
										}
									?>
									{{ Form::text('cast', $dataCast, array('class' => 'form-control', 'placeholder' => 'Cast')) }}
									<p class="help-block">Between cast use separators is ','</p>
									<span class="error">{{ @$error_messages['cast'][0] }}</span>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-4">
									<div class="thumbnail choose-image" data-type="poster">
										<?php 
											if(isset($filmData['poster']) && $filmData['poster'] != ''){
												$srcPoster = 'src="'.$filmData['poster'].'"';
											}else{
												$srcPoster = 'data-src="holder.js/260x350"'; 
											}
										?>
									  	<img {{$srcPoster}} alt="..." id="poster-img">
									  	<span class="file-input btn btn-primary btn-file">
											Upload Poster
										</span>
									</div>
								</div>
								<div class="col-md-8">
									<div class="thumbnail choose-image" data-type="banner">
										<?php 
											if(isset($filmData['banner']) && $filmData['banner'] != ''){
												$srcBanner = 'src="'.$filmData['banner'].'"';
											}else{
												$srcBanner = 'data-src="holder.js/590x350"'; 
											}
										?>
									  	<img {{$srcBanner}} alt="..." id="banner-img">
									  	<span class="file-input btn btn-primary btn-file">
											Upload Banner
										</span>
									</div>
								</div>
							</div>							
							
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										{{ Form::label('en_description', 'Description EN', array('class' => 'col-md-2 control-label')) }}
										<div class="col-md-10">
											{{ Form::textarea('en_description', (isset($filmData['en_description']) ? $filmData['en_description'] : null), array('class' => 'form-control')) }}
											<span class="error">{{ @$error_messages['en_description'][0] }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										{{ Form::label('vn_description', 'Description VN', array('class' => 'col-md-2 control-label')) }}
										<div class="col-md-10">
											{{ Form::textarea('vn_description', (isset($filmData['vn_description']) ? $filmData['vn_description'] : null), array('class' => 'form-control')) }}
											<span class="error">{{ @$error_messages['vn_description'][0] }}</span>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('tags', 'Tags', array('class' => 'col-md-1 control-label')) }}
								<div class="col-md-11">
									<?php 
										if(isset($filmData['tags'])){
											$dataTags = \Functions::getDataTags($filmData['tags']);
										}else{
											$dataTags = null; 
										}
									?>
									{{ Form::text('tags', $dataTags, array('class' => 'form-control select2-tag', 'placeholder' => 'Tags')) }}
									<p class="help-block">Between tags use separators is ','</p>
									<span class="error">{{ @$error_messages['tags'][0] }}</span>
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
	{{ View::make('admin::partials.file-modal', array('type' => '1', 'id' => 'image')) }}
@stop