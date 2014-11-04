@extends('admin::layouts.master')
@section('title','Film Access Manager')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				List Film Access
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="list-inline btn-special">
					<li><a class="btn btn-danger remove tooltipElement" data-type="multi" data-table="gender" data-toggle="tooltip" data-placement="top" data-original-title="Delete" href="javascript:void(0)"><i class="fa fa-times"></i></a></li>
					<li><a class="btn btn-warning tooltipElement export" data-toggle="tooltip" data-placement="top" data-original-title="Export" href="javascript:void(0)"><i class="fa fa-file-excel-o"></i></a></li>
				</ul>
				{{ View::make('admin::partials.filter', array(
					'items' => array(
						array(
							'type' => 'number',
							'name' => 'id',
							'title' => 'Id',
						),
						array(
							'name' => 'title',
							'placeholder' => 'Title',
							'op' => 'LIKE',
						)
					)
				)) }}
				<div class="table-responsive">
					<table id="filmAccess" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th data-enable-sort="false" data-render="renderFirstColumn" data-swidth="1%"><input class="check-all" type="checkbox"></th>
								<th data-data="id" data-swidth="5%">No</th>
								<th data-render="renderTitle" data-data="title">Title</th>
								<th data-data="release_date">Release Date</th>
								<th data-data="accessed">Accessed</th>
								<th data-render="renderSetting">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop