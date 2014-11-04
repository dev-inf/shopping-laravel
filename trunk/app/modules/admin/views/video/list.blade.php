@extends('admin::layouts.master')
@section('title','Video Manager')
@section('content')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				List Video
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="list-inline btn-special">
					<li><a class="btn btn-info tooltipElement updateTitle" data-toggle="tooltip" data-placement="top" data-original-title="Update Title" href="javascript:void(0)"><i class="fa fa-download"></i></a></li>
					<li><a class="btn btn-info tooltipElement" data-toggle="tooltip" data-placement="top" data-original-title="Add" href="{{ URL::route('video.modify') }}"><i class="fa fa-plus"></i></a></li>
					<li><a class="btn btn-danger remove tooltipElement" data-type="multi" data-table="video" data-toggle="tooltip" data-placement="top" data-original-title="Delete" href="javascript:void(0)"><i class="fa fa-times"></i></a></li>
					<li><a class="btn btn-warning tooltipElement export" data-toggle="tooltip" data-placement="top" data-original-title="Export" href="#"><i class="fa fa-file-excel-o"></i></a></li>
					<li><a class="btn btn-warning tooltipElement browse-file" data-toggle="tooltip" data-placement="top" data-original-title="Import" href="javascript:void(0)"><i class="fa fa-print"></i><input type="hidden" id="file-excel"></a></li>
				</ul>

		        {{ View::make('admin::partials.filter', array(
		        	'items' => array(
		        		array(
		        			'type' => 'number',
		        			'name' => 'v.id',
		        			'title' => 'Id',
		        		),
		        		array(
		        			'name' => 'code',
		       				'placeholder' => 'Code',
		       				'op' => 'LIKE',
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

				<div class="col-lg-12">&nbsp;</div>
				<div class="table-responsive">
					<table id="video" class="table table-striped table-bordered table-hover" data-pagelength="10">
						<thead>
							<tr>
								<th data-enable-sort="false" data-render="renderFirstColumn" data-swidth="1%"><input class="check-all" type="checkbox"></th>
								<th data-data="id" data-swidth="3%">No</th>
								<th data-data="title" data-swidth="20%">Title</th>
								<th data-data="url" data-swidth="30%">Url</th>
								<th data-render="renderPosterVideo" data-data="idYoutube">Poster</th>
								<th data-data="duration">Duration</th>
								<th data-data="viewYoutube">View</th>
								<th data-data="catalogue">Catalogue</th>
								<th data-render="renderParams" data-data="status">Status</th>
								<th data-render="renderModalVideo" data-data="viewTest">View Test</th>
								<th data-enable-sort="false" data-render="renderSetting">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
	{{ View::make('admin::partials.file-modal', array('type' => '2', 'id' => 'file-excel')) }}
@stop