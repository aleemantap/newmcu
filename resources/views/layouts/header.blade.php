<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title> GMeds System | @yield('title')</title>
        <meta name="description" content="">
        <meta name="author" content="NSDTI - NSS, Telkomsel">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('assets/images/icon/favicon2.png') }}" type="image/x-icon">
       
        <!-- LOAD GLOBAL CSS -->
        <link rel="stylesheet" href="{{ asset('fontawesome/css/font-awesome.min.css') }}"/>

        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/bootstrap-datepicker.css') }}">

        <!-- amchart css -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        @yield('css')

        {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/app.css') }}"> --}}
        {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/themes/theme-material.css') }}"> --}}
        {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/themes/theme-blue.css') }}"> --}}
        {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/style.css') }}"> --}}
        {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/style.css') }}"> --}}
       
        <!-- END GLOBAL CSS --> 
         <!-- others css -->
        <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/default-css.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('assets/css/styles2.css') }}">  --}}
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
      
        <link rel="stylesheet" href="{{ asset('assets/css/lobibox/css/Lobibox.min.css') }}"/>
       
        <!-- modernizr css -->
        <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>

    </head>
    {{-- <body class="body-bg smart-style-6"> --}}
    <body>
       
        <div id="preloader">
            <div class="loader"></div>
        </div>

        <div class="page-container">