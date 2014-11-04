<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $title }}</title>
	<meta name="description" content="Description">
	<meta name="author" content="Hà Phan Minh">
	<link rel='stylesheet' href='{{ asset('/public/styles/reset.css') }}' type='text/css' />
	<link rel='stylesheet' href='{{ asset('/public/libraries/bootstrap/css/bootstrap.min.css') }}' type='text/css' />
	<link rel='stylesheet' href='{{ asset('/public/libraries/bootstrap-plugin/datetimepicker/bootstrap-datetimepicker.min.css') }}' type='text/css' />
	<link rel='stylesheet' href='{{ asset('/public/styles/frontend/plugin/SlidePushMenus/component.css') }}' type='text/css' />
	<link rel='stylesheet' href='{{ asset('/public/styles/frontend/plugin/menu/styles.css') }}' type='text/css' />
	<link rel='stylesheet' href='{{ asset('/public/scripts/plugins/mCustomScrollbar/jquery.mCustomScrollbar.css') }}' type='text/css' />
	<link rel='stylesheet' href='{{ asset('/public/scripts/plugins/select2/select2.css') }}' type='text/css' />
	<link rel='stylesheet' href='{{ asset('/public/scripts/plugins/select2/select2-bootstrap.css') }}' type='text/css' />
	<link rel='stylesheet' href='{{ asset('/public/scripts/plugins/owl/owl.carousel.css') }}' type='text/css' />
	<link rel='stylesheet' href='{{ asset('/public/scripts/plugins/owl/owl.theme.css') }}' type='text/css' />
	<link rel='stylesheet' href='{{ asset('/public/styles/frontend/style.css') }}' type='text/css' />
	<script type='text/javascript' src='{{ asset('/public/libraries/jquery/jquery-2.0.3.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/libraries/jquery/modernizr.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/packages/frenzy/turbolinks/jquery.turbolinks.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/packages/frenzy/turbolinks/turbolinks.js') }}'></script>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	<script>
//		var ready;
//		ready = function() {
//			(function(d, s, id) {
//				var js, fjs = d.getElementsByTagName(s)[0];
//				if (d.getElementById(id)) return;
//				js = d.createElement(s); js.id = id;
//				js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=188992151303754&version=v2.0";
//				fjs.parentNode.insertBefore(js, fjs);
//			}(document, 'script', 'facebook-jssdk'));
//		};
//		
//		$(document).on('page:load', ready);

		var bindFacebookEvents, fb_events_bound, fb_root, initializeFacebookSDK, loadFacebookSDK, restoreFacebookRoot, saveFacebookRoot;

		fb_root = null;

		fb_events_bound = false;

		$(function() {
			loadFacebookSDK();
			if (!fb_events_bound) {
				return bindFacebookEvents();
			}
		});

		bindFacebookEvents = function() {
			$(document).on('page:fetch', saveFacebookRoot).on('page:change', restoreFacebookRoot).on('page:load', function() {
				return typeof FB !== "undefined" && FB !== null ? FB.XFBML.parse() : void 0;
			});
			return fb_events_bound = true;
		};

		saveFacebookRoot = function() {
			return fb_root = $('#fb-root').detach();
		};

		restoreFacebookRoot = function() {
			if ($('#fb-root').length > 0) {
				return $('#fb-root').replaceWith(fb_root);
			} else {
				return $('body').append(fb_root);
			}
		};

		loadFacebookSDK = function() {
			window.fbAsyncInit = initializeFacebookSDK;
			return $.getScript("//connect.facebook.net/en_US/all.js#xfbml=1");
		};

		initializeFacebookSDK = function() {
			return FB.init({
				appId: '188992151303754',
				channelUrl: '//WWW.YOUR_DOMAIN.COM/channel.html',
				status: true,
				cookie: true,
				xfbml: true
			});
		};
		
		this.GoogleAnalytics = (function() {
			function GoogleAnalytics() {}

			GoogleAnalytics.load = function() {
				var firstScript, ga;
				window._gaq = [];
				window._gaq.push(["_setAccount", GoogleAnalytics.analyticsId()]);
				ga = document.createElement("script");
				ga.type = "text/javascript";
				ga.async = true;
				ga.src = ("https:" === document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
				firstScript = document.getElementsByTagName("script")[0];
				firstScript.parentNode.insertBefore(ga, firstScript);
				if (typeof Turbolinks !== 'undefined' && Turbolinks.supported) {
					return document.addEventListener("page:change", (function() {
						return GoogleAnalytics.trackPageview();
					}), true);
				} else {
					return GoogleAnalytics.trackPageview();
				}
			};

			GoogleAnalytics.trackPageview = function(url) {
				if (!GoogleAnalytics.isLocalRequest()) {
					if (url) {
						window._gaq.push(["_trackPageview", url]);
					} else {
						window._gaq.push(["_trackPageview"]);
					}
					return window._gaq.push(["_trackPageLoadTime"]);
				}
			};

			GoogleAnalytics.isLocalRequest = function() {
				return GoogleAnalytics.documentDomainIncludes("local");
			};

			GoogleAnalytics.documentDomainIncludes = function(str) {
				return document.domain.indexOf(str) !== -1;
			};

			GoogleAnalytics.analyticsId = function() {};

			return GoogleAnalytics;

		})();

		GoogleAnalytics.load();

	</script>
</head>
<body class="cbp-spmenu-push">
	<div id="fb-root"></div>
	
	<header>
		@include('frontend::partials.header')
	</header>
	<!-- Left Menu -->
	@include('frontend::partials.navbar')
	<!-- /Left Menu -->
	
	<!-- Right Menu -->
	@yield('menuRight')
	<!-- /Right Menu -->
	<section class="container-fluid">
		@yield('content')
	</section>
	@include('frontend::partials.file-modal-video')
	<footer class="footer">
		@include('frontend::partials.footer')
	</footer>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/number/jquery.number.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/classie.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/detectmobilebrowser.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/moment.min.js') }}'></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/pace/pace.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/libraries/bootstrap/js/bootstrap.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/libraries/bootstrap-plugin/datetimepicker/bootstrap-datetimepicker.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/libraries/bootstrap-plugin/datetimepicker/bootstrap-datetimepicker.vn.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/libraries/bootstrap-plugin/boot-box/bootbox.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/libraries/bootstrap-plugin/growl/jquery.bootstrap-growl.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/validate/jquery.validate.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/additional-methods.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/select2/select2.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/jwplayer/jwplayer.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/lazyload/jquery.lazyload.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/owl/owl.carousel.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/mixitup/jquery.mixitup.min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/hoverdir/jquery.hoverdir.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/allofthelights/jquery.allofthelights-min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/scrolltofixed/jquery-scrolltofixed-min.js') }}'></script>
	<script type='text/javascript' src='{{ asset('/public/scripts/plugins/readmore/readmore.min.js') }}'></script>
	<script type="text/javascript">
		var $app = {
			'module': "{{ $currentMvc['module'] }}",
			'controller': "{{ $currentMvc['controller'] }}",
			'action': "{{ $currentMvc['action'] }}"
		};
		var base_url = "{{ Config::get('app.url') }}";
	</script>
	<script type="text/javascript" data-main="{{ asset('/public/libraries/frontend/main-backbone') }}" src="{{ asset('/public/libraries/require.js?v=' . time()) }}"></script>
</body>
</html>