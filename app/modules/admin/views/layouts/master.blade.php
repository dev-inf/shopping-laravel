<!DOCTYPE html>

<html>
	
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Admin Center Panel</title>

	<!-- Core CSS - Include with every page -->
	<link href="{{ asset('/public/libraries/bootstrap/css/bootstrap.min.css') }}" media="screen" rel="stylesheet">
	<link href="{{ asset('/public/styles/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

	<!-- Page-Level Plugin CSS-->
    <link href="{{ asset('/public/scripts/plugins/css3aw/css/jquery.mCustomScrollbar.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/public/scripts/plugins/css3aw/css/blue.css') }}" rel="stylesheet" media="screen">
	
	<link href="{{ asset('/public/styles/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/public/styles/plugins/timeline/timeline.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/scripts/plugins/select2/select2-bootstrap.css') }}" rel="stylesheet">
	<!-- Tables -->
	<link href="{{ asset('/public/styles/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">

	<link href="{{ asset('/public/styles/admin/style.css') }}" media="screen" rel="stylesheet">

</head>
	
<body>
	<header class="css3aw-theme-light">
		<div id="css3aw-main-menu-wrapper">
			<div id="css3aw-menu-trigger-icon">
				<span class="css3aw-menu-dash"></span>
				<span class="css3aw-menu-dash"></span>
				<span class="css3aw-menu-dash"></span>
			</div>
			<div id="css3aw-main-menu-container">
				@include('admin::partials.menu')
			</div>
		</div>
		<h1><a href="index.html">Admin Center Panel v1.0</a></h1>
	</header>
	@include('admin::partials.navbar')
	
	<div id="wrapper" class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">@yield('title')</h1>
				{{ Breadcrumbs::renderIfExists() }}
			</div>
			<div class="col-lg-12">
				@yield('content')
			</div>
		</div>
	</div>
	@include('admin::partials.file-modal-default')
</body>
<!--[if lt IE 9]><script type="text/javascript" src="http://odcvoyage.com/js/html5.js"></script><![endif]-->
<!-- Core Scripts - Include with every page -->
<script type="text/javascript" src="{{ asset('/public/libraries/jquery/jquery-2.0.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/libraries/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/css3aw/css3aw.js') }}"></script>

<!-- Page-Level Plugin Scripts -->
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/jquery.nicescroll.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/morris/raphael-2.1.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/morris/morris.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/libraries/datatable/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/libraries/datatable/api/fnStandingRedraw.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/dataTables/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/libraries/bootstrap-plugin/boot-box/bootbox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/holder.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/select2/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/datepicker/js/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/charts/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/charts/highcharts-3d.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/charts/modules/exporting.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/charts/modules/data.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/charts/modules/drilldown.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/colorpicker/colorpicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/colorpicker/eye.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/colorpicker/utils.js') }}"></script>
<script type="text/javascript" src="{{ asset('/public/scripts/plugins/jwplayer/jwplayer.js') }}"></script>

<script type="text/javascript">
  var $app = {
      'module': "{{ $currentMvc['module'] }}",
      'controller': "{{ $currentMvc['controller'] }}",
      'action': "{{ $currentMvc['action'] }}"
  };
	var base_url = "{{ Config::get('app.url') }}";
</script>
<script type="text/javascript" data-main="{{ asset('/public/libraries/admin/main-backbone') }}" src="{{ asset('/public/libraries/require.js?v=' . time()) }}"></script>
</html>