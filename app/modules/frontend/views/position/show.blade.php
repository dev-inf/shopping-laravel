@extends('frontend::layouts.master')
@section('content')
	<div class="row">
		@if($position)
			<ul id="breadcrumbs" class="hidden-xs">
				<li><a href="/">Trang chủ</a></li>
				<li><a href="#">{{ $position['cata_name'] }}</a></li>
			</ul>
			<div class="page-header">
			  <h1>{{ $position['cata_name'] }} <span id="showFilter"></span> <small>{{ $position['cata_description'] }}</small></h1>
			</div>
			<div class="posterList portfolio">
				@foreach ($position['data'] as $item)

					<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 portfolioItem">
						<a href="{{URL::route('position', array('id' => $item['id'], 'fullname' => $item['fullname_url'], 'cata_url' => $item['cata_url']))}}" class="thumbnail">
							<img class="lazy img-responsive" data-original="{{ $item['avatar'] }}" alt="{{ $item['fullname'] }}" width="260" height="350">
							<noscript><img src="{{ $item['avatar'] }}" width="260" height="350"></noscript>
							@if ($item['ribbon'] != 0)
							<div class="ribbonWrapper">
								<div class="ribbon">
									<div class="container">
										<div class="base"><span>{{ $item['ribbonDescription'] }}</span></div>
										<div class="left_corner"></div>
										<div class="right_corner"></div>
									</div>
								</div>
							</div>
							@endif
							<div class="thumbnailHover">
								<div class="play-gallery"></div>
								<div class="item-title">
									<p>{{ $item['fullname'] }}</p>
									<hr />
	<!--								<p>Công chiếu: 14/03/2014</p>
									<p><span class="mostView">Xem: 1.000.000</span><span class="imdbPoint">IMDB: 7.2</span></p>-->
								</div>
							</div>
						</a>
					</div>
				@endforeach
			</div>
		@endif
		<div class="col-xs-12">
			<ul class="pagination">
				<li class="disabled"><a href="#">&laquo;</a></li>
				<li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">6</a></li>
				<li><a href="#">7</a></li>
				<li><a href="#">8</a></li>
				<li><a href="#">9</a></li>
				<li><a href="#">10</a></li>
				<li><a href="#">&raquo;</a></li>
			</ul>
		</div>
	</div>
@stop