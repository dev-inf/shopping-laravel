@if ($data['idYoutube'] != "")
<a href="./#{{ $data['idYoutube'] }}" class="btn btn-info trailer" id="{{ $data['idYoutube'] }}" data-title="{{ $data['title'] }}" data-toggle="modal" data-target="#myModalTrailer">
	<span class="glyphicon glyphicon-facetime-video"></span> Trailer
</a>
@endif
<a href="{{URL::route('film', array('id' => $data['id'], 'title' => $data['url']))}}" class="thumbnail">
	<img class="lazy img-responsive" data-original="{{ $data['poster'] }}" alt="{{ $data['title'] }}" width="260" height="350">
	<noscript><img src="{{ $data['poster'] }}" width="260" height="350"></noscript>
	@if ($data['ribbon'] != 0)
		<div id="ribbonWrapper">
			<div id="ribbon">
				<div class="container">
					<div class="base">{{ $data['ribbonDescription'] }}</div>
					<div class="left_corner"></div>
					<div class="right_corner"></div>
				</div>
			</div>
		</div>
	@endif
	<div class="thumbnailHover">
		<div class="play-gallery"></div>
		<div class="item-title">
			<p>{{ $data['title'] }}</p>
			<hr />
			<p>@if ($data['releaseDate'] != "")Công chiếu: {{ $data['releaseDate'] }}@endif</p>
			<p><span class="mostView">Xem: {{ $data['view'] }} lần</span><span class="imdbPoint">@if ($data['imdbPoint'] != "")IMDB: {{ $data['imdbPoint'] }}@endif</span></p>
		</div>
	</div>
</a>