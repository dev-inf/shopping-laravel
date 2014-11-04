@extends('admin::layouts.master')
@section('title','Modify Position')
@section('content')
	<div class="col-lg-12">
		<button type="button" class="btn btn-info btn-lg btn-fix-top-right" id="getDetailImdb">Search detail IMDB</button>
		<div class="panel panel-default">
			<div class="panel-heading">
				Form Modify
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ Form::model($position, array('url' => URL::route('position.modify', array('id' => $id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'formPosition')) }}
					<input type="hidden" name="id" value="{{ $id }}">
					<input type="hidden" name="avatar" id="image" value="{{ (isset($position['avatar']) ? $position['avatar'] : '') }}">
					
					<div class="media">
						<a class="pull-left" href="#" data-target=".file-modal" data-toggle="modal">
							<div class="thumbnail">
								<?php 
									if(isset($position['avatar']) && $position['avatar'] != ''){
										$srcPoster = 'src="'.$position['avatar'].'"';
									}else{
										$srcPoster = 'data-src="holder.js/260x350"'; 
									}
								?>
								<img {{$srcPoster}} alt="..." id="poster-img">
								<span class="file-input btn btn-primary btn-file">
									Upload
								</span>
							</div>
						</a>
						<div class="media-body">
							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title">Short Information</h3>
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														{{ Form::label('fullname', 'Fullname', array('class' => 'col-md-4 control-label')) }}
														<div class="col-md-8">
															{{ Form::text('fullname', null, array('class' => 'form-control', 'placeholder' => 'Fullname')) }}
															<span class="error">{{ @$error_messages['fullname'][0] }}</span>
														</div>
													</div>
													<div class="form-group">
														{{ Form::label('fullname_vn', 'Fullname Vietnamese', array('class' => 'col-md-4 control-label')) }}
														<div class="col-md-8">
															{{ Form::text('fullname_vn', null, array('class' => 'form-control', 'placeholder' => 'Fullname Vietnamese')) }}
															<span class="error">{{ @$error_messages['fullname_vn'][0] }}</span>
														</div>
													</div>
													<div class="form-group">
														{{ Form::label('date_of_birth', 'Birthday', array('class' => 'col-md-4 control-label')) }}
														<div class="col-md-8">
															<div class='input-group date datetimepicker'>
																{{ Form::text('date_of_birth', null, array('class' => 'form-control', 'placeholder' => 'Birthday')) }}
																<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
																<span class="error">{{ @$error_messages['date_of_birth'][0] }}</span>
															</div>
														</div>
													</div>
													<div class="form-group">
														{{ Form::label('date_of_death', 'Deathday', array('class' => 'col-md-4 control-label')) }}
														<div class="col-md-8">
															<div class='input-group date datetimepicker'>
																{{ Form::text('date_of_death', null, array('class' => 'form-control', 'placeholder' => 'Deathday')) }}
																<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
																<span class="error">{{ @$error_messages['date_of_death'][0] }}</span>
															</div>
														</div>
													</div>
													<div class="form-group">
														{{ Form::label('body_height', 'Height', array('class' => 'col-md-4 control-label')) }}
														<div class="col-md-8">
															<div class="input-group">
																{{ Form::text('body_height', null, array('class' => 'form-control', 'placeholder' => 'Height')) }}
																<span class="input-group-addon">meter</span>
															</div>
															<span class="error">{{ @$error_messages['body_height'][0] }}</span>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														{{ Form::label('country', 'Country', array('class' => 'col-md-4 control-label')) }}
														<div class="col-md-8">
															{{ Form::text('country', null, array('class' => 'form-control', 'placeholder' => 'Country')) }}
															<span class="error">{{ @$error_messages['country'][0] }}</span>
														</div>
													</div>
													<div class="form-group">
														{{ Form::label('cata_id', 'Position', array('class' => 'col-md-4 control-label')) }}
														<div class="col-md-8">
															{{ Form::select('cata_id', $cataloguePosition, null, array('class' => 'form-control select2')) }}
															<span class="error">{{ @$error_messages['cata_id'][0] }}</span>
														</div>
													</div>
													<div class="form-group">
														{{ Form::label('nickname', 'Nickname', array('class' => 'col-md-4 control-label')) }}
														<div class="col-md-8">															
															<?php 
																if(!isset($position['nickname'])){
																	$position['nickname'] = null; 
																}
															?>
															{{ Form::text('nickname', $position['nickname'], array('class' => 'form-control', 'placeholder' => 'Nickname')) }}
															<span class="error">{{ @$error_messages['nickname'][0] }}</span>
														</div>
													</div>
													<div class="form-group">
														{{ Form::label('idIMDB', 'ID IMDB', array('class' => 'col-md-4 control-label')) }}
														<div class="col-md-8">
															{{ Form::text('idIMDB', null, array('class' => 'form-control', 'placeholder' => 'ID IMDB')) }}
															<span class="error">{{ @$error_messages['idIMDB'][0] }}</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Detail Information</h3>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-heading">
													<h3 class="panel-title">English Description</h3>
												</div>
												<div class="panel-body">
													<div class="form-group">
														{{ Form::textarea('en_description', null, array('class' => 'form-control')) }}
														<span class="error">{{ @$error_messages['en_description'][0] }}</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-heading">
													<h3 class="panel-title">Vietnamese Description</h3>
												</div>
												<div class="panel-body">
													<div class="form-group">
														{{ Form::textarea('vn_description', null, array('class' => 'form-control')) }}
														<span class="error">{{ @$error_messages['vn_description'][0] }}</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-11"></div>
								<div class="col-sm-1">
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