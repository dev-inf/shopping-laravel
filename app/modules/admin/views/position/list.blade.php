@extends('admin::layouts.master')
@section('title','Position Manager')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				List Position
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="list-inline btn-special">
					<li><a class="btn btn-info tooltipElement" data-toggle="tooltip" data-placement="top" data-original-title="Add" href="{{ URL::route('position.modify') }}"><i class="fa fa-plus"></i></a></li>
					<li><a class="btn btn-danger remove tooltipElement" data-type="multi" data-table="position" data-toggle="tooltip" data-placement="top" data-original-title="Delete" href="javascript:void(0)"><i class="fa fa-times"></i></a></li>
					<li><a class="btn btn-warning tooltipElement export" data-toggle="tooltip" data-placement="top" data-original-title="Export" href="#"><i class="fa fa-file-excel-o"></i></a></li>
				</ul>
				{{ View::make('admin::partials.filter', array(
					'items' => array(
						array(
							'type' => 'number',
							'name' => 'pos.id',
							'title' => 'Id',
						),
						array(
							'name' => 'fullname',
							'placeholder' => 'Position',
							'op' => 'LIKE',
						),
						array(
							'type' => 'number',
							'name' => 'total_film',
							'title' => 'Total Film',
						)
					)
				)) }}
				<div class="table-responsive">
					<table id="position" class="table table-striped table-bordered table-hover" data-pagelength="10">
						<thead>
							<tr>
								<th data-enable-sort="false" data-render="renderFirstColumn" data-swidth="1%"><input class="check-all" type="checkbox"></th>
								<th data-data="id" data-swidth="5%">No</th>
								<th data-data="catalogue">Position</th>
								<th data-render="renderImage" data-data="image">Image</th>
								<th data-data="fullname">Fullname</th>
								<th data-data="date_of_birth">Birthday</th>
								<th data-data="country">Country</th>
								<th data-data="total_film">Total Film</th>
								<th data-render="renderSetting">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop