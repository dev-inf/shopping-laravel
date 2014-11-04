@if (!empty($data))
<div class="row">	
	<div class="page-header">
		<h1>{{ $mainTitle }} <small>{{ $subTitle }}</small></h1>
	</div>
	<div class="posterList">
		@foreach ($data as $item)
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 portfolioItem video" id="{{ $item['idYoutube'] }}" data-title="{{ $item['title'] }}" data-toggle="modal" data-target="#myModalTrailer">
				<a href="./#{{ $item['idYoutube'] }}" class="thumbnail">
					<img class="lazy img-responsive" data-original="http://i1.ytimg.com/vi/{{ $item['idYoutube'] }}/mqdefault.jpg" alt="{{ $item['title'] }}">
					<noscript><img src="http://i1.ytimg.com/vi/{{ $item['idYoutube'] }}/mqdefault.jpg"></noscript>
					<div class="thumbnailHover">
						<div class="glyphicon glyphicon-play"></div>
						<div class="item-title">
							<p>{{ $item['title'] }}</p>
						</div>
					</div>
				</a>
			</div>
		@endforeach
	</div>
</div>
@endif