@extends('frontend::layouts.master')
@section('content')
	<ul id="breadcrumbs" class="hidden-xs">
		<li><a href="/">Trang chủ</a></li>
		<li><a href="" class="current">{{ $position['cata_name'] }}</a></li>
	</ul>
	<div class="row cast descriptionMain">
		<div class="page-header">
			<h1>{{ $position['cata_name'] }} <small>{{ $position['cata_description'] }}</small></h1>
		</div>
		<div class="media description">
			<a class="pull-left" href="#">
				<img class="media-object" src="{{ $position['avatar'] }}" alt="{{ $position['fullname'] }}" width="214" height="317">
			</a>
			<div class="media-body">
				<div class="ribbonWrapper1 hidden-xs">
					<div class="ribbon1">
						<div class="container1">
						<div class="left_corner1"></div>
							<div class="right_corner1"></div>
							<div class="base1"><span>BIRTHDAY</span></div>
						</div>
					</div>
				</div>
				<h4 class="media-heading">{{ $position['fullname'] }}</h4>
					@if ($position['nickname'] != '')
						<p>Nickname: {{ $position['nickname'] }}</p>
					@endif
					@if ($position['date_of_birth'] != '')
						<p>Sinh nhật: {{ $position['date_of_birth'] }}</p>
					@endif
					@if ($position['country'] != '')
						<p>Quê quán: {{ $position['country'] }}</p>
					@endif
					@if ($position['body_height'] != '')
						<p>Chiều cao: {{ $position['body_height'] }} m</p>
					@endif
<!--					<p>Considered one of the pioneer screenwriters of the action genre, Black made his mark with his Lethal Weapon (1987) screenplay. He also collaborated on the story of the sequel, Lethal Weapon 2 (1989). Each successive script he turned in had a higher price attached it, from The Last Boy Scout (1991) to The Long Kiss Goodnight (1996), and in between a re-write on the McTiernan/Schwarzenegger Last Action Hero (1993) script.</p>
					<p>Giải thưởng</p>
					<h3>Academy of Science Fiction, Fantasy &amp; Horror Films, USA</h3>
					<table class="table table-bordered">
						<tbody><tr>  
							<td align="center" rowspan="1" class="award_year">
								<a href="#"> 2006</a>
							</td>
							<td rowspan="1" class="award_outcome">
								<b>Won</b><br>
								<span class="award_category">Filmmaker's Showcase Award</span>
							</td>
							<td class="award_description">
								<div class="award_detail_notes">
										<p class="full-note">Black wrote the 1987 action film, <a href="#">Lethal Weapon</a> (1987), as well as <a href="#">The Last Boy Scout</a> (1991) for producer <a href="#">Joel Silver</a>. Black is being recognized for his work in the 2005 Warner Bros. film, <a href="#">Kiss Kiss Bang Bang</a> (2005). The film has received five Saturn Award nominations.</p>
								</div>
							</td>
						</tr>  

						<tr>  
							<td align="center" rowspan="1" class="award_year">
								<a href="#"> 1994</a>
							</td>
							<td rowspan="1" class="award_outcome">
								<b>Nominated</b><br>
								<span class="award_category">Saturn Award</span>
							</td>
							<td class="award_description">
								Best Writing<br>
								<a href="#">Last Action Hero</a>
								<span class="title_year">(1993)</span>
								<br>
								<div class="shared_with">Shared with:</div>
								<ul>
									<a href="#">David Arnott</a>
									<br>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>-->
			</div>
		</div>
	</div>
	@include('frontend::block.showFilmPosition', ['data' => \Films::getFilmPosition($position['id'])])
@stop