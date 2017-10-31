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
                                <i class="fa fa-pencil theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Davet Edildiğim İlanlar</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table data-toggle="table" data-sort-name="name" data-sort-order="asc" class="table-striped" >
                                <thead>
                                <tr>
                                    <th data-align="center" data-sortable="true">Firma Adı</th>
                                    <th data-align="center" data-field="name" data-sortable="true">İlan Adı</th>
                                    <th data-align="center" data-sortable="true">Başvuru Sayısı</th>
                                    <th data-align="center" data-sortable="true">Kapanma Tarihi</th>
                                    <th data-align="center">Başvur</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($davetEdilIlanlar as $dvtIlan)
                                    <tr>
                                        <td><a href="javascript:;">firma adı</a></td>
                                        <td><a href="{{ URL::to('teklifGor', array($firma->id,$dvtIlan->id), false) }}">{{$dvtIlan->ilanlar->adi}}</a></td>
                                        <td>{{$dvtIlan->ilanlar->teklifler()->count()}}</td>
                                        <td>kapanma</td>
                                        <td>
                                            <a href="{{ URL::to('teklifGor', array($firma->id,$dvtIlan->id), false) }}" class="btn btn-circle bold btn-icon-only purple">
                                                <i class="icon-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
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
                                <i class="fa fa-pencil theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Son İlanlarım</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-light">
                                <tr>
                                    <th>İlan İsmi</th>
                                    <th>Başvuru Sayısı</th>
                                    <th></th>
                                </tr>
                                @foreach($ilanlarFirma as $ilan)
                                    <tr>
                                        <td>{{$ilan->adi}}</td>
                                        <td>{{$ilan->teklifler()->count()}}</td>
                                        @if($ilan->yayinlanma_tarihi > time())
                                            <td><a href="{{ URL::to('firmaIlanOlustur', array($firma->id,$ilan->id), false) }}"><button class="btn">Düzenle</button></a></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                            </div>
                        </div>
                    </div>
                    <!-- END SON ILANLARIM -->

                    <!-- BEGIN SON BASVURULARIM -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="fa fa-pencil theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Son Başvurularım</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-light">
                                    <tr>
                                        <th>Başvuru İlan İsmi</th>
                                        <th>Başvuru Sayısı</th>
                                        <th></th>
                                    </tr>
                                    @foreach($teklifler as $teklif)
                                        <tr>
                                            <td>{{$teklif->ilanlar->adi}}</td>
                                            <td>{{$teklif->getIlanTeklifSayisi()}}</td>
                                            <td><button class="btn">Düzenle</button></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END SON BASVURULARIM -->

                    <!-- BEGIN DENEME -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="fa fa-pencil theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">DENEME</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table data-toggle="table" data-sort-name="name" data-sort-order="asc">
                                <thead>
                                <tr>
                                    <th data-align="right" data-sortable="true">Firma Adı</th>
                                    <th data-align="center" data-field="name" data-sortable="true">İlan Adı</th>
                                    <th data-align="right" data-sortable="true">Başvuru Sayısı</th>
                                    <th data-align="center" data-sortable="true">Kapanma Tarihi</th>
                                    <th data-align="center">Başvur</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>a</td>
                                    <td>b</td>
                                    <td>c</td>
                                    <td>b</td>
                                    <td><a href="javascript:;" class="btn btn-circle bold btn-icon-only purple">
                                            <i class="icon-arrow-right"></i>
                                        </a></td>
                                </tr>
                                <tr>
                                    <td>d</td>
                                    <td>e</td>
                                    <td>f</td>
                                    <td>b</td>
                                    <td><i class="icon-arrow-right theme-font"></i></td>
                                </tr>
                                <tr>
                                    <td>d</td>
                                    <td>e</td>
                                    <td>f</td>
                                    <td>b</td>
                                    <td><i class="icon-arrow-right theme-font"></i></td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        deneme
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- END DENEME -->
                </div>
                <div class="col-md-3">
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                        <h4 class="widget-thumb-heading">Toplam İlan Sayım</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple icon-bulb"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="10">{{$firma->ilanlar()->count()}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- END WIDGET THUMB -->
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                        <h4 class="widget-thumb-heading">Toplam Başvuru Sayım</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple icon-bulb"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="7,644">{{$tekliflerCount}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- END WIDGET THUMB -->
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                        <h4 class="widget-thumb-heading">Profil Doluluk Oranı</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple icon-bulb"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="7,644">%{{$firma->doluluk_orani}}</span>
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
@endsection