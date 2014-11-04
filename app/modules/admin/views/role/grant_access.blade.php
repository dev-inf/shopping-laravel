@extends('admin::layouts.master')
@section('content')
	<input type="hidden" id="role-id" value="{{ $role_id }}">
	{{ Session::has('success') ? '<div class="alert alert-success">' . Session::get('success') .'</div>' : '' }}
	<?php
		if(!empty($modules)){
			foreach($modules as $module){
				?>
		<div style="margin-bottom: 10px" class="col-sm-12 col-md-6 col-lg-3"><a href="javascript:void(0)" class="btn btn-info btn-get-action" data-id="{{ $module['id'] }}" data-name="{{ $module['name'] }}" style="width:90%">{{ $module['name'] }}</a></div>
				<?php
			}
		}
	?>
	{{ View::make('admin::partials.grant-access-modal') }}
@stop