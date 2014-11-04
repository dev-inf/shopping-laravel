@extends('admin::layouts.master')
@section('title','Ep of Film Manager')
@section('content')
	<input type="hidden" id="remote-url" value="{{ URL::route('filmEp.modify') . '?film_id=' . $film_id }}">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				List Ep of Film
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="list-inline btn-special">
					<li><a class="btn btn-info tooltipElement modify-ep-btn" data-toggle="tooltip" data-placement="top" data-original-title="Add" href="javascript:void(0)"><i class="fa fa-plus"></i></a></li>
					<li><a class="btn btn-danger remove tooltipElement" data-type="multi" data-table="gender" data-toggle="tooltip" data-placement="top" data-original-title="Delete" href="javascript:void(0)"><i class="fa fa-times"></i></a></li>
					<li><a class="btn btn-warning tooltipElement" data-toggle="tooltip" data-placement="top" data-original-title="Export" href="#"><i class="fa fa-file-excel-o"></i></a></li>
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
					<table id="filmEp" class="table table-striped table-bordered table-hover" data-pagelength="10" data-extend-url="{{{ $film_id != '' ? '/' . $film_id : '' }}}">
						<thead>
							<tr>
								<th data-enable-sort="false" data-render="renderFirstColumn" data-swidth="1%"><input class="check-all" type="checkbox"></th>
								<th data-data="id" data-swidth="5%">No</th>
								<th data-data="section">Section</th>
								<th data-data="title">Film</th>
								<th data-data="ep">EP</th>
								<th data-data="link">Link</th>
								<th data-data="totalSub">Sub</th>
								<th data-data="time">Time</th>
								<th data-data="quality">Quality</th>
								<th data-data="view">View</th>
								<th data-render="renderModalVideo" data-data="viewTest">View Test</th>
								<th data-render="renderSetting">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
<div class="modal fade" id="modify-ep-modal" tabindex="-1" role="dialog" aria-labelledby="modify-ep-modal-title" aria-hidden="true" data-is-destroy="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modify-ep-modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        Access Denied!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
{{ View::make('admin::partials.file-modal', array('type' => '1', 'id' => 'ep_link')) }}
@stop