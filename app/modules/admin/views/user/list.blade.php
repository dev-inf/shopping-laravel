@extends('admin::layouts.master')
@section('title','User Manager')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				List User
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="list-inline btn-special">
					<li><a class="btn btn-info tooltipElement" data-toggle="tooltip" data-placement="top" data-original-title="Add" href="{{ URL::route('users.modify') }}"><i class="fa fa-plus"></i></a></li>
					<li><a class="btn btn-danger remove tooltipElement" data-type="multi" data-table="users" data-toggle="tooltip" data-placement="top" data-original-title="Delete" href="javascript:void(0)"><i class="fa fa-times"></i></a></li>
					<li><a class="btn btn-warning tooltipElement export" data-toggle="tooltip" data-placement="top" data-original-title="Export" href="javascript:void(0)"><i class="fa fa-file-excel-o"></i></a></li>
				</ul>
				{{ View::make('admin::partials.filter', array(
					'items' => array(
						array(
							'type' => 'number',
							'name' => 'u.id',
							'title' => 'Id',
						),
						array(
							'name' => 'username',
							'placeholder' => 'Username',
							'op' => 'LIKE',
						),
						array(
							'name' => 'fullname',
							'placeholder' => 'Fullname',
							'op' => 'LIKE',
						),
						array(
							'name' => 'email',
							'placeholder' => 'Email',
							'op' => 'LIKE',
						),
						array(
							'type' => 'checkbox',
							'name' => 'r.id',
							'title' => 'Level',
							'options' => $all_roles,
						),
						array(
							'type' => 'checkbox',
							'name' => 'status',
							'title' => 'Status',
							'options' => array(
								'0' => 'Off',
								'1' => 'On',
							),
						),
					)
				)) }}
				<div class="table-responsive">
					<table id="users" class="table table-striped table-bordered table-hover" data-pagelength="10">
						<thead>
							<tr>
								<th data-enable-sort="false" data-render="renderFirstColumn" data-swidth="1%"><input class="check-all" type="checkbox"></th>
								<th data-data="id" data-swidth="5%">No</th>
								<th data-data="username">Username</th>
								<th data-data="fullname">Fullname</th>
								<th data-data="email">Email</th>
								<th data-data="gender">Gender</th>
								<th data-data="phone">Phone</th>
								<th data-data="role" data-render="renderLevel">Level</th>
								<th data-data="status" data-render="renderStatus">Status</th>
								<th data-enable-sort="false" data-render="renderSetting">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop