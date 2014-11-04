<h4><span>{{ $title }}</span></h4>
@if ($list == 1)
	<ol class="footer-links">
		@foreach ($data as $item)
			<li><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
		@endforeach
	</ol>
@else
	<address>
		<strong>beforever.info, Việt Nam.</strong><br>
		<i class="icon-map-marker"></i> A37/3 ABC, P.18, Q.4<br>
		Hồ Chí Minh, Việt Nam<br>
		<i class="icon-phone-sign"></i> 0938.2311.89 Minh
	</address>
@endif