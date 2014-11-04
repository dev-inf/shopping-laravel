<ul>
	@if ($data)
		@foreach ($data as $item)
			<li><a href="{{URL::route('catalogue', array('id' => $item['id'], 'url' => $item['cata_url']))}}">{{ $item['cata_name'] }}</a></li>
		@endforeach
	@endif
</ul>