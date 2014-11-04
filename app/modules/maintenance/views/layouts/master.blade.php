<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8" />

	<title>Website đang xây dựng</title>

	<!-- CSS -->
	<link rel="stylesheet" href="{{ asset('/public/styles/reset.css') }}">
	<link rel="stylesheet" href="{{ asset('/public/styles/maintenance/fonts/stylesheet.css') }}">
	<link rel="stylesheet" href="{{ asset('/public/styles/maintenance/style.css') }}">

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="{{ asset('/public/styles/ie.css') }}">
	<![endif]-->

	<!-- IE fix for HTML5 tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>

<body>

	<header>
		<h1>Chúng tôi đang xây dựng và hoàn thành website</h1>
		<p>Các lập trình viên đang làm việc để hoàn thành website trước khi bộ đếm ngược kết thúc!.</p>
	</header>

	<div id="main">
<!--		<div id="links">
			<div class="home"><a href="">http://1stwebdesigner.com/</a></div>
			<div class="support"><a href="">http://support.1wd.com/</a></div>
			<div class="browser"><a href="">Google Chrome OS. 10.X.23</a></div>
			<div class="books"><a href="">http://1wd.co/e-books/</a></div>
			<div class="download"><a href="">http://1wd.com/download/</a></div>
			<div class="ups"><a href="">UPS Signed Worldwide</a></div>
		</div>-->

		<div id="counter"></div>

		{{ Form::model(array(), array('url' => URL::route('index.subscribers'), 'method' => 'post')) }}
			{{ Form::text('email', null, array('class' => 'email', 'placeholder' => 'Nhập địa chỉ email vào đây ...')) }}
			{{ Form::submit('Submit', array('name' => 'ok', 'class' => 'submit', 'value' => 'Đăng ký bản tin')) }}
		{{ Form::close() }}
		<p>{{ @$error_messages['email'][0] }}</p>

<!--		<div class="social-media-arrow"></div>

		<footer>
			<ul>
				<li><a class="digg" href=""></a></li>
				<li><a class="twitter" href=""></a></li>
				<li><a class="vimeo" href=""></a></li>
				<li><a class="skype" href=""></a></li>
			</ul>
		</footer>-->
	</div>
	<!-- jQuery and Modernizr-->
	<script type='text/javascript' src='{{ asset('/public/libraries/jquery/jquery-2.0.3.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/countdown/modernizr.custom.js') }}'></script>

	<!-- Countdown timer and other animations -->
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/countdown/jquery.countdown.js') }}'></script>
	<script type="text/javascript">
	$(document).ready(function(){
		var timestamp = (new Date()).getTime() + 51*24*60*60*1000;

		/* ---- Countdown timer ---- */

		$('#counter').countdown({
			timestamp : timestamp
		});
		/* ---- Animations ---- */

		$('#links a').hover(
			function(){ $(this).animate({ left: 3 }, 'fast'); },
			function(){ $(this).animate({ left: 0 }, 'fast'); }
		);

		$('footer a').hover(
			function(){ $(this).animate({ top: 3 }, 'fast'); },
			function(){ $(this).animate({ top: 0 }, 'fast'); }
		);


		/* ---- Using Modernizr to check if the "required" and "placeholder" attributes are supported ---- */
		if (!Modernizr.input.placeholder) {
			$('.email').val('Nhập địa chỉ email vào đây ...');
			$('.email').focus(function() {
				if($(this).val() == 'Nhập địa chỉ email vào đây ...') {
					$(this).val('');
				}
			});
		}

		// for detecting if the browser is Safari
		var browser = navigator.userAgent.toLowerCase();

		if(!Modernizr.input.required || (browser.indexOf("safari") != -1 && browser.indexOf("chrome") == -1)) {
			$('form').submit(function() {
				$('.popup').remove();
				if(!$('.email').val() || $('.email').val() == 'Nhập địa chỉ email vào đây ...') {
					$('form').append('<p class="popup">Bạn phải điền email vào!</p>');
					$('.email').focus();
					return false;
				}
			});
			$('.email').keydown(function() {
				$('.popup').remove();
			});
			$('.email').blur(function() {
				$('.popup').remove();
			});
		}
	});
	</script>
</body>

</html>
