@extends('frontend::layouts.master')
@section('content')
	<div class="row">
		@if($film)
			<ul id="breadcrumbs" class="hidden-xs">
				<li><a href="/">Trang chủ</a></li>
				<li><a href="#"></a></li>
			</ul>
			<div class="page-header">
			  <h1> <span id="showFilter"></span> <small></small></h1>
			</div>
			<div class="posterList portfolio">
				@foreach ($film as $item)

					<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 portfolioItem">
						@if ($item['idYoutube'] != "")
						<a href="./#{{ $item['idYoutube'] }}" class="btn btn-info trailer" id="{{ $item['idYoutube'] }}" data-title="{{ $item['title'] }}" data-toggle="modal" data-target="#myModalTrailer">
							<span class="glyphicon glyphicon-facetime-video"></span> Trailer
						</a>
						@endif
						<a href="{{URL::route('film', array('id' => $item['id'], 'title' => $item['url']))}}" class="thumbnail">
							<img class="lazy img-responsive" data-original="{{ $item['poster'] }}" alt="{{ $item['title'] }}" width="260" height="350">
							<noscript><img src="{{ $item['poster'] }}" width="260" height="350"></noscript>
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
									<p>{{ $item['title'] }}</p>
									<hr />
									<p>@if ($item['releaseDate'] != "")Công chiếu: {{ $item['releaseDate'] }}@endif</p>
									<p><span class="mostView">Xem: {{ $item['view'] }} lần</span><span class="imdbPoint">@if ($item['imdbPoint'] != "")IMDB: {{ $item['imdbPoint'] }}@endif</span></p>
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