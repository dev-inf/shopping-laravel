@extends('frontend::layouts.master')
@section('content')
	<div class="row">
		<div class="col-sm-12 col-md-10">
			<ul id="breadcrumbs" class="hidden-xs">
				<li><a href="index.html">Trang chủ</a></li>
				<li><a href="" class="current">Xem phim</a></li>
			</ul>
			<div class="wrapper dataPlayer" data-id="{{ $film['id'] }}" data-link="{{ $film['epFirst']['link'] }}" data-banner="{{ $film['banner'] }}">
				<div id="player" class="jwplayer">Phim này không tồn tại hoặc bị lỗi</div>
			</div>
			@if (isset($film['dataEpDrama']))
				<div class="epFilm">
					<div class="btn-group">
						@if (count($film['dataEpDrama']) > 12)
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Các tập trước
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								{{{ $i = 0 }}}
								@foreach ($film['dataEpDrama'] as $itemDED)
									@if ($i < 12)
										<li><a href="javascript.void(0)" data-id="{{$itemDED['ep_id']}}" data-link="{{$itemDED['link']}}">Tập {{$itemDED['ep']}}</a></li>
									@endif
									{{{ $i++ }}}
								@endforeach
							</ul>
							{{{ $i = 0 }}}
							@foreach ($film['dataEpDrama'] as $itemDED)
								@if ($i > 12)
									<button class="btn btn-default" type="button"><a href="javascript.void(0)" data-id="{{$itemDED['ep_id']}}" data-link="{{$itemDED['link']}}">Tập {{$itemDED['ep']}}</a></button>
								@endif
								{{{ $i++ }}}
							@endforeach
						@else
							@foreach ($film['dataEpDrama'] as $itemDED)
								<button class="btn btn-default" type="button"><a href="javascript.void(0)" data-id="{{$itemDED['ep_id']}}" data-link="{{$itemDED['link']}}">Tập {{$itemDED['ep']}}</a></button>
							@endforeach
						@endif
					  </div>
				</div>
			@endif
			<div class="descriptionMain hidden-xs">
				<div class="page-header">
					<div class="media">
						<a class="pull-left" href="play.html">
							<img class="media-object lazy img-responsive" data-original="{{ $film['poster'] }}" alt="{{ $film['en_title'] }}" width="200" height="290">
						</a>
						<div class="media-body">
							<h4 class="media-heading">Thông tin phim</h4>
							<p>
								<b>Tên phim:</b> 
								@if ($film['vn_title'] != "")
									{{ $film['vn_title'] }} - 
								@endif
								{{ $film['en_title'] }}
							</p>
							@if ($film['release_date'] != "")
								<p><b>Ngày công chiếu:</b> {{ $film['release_date'] }}</p>
							@endif
							@if ($film['imdb_rating'] != "")
								<p><b>Điểm IMDB:</b> <a href="">{{ $film['imdb_rating'] }}</a></p>
							@endif
							@foreach ($film['position'] as $keyP => $itemP)
								<p><b>{{ $keyP }}:</b>
									<?php 
										$i = 1;
										$parameter = ',';
										$totalItem = count($itemP);
									?>
									@foreach ($itemP as $itemIP)
										@if ($i == $totalItem)
											<?php
												$parameter = '';
											?>									
										@endif
										<a href="{{URL::route('position', array('id' => $itemIP['pos_id'], 'fullname' => $itemIP['fullname_url'], 'cata_url' => $itemIP['cata_url']))}}">{{ $itemIP['fullname'] }}</a>{{$parameter}}
										<?php 
											$i++;
										?>	
									@endforeach
								</p>
							@endforeach
							@if ($film['description'] != "")
								<p><b>Tóm tắt:</b> {{$film['description']}}</p>
							@endif
						</div>
						@if ($film['id_youtube'] != "")
							<a href="./#{{$film['id_youtube']}}" class="btn btn-info trailer" id="{{$film['id_youtube']}}}" data-title="{{$film['en_title']}}" data-toggle="modal" data-target="#myModalTrailer">
								<span class="glyphicon glyphicon-facetime-video"></span> Trailer
							</a>
						@endif
					</div>
				</div>
				@if ($film['description'] != "")
					<div id="desFilm" class="description">
						<p>{{$film['description']}}</p>
					</div>
				@endif
			</div>
		</div>
		<div class="col-sm-12 col-md-2 col-lg-2 hidden-xs hidden-sm">
			<button type="button" class="btn btn-primary btn-lg switch">Turn On/Off Light</button>
			<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
		</div>

		<div class="col-sm-5 boxCommentFacebook">
			<div class="page-header">
				<h1>Tác phẩm <small>Sản phẩm tâm huyết.</small></h1>
			</div>
			<div class="fb-comments" data-href="http://example.com/comments" data-numposts="7" data-colorscheme="light"></div>
		</div>
		<div class="col-sm-7">
			@include('frontend::block.showFilmOther', ['data' => \Films::getFilmOther($film['id'],$film['cata_id'], 8)])
		</div>
	</div>
@stop