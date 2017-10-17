@extends('layouts.appUser')
@section('baslik') İlan Düzenle @endsection
@section('aciklama') @endsection
<?php use Barryvdh\Debugbar\Facade as Debugbar;
Debugbar::info($ilan);
?>

@section('head')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{asset('css/multi-select.css')}}" media="screen" rel="stylesheet" type="text/css"></link>
    <link href="{{asset('css/skin-bootstrap/ui.fancytree.css')}}" rel="stylesheet" class="skinswitcher">

    <!--kalem agacı -->
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="//cdn.jsdelivr.net/jquery.ui-contextmenu/1/jquery.ui-contextmenu.min.js"></script>
    <script src="{{asset('js/jquery.fancytree.js')}}"></script>
    <script src="{{asset('js/jquery.fancytree.glyph.js')}}"></script>
    <script src="{{asset('js/jquery.fancytree.dnd.js')}}"></script>
    <script src="{{asset('js/jquery.fancytree.edit.js')}}"></script>
    <script src="{{asset('js/jquery.fancytree.filter.js')}}"></script>
    <script src="{{asset('js/jquery.fancytree.table.js')}}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="//cdn.ckeditor.com/4.5.10/basic/ckeditor.js"></script>

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {

            text-align: center;
            padding: 5px;
        }
        .test + .tooltip > .tooltip-inner {
            background-color: #73AD21;
            color: #FFFFFF;
            border: 1px solid green;
            padding: 10px;
            font-size: 12px;
        }
        .test + .tooltip.bottom > .tooltip-arrow {
            border-bottom: 5px solid green;
        }

        /*custom font*/


        #msform {
            width: 100%;


            position: relative;
        }
        #msform fieldset {

        }
        /*Hide all except first fieldset*/
        #msform fieldset:not(:first-of-type) {
            display: none;
        }

        /*buttons*/
        .action-button {
            width: 100px;
            background: #27AE60;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 1px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
        }
        .action-button:hover, #msform .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;
        }
        /*headings*/
        .fs-title {
            font-size: 15px;
            text-transform: uppercase;
            color: #2C3E50;
            margin-bottom: 10px;
        }
        .eula-container {
            padding: 15px 20px;
            height: 250px;
            overflow: auto;
            border: 2px solid #ebebeb;
            color: #7B7B7B;
            font-size: 12pt;
            font-weight: 700;
            background-color: #fff;
            background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJod…EiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
            background-image: -webkit-linear-gradient(top, rgba(231,231,231,0.55) 0%, rgba(255,255,255,0.63) 17%, #feffff 100%);
            background-image: linear-gradient(to bottom, rgba(231,231,231,0.55) 0%, rgba(255,255,255,0.63) 17%, #feffff 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8ce7e7e7', endColorstr='#feffff',GradientType=0 );
            background-clip: border-box;
            border-radius: 4px;
        }
        .info-box {
            margin: 0 0 15px;
        }
        .box h3{
            text-align:center;
            position:relative;
            top:80px;
        }

    </style>

@endsection

{{--Teklif yoksa ilan düzenlenebilir!--}}
@if(!$teklifVarMi)

@section('content')
    <style>
    .ajax-loader {
    visibility: hidden;
    background-color: rgba(255,255,255,0.7);
    position: absolute;
    z-index: +100 !important;
    width: 100%;
    height:100%;
    }

    .ajax-loader img {
    position: relative;
    top:50%;
    left:32%;
    }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
    <script src="{{asset('js/jquery.multi-select.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('js/jquery.quicksearch.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/additional-methods.js')}}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <link rel="stylesheet" type="text/css" href="{{asset('css/aciklama-tooltip.css')}}" />

<div class="container">

    @include('Firma.ilanDuzenle.ilanDuzenleM')

</div>

<script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>
<script src="{{asset('js/jquery.bpopup-0.11.0.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
@endsection


@section('sayfaSonu')
    <script src="{{asset('MetronicFiles/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/pages/scripts/form-wizard.min.js')}}" type="text/javascript"></script>
@endsection


@else
    {{--Teklif varsa ilan düzenleneMEZ!--}}

@section('content')

    <div class="container">
        <br>
        <br>
        @include('layouts.alt_menu')
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12" >
                <div class="box effect8">
                    <h3>Teklif verilmiş ilanda düzenleme yapılamaz!</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
@endif
