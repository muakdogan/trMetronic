@extends('layouts.appUser')
@section('baslik') Onaylı Tedarikçilerim @endsection
@section('head')
    <link href="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
        <div class="col-md-9">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-star theme-font"></i>
                        <span class="caption-subject theme-font bold uppercase">Onaylı Tedarikçilerim</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table id="table-pagination" data-toggle="table" data-pagination="true" data-search="true" class="table table-light">
                        <thead>
                        <tr>
                            <th data-field="firma" data-align="center" data-sortable="true">Firma Adı</th>
                            <th data-field="logo" data-align="center" data-sortable="true">Logo</th>
                            <th data-field="sehir" data-align="center" data-sortable="true">Sehir</th>
                            <th data-field="sektorler" data-align="center">Sektörler</th>
                            <th data-field="ekleCikar" data-align="center">Ekle/Cikar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($onayli_tedarikciler as $onayliFirma)
                            <tr class="active">
                                <td>{{$onayliFirma->adi}}</td>
                                <td><img src="{{asset('uploads')}}/{{$onayliFirma->logo}}" alt="Firma Logo" width="100" height="100"></td>
                                <td>{{$onayliFirma->adresler[0]->iller->adi}}</td>
                                <td><ul type="circle">@foreach($onayliFirma->sektorler as $sektor) <li>{{$sektor->adi}} </li> @endforeach </ul></td>
                                <td>
                                    <button type="button" class="btn btn-info btn-tedCikar" value="{{$onayliFirma->id}}">Tedarikçilerimden Çıkar</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 " align="center">
                <a href="{{asset('firmaHavuzu/')}}" class="btn btn-circle purple">Firma Havuzu <i class="icon-globe"></i></a>
            </div>

            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                <h4 class="widget-thumb-heading">Toplam Onaylı Tedarikçim</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red-pink icon-star"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{count($onayli_tedarikciler)}}">{{count($onayli_tedarikciler)}}</span>
                    </div>
                </div>
            </div>
            <!-- END WIDGET THUMB -->
        </div>
    </div>

<script>
$(document).on('click', '.btn-tedCikar', function(){
    var tedarikci_id=$(this).val();
    $.ajax({
        type:"GET",
        url:"{{asset('onayliTedarikciCikar')}}",
        data:{tedarikci_id:tedarikci_id},
        cache: false,
        success: function(data){
            window.location.reload();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus); alert("Error: " + errorThrown);
        }
    });
});
</script>
@endsection

@section('sayfaSonu')
    <script src="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/pages/scripts/table-bootstrap.min.js')}}" type="text/javascript"></script>
@endsection