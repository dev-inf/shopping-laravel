@extends('admin::layouts.master')
@section('content')
	<iframe src="{{ asset('/public/filemanager/filemanager/dialog.php') }}" style="width:100%;height:400px"></iframe>
@stop