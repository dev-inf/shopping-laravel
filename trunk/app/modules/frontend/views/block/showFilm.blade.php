@if (!empty($data))
	@if ($filter == 1)
		@section('menuRight')
			@include('frontend::block.menu-right')
		@stop
	@endif
	<div class="row">
		<div class="page-header">
		  <h1>{{ $mainTitle }} <span id="showFilter"></span> <small>{{ $subTitle }}</small></h1>
		</div>
		<div id="posterList" class="posterList portfolio">
			@foreach ($data as $item)
				<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 portfolioItem @if ($filter == 1) mix {{$item['mix']}} @endif" data-my-order="1">
					@if ($item['idYoutube'] != "")
					<a href="./#{{ $item['idYoutube'] }}" class="btn btn-info trailer" id="{{ $item['idYoutube'] }}" data-title="{{ $item['title'] }}" data-toggle="modal" data-target="#myModalTrailer">
						<span class="glyphicon glyphicon-facetime-video"></span> Trailer
					</a>
					@endif
					<a href="{{URL::route('film', array('id' => $item['id'], 'title' => $item['url']))}}" class="thumbnail">
						<img class="lazy img-responsive" data-original="{{ $item['poster'] }}" alt="{{ $item['title'] }}">
						<noscript><img src="{{ $item['poster'] }}" alt="{{ $item['title'] }}"></noscript>
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
							<div class="glyphicon glyphicon-play"></div>
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
	</div>
@endif