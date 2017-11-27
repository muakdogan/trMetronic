@extends('layouts.appUser')

@section('baslik') Davet Edildiğim İlanlar @endsection

@section('aciklama') @endsection

@section('head')
    <link href="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-md-9">
        @if(count($davetEdilIlanlar) != 0)
            <!-- BEGIN DAVET EDILDIGIM ILANLAR -->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-call-in theme-font"></i>
                            <span class="caption-subject theme-font bold uppercase">Davet Edildiğim İlanlar</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table id="table-pagination" data-toggle="table" data-pagination="true" data-search="true" class="table table-light table-striped">
                            <thead>
                            <tr>
                                <th data-field="ilan" data-align="center" data-field="tarih" data-sortable="true">İlan Adı</th>
                                <th data-field="firma" data-align="center" data-sortable="true">Firma Adı</th>
                                <th data-field="kapanma" data-align="center" data-sortable="true">Kapanma Tarihi</th>
                                <th data-field="basvur" data-align="center">Başvur</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($davetEdilIlanlar as $dvtIlan)
                                <tr>
                                    <td><a class="btn" href="{{URL::to('teklifGor', array($dvtIlan->firma_id,$dvtIlan->ilan_id), false)}}">{{$dvtIlan->ilan_adi}}</a></td>
                                    <td><a class="btn" href="{{URL::to('firmaDetay', array($dvtIlan->firma_id), false)}}">{{$dvtIlan->firma_adi}}</a></td>
                                    <td>{{date("d-m-Y", strtotime($dvtIlan->ilan_kapanma_tarihi))}}</td>
                                    <td>
                                        <a href="{{URL::to('teklifGor', array($dvtIlan->firma_id,$dvtIlan->ilan_id), false)}}" class="btn btn-circle bold btn-icon-only purple">
                                            <i class="icon-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END DAVET EDILDIGIM ILANLAR -->
        @endif
        </div>

        <div class="col-md-3">
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 " align="center">
                <a href="{{asset('ilanAra/')}}" class="btn btn-circle purple">İlan Ara <i class="icon-magnifier"></i></a>
            </div>

            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                <h4 class="widget-thumb-heading">Toplam Davet Edildiğim İlan</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red-pink icon-star"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{count($davetEdilIlanlar)}}">{{count($davetEdilIlanlar)}}</span>
                    </div>
                </div>
            </div>
            <!-- END WIDGET THUMB -->
        </div>
    </div>
@endsection

@section('sayfaSonu')
    <script src="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/pages/scripts/table-bootstrap.min.js')}}" type="text/javascript"></script>
@endsection