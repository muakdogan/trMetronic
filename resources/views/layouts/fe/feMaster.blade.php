<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TamRekabet - Al Kazan, Sat Kazan</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap-->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Google fonts - Open Sans-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800,400italic">
    <!-- Stroke 7 font by Pixeden (http://www.pixeden.com/icon-fonts/stroke-7-icon-font-set)-->
    <link rel="stylesheet" href="{{asset('css_fe/pe-icon-7-stroke.css')}}">
    <link rel="stylesheet" href="{{asset('css_fe/helper.css')}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('css_fe/style3.css')}}" id="theme-stylesheet">
    <!-- owl carousel-->
    <link rel="stylesheet" href="{{asset('css_fe/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('css_fe/owl.theme.css')}}">
    <!-- plugins-->
    <link rel="stylesheet" href="{{asset('css_fe/simpletextrotator.css')}}">
    <!--iç sayfalardan head bölümüne ekleme yapmak için-->
    @yield('head')
    <!-- Favicon-->
    <link rel="shortcut icon" href="favicon.png">

  </head>
  <body data-spy="scroll" data-target="#navigation" data-offset="120">
    <div id="all">
      @yield('content')
    </div>
    <!-- Javascript files-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"> </script>
    <script src="{{asset('js_fe/jquery.cookie.js')}}"> </script>
    <script src="{{asset('js_fe/ekko-lightbox.js')}}"></script>
    <script src="{{asset('js_fe/jquery.simple-text-rotator.min.js')}}"></script>
    <script src="{{asset('js_fe/jquery.scrollTo.min.js')}}"></script>
    <script src="{{asset('js_fe/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js_fe/front.js')}}"></script>


    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
    <!--script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script-->
  </body>
</html>
