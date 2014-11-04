@extends('admin::layouts.master')
@section('title','Log Manager')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				List Log
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				{{ View::make('admin::partials.filter', array(
					'items' => array(
						array(
							'type' => 'number',
							'name' => 's.id',
							'title' => 'Id',
						),
						array(
							'name' => 'u.username',
							'placeholder' => 'Username',
							'op' => 'LIKE',
						)
					)
				)) }}
				<div class="table-responsive">
					<table id="log" class="table table-striped table-bordered table-hover" data-pagelength="10">
						<thead>
							<tr>
								<th data-enable-sort="false" data-render="renderFirstColumn" data-swidth="1%"><input class="check-all" type="checkbox"></th>
								<th data-data="id" data-swidth="5%">No</th>
								<th data-data="action">Action</th>
								<th data-data="message">Message</th>
								<th data-data="time">Time</th>
								<th data-data="username">Username</th>
								<th data-render="renderSetting">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop