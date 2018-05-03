<?php
use Barryvdh\Debugbar\Facade as Debugbar;
Debugbar::info(session()->all());
?>

<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="tr">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>{{Session::get('firma_adi')}} Firması Ana Sayfası</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="description" name="description" />
    <script src="{{asset('MetronicFiles/global/plugins/jquery.min.js')}}" type="text/javascript"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{asset('MetronicFiles/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('MetronicFiles/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('MetronicFiles/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('MetronicFiles/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{asset('MetronicFiles/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('MetronicFiles/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('MetronicFiles/global/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('MetronicFiles/global/plugins/jqvmap/jqvmap/jqvmap.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{asset('MetronicFiles/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{asset('MetronicFiles/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{asset('MetronicFiles/layouts/layout3/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('MetronicFiles/layouts/layout3/css/themes/purple-studio.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{asset('MetronicFiles/layouts/layout3/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
    @yield('head') {{--ic sayfalardan head bolumune kod eklemek icin--}}
</head>
<!-- END HEAD -->

<body id="app-layout" class="page-container-bg-solid page-header-menu-fixed" @yield('bodyAttributes')>

<div class="page-wrapper">

    <div class="page-wrapper-row">
        <div class="page-wrapper-top">
        @include('layouts.headerUser'){{--sitenin ust kismini (header) include eder--}}
        </div>
    </div>
    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <!-- BEGIN PAGE HEAD-->
                    <div class="page-head">
                        <div class="container">
                            <!-- BEGIN PAGE TITLE -->
                            <div class="page-title">
                                <h1>@yield('baslik')
                                    <small>@yield('aciklama')</small>
                                </h1>
                            </div>
                            <!-- END PAGE TITLE -->
                        </div>
                    </div>
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="page-content">
                        <div class="container">

                            <!-- BEGIN PAGE CONTENT INNER -->
                            <div class="page-content-inner">
                                @yield('content') {{--ic sayfalardan icerik duzenlemek icin (body)--}}
                            </div>
                            <!-- END PAGE CONTENT INNER -->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT BODY -->
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->

            </div>
            <!-- END CONTAINER -->
        </div>
    </div>
    <div class="page-wrapper-row">
        <div class="page-wrapper-bottom">
            <!-- BEGIN FOOTER -->

            <!-- BEGIN INNER FOOTER -->
            <div class="page-footer">
                <div class="container"> 2018 &copy;
                    <a href="{{URL::to('/')}}"><b>tamrekabet.com</b></a> &nbsp;|&nbsp;
                </div>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
            <!-- END INNER FOOTER -->
            <!-- END FOOTER -->
        </div>
    </div>
</div>

@yield('popUps')

<!--[if lt IE 9]>
<script src="{{asset('MetronicFiles/global/plugins/respond.min.js')}}"></script>
<script src="{{asset('MetronicFiles/global/plugins/excanvas.min.js')}}"></script>
<script src="{{asset('MetronicFiles/global/plugins/ie8.fix.min.js')}}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->

<script src="{{asset('MetronicFiles/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('MetronicFiles/global/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/pages/scripts/ui-modals.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/global/plugins/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/global/plugins/morris/raphael-min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{asset('MetronicFiles/global/scripts/app.min.js')}}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('MetronicFiles/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{asset('MetronicFiles/layouts/layout3/scripts/layout.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/layouts/layout3/scripts/demo.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/layouts/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
@yield('sayfaSonu') {{--ic sayfalardan sayfa sonuna bolumune kod eklemek icin--}}
</body>
</html>
