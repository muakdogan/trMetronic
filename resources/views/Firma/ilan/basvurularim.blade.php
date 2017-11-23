@extends('layouts.appUser')

@section('baslik') Başvurularım
@endsection

@section('aciklama')
@endsection

@section('head')
    <link href="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-note theme-font"></i>
                        <span class="caption-subject theme-font bold uppercase">Başvurularım &nbsp;({{$basvurular_count}} İlan)</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table id="table-pagination" data-toggle="table" data-pagination="true" data-search="true" class="table table-light">
                        <thead>
                        <tr>
                            <th data-field="ilan" data-align="center" data-sortable="true">İlan Adı</th>
                            <th data-field="firma" data-align="center" data-sortable="true">Firma Adı</th>
                            <th data-field="tarih" data-align="center" data-sortable="true">Başvuru Tarihi</th>
                            <th data-field="price" data-align="center">Görüntüle</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($basvurular as $sonuc)
                            <?php $ilan= App\Ilan::find($sonuc->ilanId); ?>
                            <tr>
                                <td><a href="{{URL::to('teklifGor', array($ilan->firmalar->id,$ilan->id), false)}}" class="btn">{{$ilan->adi}}</a></td>
                                <td><a href="{{URL::to('firmaDetay', array($ilan->firmalar->id), false)}}" class="btn">{{$ilan->firmalar->adi}}</a></td>
                                <td>{{date('d-m-Y', strtotime($sonuc->tarih))}}</td>
                                <td>
                                    <a href="{{URL::to('teklifGor', array($ilan->firmalar->id,$ilan->id), false)}}" class="btn btn-circle bold btn-icon-only purple">
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-trophy theme-font"></i>
                        <span class="caption-subject theme-font bold uppercase">Kazandığım Başvurular &nbsp;({{$kazananKismiCount}} İlan)</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table id="table-pagination" data-toggle="table" data-pagination="true" data-search="true" class="table table-light">
                        <thead>
                        <tr>
                            <th data-field="ilan" data-align="center" data-sortable="true">İlan Adı</th>
                            <th data-field="firma" data-align="center" data-sortable="true">Firma Adı</th>
                            <th data-field="tarih" data-align="center" data-sortable="true">Sonuclanma Tarihi</th>
                            <th data-field="fiyat" data-align="center" data-sortable="true">Kazanılan Fiyat</th>
                            <th data-field="price" data-align="center">Görüntüle</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($kazananKismi as $sonucAcik)
                            <?php  $ilan= App\Ilan::find($sonucAcik->ilan_id); ?>
                            <tr>
                                <td><a href="{{URL::to('teklifGor', array($sonucAcik->ilanlar->firmalar->id,$sonucAcik->ilanlar->id), false)}}" class="btn">{{$sonucAcik->ilanlar->adi}}</a></td>
                                <td><a href="{{URL::to('firmaDetay', array($sonucAcik->ilanlar->firmalar->id), false)}}" class="btn">{{$sonucAcik->ilanlar->firmalar->adi}}</a></td>
                                <td>{{date('d-m-Y', strtotime($sonucAcik->sonuclanma_tarihi))}}</td>
                                <td><strong> {{number_format($sonucAcik->kazanan_fiyat,2,'.','')}}</strong> &#8378;</td>
                                <td>
                                    <a href="{{URL::to('teklifGor', array($sonucAcik->ilanlar->firmalar->id,$sonucAcik->ilanlar->id), false)}}" class="btn btn-circle bold btn-icon-only purple">
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @foreach($kazananKapali as $sonucKapali)
                            <?php $ilan= App\Ilan::find($sonucKapali->ilan_id); ?>
                            <tr>
                                <td><a href="{{URL::to('teklifGor', array($sonucKapali->ilanlar->firmalar->id,$sonucKapali->ilanlar->id), false)}}" class="btn">{{$sonucKapali->ilanlar->adi}}</a></td>
                                <td><a href="{{URL::to('firmaDetay', array($sonucKapali->ilanlar->firmalar->id), false)}}" class="btn">{{$sonucKapali->ilanlar->firmalar->adi}}</a></td>
                                <td>{{$sonucKapali->sonuclanma_tarihi}}</td>
                                <td><strong> {{number_format($sonucKapali->kazanan_fiyat,2,'.','')}}</strong> &#8378;</td>
                                <td>
                                    <a href="{{URL::to('teklifGor', array($sonucKapali->ilanlar->firmalar->id,$sonucKapali->ilanlar->id), false)}}" class="btn btn-circle bold btn-icon-only purple">
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
    </div>
        </div>
        <div class="col-md-3">
            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                <h4 class="widget-thumb-heading">Toplam Başvurum</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red-pink icon-note"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$basvurular_count}}">{{$basvurular_count}}</span>
                    </div>
                </div>
            </div>
            <!-- END WIDGET THUMB -->
            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                <h4 class="widget-thumb-heading">Toplam Kazanılan Başvuru</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-blue icon-trophy"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$kazananKismiCount}}">{{$kazananKismiCount}}</span>
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
    <script src="{{asset('MetronicFiles/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
@endsection