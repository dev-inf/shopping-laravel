@extends('admin::layouts.master')
@section('title','Language Manager')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Language of Film
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="list-inline btn-special">
					<li><a class="btn btn-info tooltipElement" data-toggle="tooltip" data-placement="top" data-original-title="Add" href="{{ URL::route('language.modify') }}"><i class="fa fa-plus"></i></a></li>
					<li><a class="btn btn-danger remove tooltipElement" data-type="multi" data-table="gender" data-toggle="tooltip" data-placement="top" data-original-title="Delete" href="javascript:void(0)"><i class="fa fa-times"></i></a></li>
					<li><a class="btn btn-warning tooltipElement export" data-toggle="tooltip" data-placement="top" data-original-title="Export" href="#"><i class="fa fa-file-excel-o"></i></a></li>
				</ul>
				{{ View::make('admin::partials.filter', array(
					'items' => array(
						array(
							'type' => 'number',
							'name' => 'lang.id',
							'title' => 'Id',
						),
						array(
							'name' => 'name',
							'placeholder' => 'Language',
							'op' => 'LIKE',
						),
						array(
							'name' => 'code',
							'placeholder' => 'Code',
							'op' => 'LIKE',
						),
						array(
							'type' => 'number',
							'name' => 'total_sub',
							'title' => 'Total Sub',
						)
					)
				)) }}
				<div class="table-responsive">
					<table id="language" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th data-enable-sort="false" data-render="renderFirstColumn" data-swidth="1%"><input class="check-all" type="checkbox"></th>
								<th data-data="id" data-swidth="5%">No</th>
								<th data-data="name">Name</th>
								<th data-data="code">Code</th>
								<th data-data="total_sub">Total Sub</th>
								<th data-render="renderSetting">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop