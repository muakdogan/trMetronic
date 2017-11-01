@extends('layouts.appUser')
@section('baslik') Kontrol Panel @endsection
@section('aciklama')  @endsection
@section('head')
    <link href="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="col-md-9">
                @if(count($davetEdilIlanlar) != 0)
                    <!-- BEGIN DAVET EDILDIGIM ILANLAR -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-envelope-open theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Son 5 Davet Edildiğim İlan</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table data-toggle="table" data-sort-name="tarih" data-sort-order="asc" class="table-striped" >
                                <thead>
                                <tr>
                                    <th data-align="center" data-sortable="true">Firma Adı</th>
                                    <th data-align="center" data-field="tarih" data-sortable="true">İlan Adı</th>
                                    <th data-align="center" data-sortable="true">Kapanma Tarihi</th>
                                    <th data-align="center">Başvur</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($davetEdilIlanlar as $dvtIlan)
                                    <tr>
                                        <td><a href="{{URL::to('firmaDetay', array($dvtIlan->firma_id), false)}}">{{$dvtIlan->firma_adi}}</a></td>
                                        <td><a href="{{URL::to('teklifGor', array($dvtIlan->firma_id,$dvtIlan->ilan_id), false)}}">{{$dvtIlan->ilan_adi}}</a></td>
                                        <td>{{date("d-m-Y", strtotime($dvtIlan->ilan_kapanma_tarihi))}}</td>
                                        <td>
                                            <a href="{{URL::to('teklifGor', array($dvtIlan->firma_id,$dvtIlan->ilan_id), false)}}" class="btn btn-circle bold btn-icon-only purple">
                                                <i class="icon-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <a href="{{URL::to('davetEdildigim')}}"><span style="color: purple;">Tüm Davet Edildiğim İlanları Görüntüle <i class="icon-arrow-right"></i></span></a>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- END DAVET EDILDIGIM ILANLAR -->
                    @endif
                    <!-- BEGIN SON ILANLARIM -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-paper-plane theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Son 5 İlanım</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table data-toggle="table" data-sort-name="tarih" data-sort-order="asc" class="table-striped" >
                                <thead>
                                <tr>
                                    <th data-align="center" data-field="tarih" data-sortable="true">İlan Adı</th>
                                    <th data-align="center" data-sortable="true">Başvuru Sayısı</th>
                                    <th data-align="center" data-sortable="true">Kapanma Tarihi</th>
                                    <th data-align="center">Git</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ilanlarFirma as $ilan)
                                    <tr>
                                        <td><a href="{{URL::to('teklifGor', array($firma->id,$ilan->id), false)}}">{{$ilan->adi}}</a></td>
                                        <td>{{$ilan->teklifler()->count()}}</td>
                                        <td>{{date("d-m-Y", strtotime($ilan->kapanma_tarihi))}}</td>
                                        <td>
                                            <a href="{{URL::to('teklifGor', array($firma->id,$ilan->id), false)}}" class="btn btn-circle bold btn-icon-only purple">
                                                <i class="icon-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <a href="{{URL::to('ilanlarim', array($firma->id), false)}}"><span style="color: purple;">Tüm İlanlarımı Görüntüle <i class="icon-arrow-right"></i></span></a>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- END SON ILANLARIM -->

                    <!-- BEGIN SON BASVURULARIM -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-note theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Son 5 Başvurum</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table data-toggle="table" data-sort-name="tarih" data-sort-order="asc" class="table-striped" >
                                <thead>
                                <tr>
                                    <th data-align="center" data-sortable="true">Firma Adı</th>
                                    <th data-align="center" data-field="tarih" data-sortable="true">İlan Adı</th>
                                    <th data-align="center" data-sortable="true">Başvuru Sayısı</th>
                                    <th data-align="center" data-sortable="true">Kapanma Tarihi</th>
                                    <th data-align="center">Güncelle</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teklifler as $teklif)
                                    <tr>
                                        <td><a href="{{URL::to('firmaDetay', array($teklif->ilanlar->firmalar->id), false)}}">{{$teklif->ilanlar->firmalar->adi}}</a></td>
                                        <td><a href="{{URL::to('teklifGor', array($teklif->ilanlar->firmalar->id,$teklif->ilanlar->id), false)}}">{{$teklif->ilanlar->adi}}</a></td>
                                        <td>{{$teklif->getIlanTeklifSayisi()}}</td>
                                        <td>{{date("d-m-Y", strtotime($teklif->ilanlar->kapanma_tarihi))}}</td>
                                        <td>
                                            <a href="{{URL::to('teklifGor', array($teklif->ilanlar->firmalar->id,$teklif->ilanlar->id), false)}}" class="btn btn-circle bold btn-icon-only purple">
                                                <i class="icon-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <a href="{{URL::to('basvurularim', array($firma->id), false)}}"><span style="color: purple;">Tüm Başvurularımı Görüntüle <i class="icon-arrow-right"></i></span></a>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- END SON BASVURULARIM -->
                </div>
                <div class="col-md-3">
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                        <h4 class="widget-thumb-heading">Toplam İlanım</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-red-pink icon-bar-chart"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$firma->ilanlar()->count()}}"></span>
                            </div>
                        </div>
                    </div>
                    <!-- END WIDGET THUMB -->
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                        <h4 class="widget-thumb-heading">Toplam Başvurum</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-blue icon-graph"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$tekliflerCount}}"></span>
                            </div>
                        </div>
                    </div>
                    <!-- END WIDGET THUMB -->
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                        <h4 class="widget-thumb-heading">Profil Doluluk Oranım</h4>
                        <div class="widget-thumb-wrap">
                            <div class="widget-thumb-body">
                                <div class="easy-pie-chart">
                                    <div class="number transactions" data-percent="{{$firma->doluluk_orani}}">
                                        %<span>{{$firma->doluluk_orani}}</span></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END WIDGET THUMB -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('sayfaSonu')
    <script src="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/pages/scripts/table-bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js')}}" type="text/javascript"></script>
@endsection