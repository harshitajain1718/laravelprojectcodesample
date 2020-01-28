<!DOCTYPE html>

<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

	<!-- begin::Head -->
	<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async
		src="https://www.googletagmanager.com/gtag/js?id=UA-120795261-1"></script>
		<script>
		   window.dataLayer = window.dataLayer || [];
		   function gtag(){dataLayer.push(arguments);}
		   gtag('js', new Date());

		   gtag('config', 'UA-120795261-1');
		</script>
		<meta charset="utf-8" />
		<title>Taxi School App | @yield('title')</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
		
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

		<!--end::Web font -->

		<!--begin::Global Theme Styles -->
		<link href="{{ asset('css/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="../../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900&amp;subset=latin-ext" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">

		<!--end::Global Theme Styles -->

		<!--begin::Page Vendors Styles -->
		<link href="{{ asset('css/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
		
		<link href="{{ asset('css/admin.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" type="text/css" />

		<script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/highcharts.js') }}" type="text/javascript"></script>

		<!--end::Page Vendors Styles -->
		<link rel="shortcut icon" href="{{ asset('img/fav.ico') }}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/')}}css/toastr.min.css">
		<script type="text/javascript" src="{{asset('/')}}js/toastr.min.js"></script>
	</head>

	<!-- end::Head -->

	<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			@include('user.layouts.topnavbar')

			@yield('content')

			@include('user.layouts.footer')

		</div>

		
		<!-- begin::Quick Sidebar -->

		<!-- end::Quick Sidebar -->

		<!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="fa fa-angle-up"></i>
		</div>

		<!-- end::Scroll Top -->

		<!-- begin::Quick Nav -->

		<!--begin::Global Theme Bundle -->
		<script src="{{ asset('js/vendors.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors -->
		<script src="{{ asset('js/fullcalendar.bundle.js') }}" type="text/javascript"></script>

		<!--end::Page Vendors -->

		<!--begin::Page Scripts -->
		<script src="{{ asset('js/dashboard.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>

		<!--end::Page Scripts -->

		<!--equal height js-->
		<script type="text/javascript" src="{{ asset('js/jquery.matchHeight.js') }}"></script>
		<!--end-->
	</body>

	<!-- end::Body -->
</html>