@extends('admin::layouts.master')
@section('title', 'Dashboard')
@section('content')
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				User Statistics
				<a href="javascript:void(0)" class="btn btn-primary pull-right" id="updateUserStatistics">Update</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div id="userStatistics" style="height: 400px"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				View Statistics
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div id="viewStatistics" style="height: 400px"></div>
			</div>
		</div>
	</div>
@stop