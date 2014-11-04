@extends('frontend::layouts.master')
@section('content')
	@include('frontend::block.depute', ['mainTitle' => 'Đề Cử', 'subTitle' => 'Tuyển chọn khắc khe', 'data' => \Films::getFilmDepute()])
	@include('frontend::block.showFilm', ['filter' => 1, 'mainTitle' => 'Lọc theo', 'subTitle' => 'Sắp xếp thông minh.', 'data' => \Films::getFilm('filter', null, null, 20)])
	@include('frontend::block.showFilm', ['filter' => 0, 'mainTitle' => 'Sắp chiếu', 'subTitle' => 'Quả boom hẹn giờ', 'data' => \Films::getFilm('soon', null, null, 12)])
	@include('frontend::block.showVideo', ['mainTitle' => 'Video Clip', 'subTitle' => 'Ngắn gọn hài hước.', 'data' => \Films::getVideo(12)])
@stop