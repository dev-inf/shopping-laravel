@extends('admin::layouts.master')
@section('title','Movie Manager')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				List Movie
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="list-inline btn-special">
					<li><a class="btn btn-info tooltipElement" data-toggle="tooltip" data-placement="top" data-original-title="Add" href="{{ URL::route('filmMovie.modify') }}"><i class="fa fa-plus"></i></a></li>
					<li><a class="btn btn-danger remove tooltipElement" data-type="multi" data-table="gender" data-toggle="tooltip" data-placement="top" data-original-title="Delete" href="javascript:void(0)"><i class="fa fa-times"></i></a></li>
					<li><a class="btn btn-warning tooltipElement export" ids="1" data-toggle="tooltip" data-placement="top" data-original-title="Export" href="#"><i class="fa fa-file-excel-o"></i></a></li>
				</ul>
				{{ View::make('admin::partials.filter', array(
					'items' => array(
						array(
							'type' => 'number',
							'name' => 'film.id',
							'title' => 'Id',
						),
						array(
							'name' => 'title',
							'placeholder' => 'Title',
							'op' => 'LIKE',
						),
						array(
							'type' => 'number',
							'name' => 'total_view',
							'title' => 'Total View',
						)
					)
				)) }}
				<div class="table-responsive">
				<p class="help-block"><strong>PL:</strong> Publish, <strong>CS: </strong> Coming Soon, <strong>DP:</strong> Depute, <strong>RD:</strong> Release Date, <strong>P:</strong> Producer, <strong>D:</strong> Director, <strong>C:</strong> Cast, <strong>E:</strong> Ep, <strong>S:</strong> Sub, <strong>B:</strong> Banner, <strong>I:</strong> IMDB, <strong>V:</strong> View</p>
					<table id="filmMovie" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th data-enable-sort="false" data-render="renderFirstColumn" data-swidth="1%"><input class="check-all" type="checkbox"></th>
								<th data-data="id" data-swidth="5%">No</th>
								<th data-render="renderImage" data-data="poster">Poster</th>
								<th data-render="renderTitle" data-data="title">Title</th>
								<th data-render="renderPublish" data-data="publish">PL</th>
								<th data-render="renderComingsoon" data-data="comingsoon">CS</th>
								<th data-render="renderDepute" data-data="depute">DP</th>
								<th data-data="release_date">RD</th>
								<th data-render="renderParams" data-data="producer">P</th>
								<th data-render="renderParams" data-data="director">D</th>
								<th data-render="renderParams" data-data="cast">C</th>
								<th data-render="renderParams" data-data="ep">E</th>
								<th data-render="renderParams" data-data="sub">S</th>
								<th data-render="renderParams" data-data="banner">B</th>
								<th data-render="renderParams" data-data="imdb">I</th>
								<th data-data="total_view">V</th>
								<th data-render="renderSetting">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop