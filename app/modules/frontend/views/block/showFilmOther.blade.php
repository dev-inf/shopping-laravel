@if (!empty($data))
	<div class="row otherFilm">
		<div class="page-header">
			<h1>Tác phẩm <small>Sản phẩm tâm huyết.</small></h1>
		</div>
		<div class="posterList">
			@foreach ($data as $item)
				<div class="col-xs-6 col-sm-4 col-md-3 portfolioItem" data-toggle="modal" data-target="#myModal">
					@include('frontend::block.grid-video', ['data' => $item])
				</div>
			@endforeach
		</div>
	</div>
@endif