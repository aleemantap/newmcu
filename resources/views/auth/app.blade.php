<!DOCTYPE html>
<html lang="en-us" id="extr-page">
    <head>
        <meta charset="utf-8">
        <title> @yield('title') | EMCU</title>
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <!-- Basic Styles -->
        <link rel="icon" href="{{ asset('assets/images/icon/favicon2.png') }}" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{  asset('assets/css/slicknav.min.css') }}">
        <!-- amchart css -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <!-- others css -->
        <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/default-css.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <!-- modernizr css -->
        <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>

        {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/bootstrap.min.css') }}"> --}}
        {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/font-awesome.min.css') }}"> --}}
        <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
        {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/smartadmin-production-plugins.min.css') }}"> --}}
        {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/smartadmin-production.min.css') }}"> --}}
        {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/smartadmin-skins.min.css') }}"> --}}
        {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/login.css') }}"> --}}
        @yield('css')
        
        <!-- #FAVICONS -->
        {{-- <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon"> --}}
        {{-- <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon"> --}}
        
        <!-- #GOOGLE FONT -->
        {{-- <link rel="stylesheet" href="{{ asset('css/css_google.css') }}"> --}}
        
        {{-- <style>
            #extr-page {
                background: url({{asset('img/front.jpg')}});
                background-size: cover !important;
            }
            body.smart-style-6 {
                background: none;
            }
            #main {
                background: none !important;
            }
            #content {
                background: none !important;
            }
            
        </style> --}}
        <script>
            baseUrl = '{{ url("/") }}';
        </script>
    </head>
    <body>
        <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->
        <!-- preloader area start -->
        <div id="preloader">
            <div class="loader"></div>
        </div>
        @yield('content')


        <!-- jquery latest version -->
        <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
        <!-- bootstrap 4 js -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/metisMenu.min.js"></script>
        <script src="assets/js/jquery.slimscroll.min.js"></script>
        <script src="assets/js/jquery.slicknav.min.js"></script>
        
        <!-- others plugins -->
        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/scripts.js"></script>

        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
        {{-- <script src="{{ asset('js/plugin/pace/pace.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('js/libs/jquery-3.2.1.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('js/plugin/pace/jquery-ui.min.js') }}"></script> --}}

        <!-- IMPORTANT: APP CONFIG -->
        {{-- <script src="{{ asset('js/app.config.js') }}"></script> --}}

        <!-- BOOTSTRAP JS -->		
        {{-- <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script> --}}

        <!-- JQUERY VALIDATE -->
        {{-- <script src="{{ asset('js/plugin/jquery-validate/jquery.validate.min.js') }}"></script> --}}

        <!-- MAIN APP JS FILE -->
        {{-- <script src="{{ asset('js/app.min.js') }}"></script> --}}

        @yield('script')
    </body>
</html>