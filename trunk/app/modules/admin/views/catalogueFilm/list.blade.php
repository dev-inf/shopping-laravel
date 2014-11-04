@extends('admin::layouts.master')
@section('title','Catalogue of Film Manager')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				List Catalogue of Film
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="list-inline btn-special">
					<li><a class="btn btn-info tooltipElement" data-toggle="tooltip" data-placement="top" data-original-title="Add" href="{{ URL::route('catalogueFilm.modify') }}"><i class="fa fa-plus"></i></a></li>
					<li><a class="btn btn-danger remove tooltipElement" data-type="multi" data-table="catalogue_film" data-toggle="tooltip" data-placement="top" data-original-title="Delete" href="javascript:void(0)"><i class="fa fa-times"></i></a></li>
					<li><a class="btn btn-warning tooltipElement export" data-toggle="tooltip" data-placement="top" data-original-title="Export" href="#"><i class="fa fa-file-excel-o"></i></a></li>
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
							'placeholder' => 'Catalogue of Film',
							'op' => 'LIKE',
						),
						array(
							'type' => 'number',
							'name' => 'total_movie',
							'title' => 'Movie',
						),
						array(
							'type' => 'number',
							'name' => 'total_drama',
							'title' => 'Drama',
						)
					)
				)) }}
				<div class="table-responsive">
					<table id="catalogueFilm" class="table table-striped table-bordered table-hover" data-pagelength="10">
						<thead>
							<tr>
								<th data-enable-sort="false" data-render="renderFirstColumn" data-swidth="1%"><input class="check-all" type="checkbox"></th>
								<th data-data="id" data-swidth="5%">No</th>
								<th data-data="name">Catalogue</th>
								<th data-data="total_movie">Movie</th>
								<th data-data="total_drama">Drama</th>
								<th data-render="renderSetting">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop