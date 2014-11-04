@extends('admin::layouts.master')
@section('title','Resource Manager')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				List Resources
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="list-inline btn-special">
					<li><a class="btn btn-info tooltipElement" data-toggle="tooltip" data-placement="top" data-original-title="Add" href="{{ URL::route('modify_resource') }}"><i class="fa fa-plus"></i></a></li>
					<li><a class="btn btn-danger remove tooltipElement" data-type="multi" data-table="users" data-toggle="tooltip" data-placement="top" data-original-title="Delete" href="javascript:void(0)"><i class="fa fa-times"></i></a></li>
					<li><a class="btn btn-warning tooltipElement" data-toggle="tooltip" data-placement="top" data-original-title="Export" href="#"><i class="fa fa-file-excel-o"></i></a></li>
					<li><a class="btn btn-warning tooltipElement" data-toggle="tooltip" data-placement="top" data-original-title="Print" href="#"><i class="fa fa-print"></i></a></li>
				</ul>

        {{ View::make('admin::partials.filter', array(
        	'items' => array(
        		array(
        			'type' => 'number',
        			'name' => 'id',
        			'title' => 'Id',
        		),
        		array(
        			'name' => 'name',
       				'placeholder' => 'Name',
       				'op' => 'LIKE',
        		),
        	)
        )) }}

				<div class="col-lg-12">&nbsp;</div>
				<div class="table-responsive">
					<table id="permissions" data-method="resources/show" class="table table-striped table-bordered table-hover" data-pagelength="10">
						<thead>
							<tr>
								<th data-enable-sort="false" data-render="renderFirstColumn" data-swidth="1%"><input class="check-all" type="checkbox"></th>
								<th data-data="id" data-swidth="5%">No</th>
								<th data-data="name">Name</th>
								<th data-data="action">Action</th>
								<th data-enable-sort="false" data-render="renderResourceSetting">Settings</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop