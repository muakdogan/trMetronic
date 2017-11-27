@extends('layouts.appUser')

@section('baslik') Davet Edildiğim İlanlar @endsection

@section('aciklama') @endsection

@section('head')
    <link href="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">

            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="col-md-12">
                @if(count($davetEdilIlanlar) != 0)
                    <!-- BEGIN DAVET EDILDIGIM ILANLAR -->
                        <div class="portlet light ">
                            <div class="portlet-body">
                                <table data-toggle="table" data-sort-name="tarih" data-sort-order="asc" class="table-striped" >
                                    <thead>
                                    <tr>
                                        <th data-align="center" data-field="tarih" data-sortable="true">İlan Adı</th>
                                        <th data-align="center" data-sortable="true">Firma Adı</th>
                                        <th data-align="center" data-sortable="true">Kapanma Tarihi</th>
                                        <th data-align="center">Başvur</th>
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
            </div>
        </div>

@endsection

@section('sayfaSonu')
    <script src="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/pages/scripts/table-bootstrap.min.js')}}" type="text/javascript"></script>
@endsection