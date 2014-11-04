@if (!empty($data))
<div class="row film-depute">
	<div class="page-header">
	  <h1>{{ $mainTitle }} <small>{{ $subTitle }}</small></h1>
	</div>
	<div class="col-lg-2 hidden-xs"></div>
	<div class="col-xs-12 col-lg-8">
		<div id="owl-slider" class="owl-carousel owl-theme">
			@foreach ($data as $item)
				<div class="item"><a href="{{ $item['url'] }}"><img class="lazyOwl" data-src="{{ $item['banner'] }}" alt="{{ $item['title'] }}" ></a></div>
			@endforeach
		</div>
	</div>
	<div class="col-lg-2 hidden-xs"></div>
</div>
@endif