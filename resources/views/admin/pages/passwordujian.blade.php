@extends('layouts.layoutadminv3')

@section('title','Pengaturan')
@section('halaman')
<div class="breadcrumb-item"> Settings</div>
@endsection

@section('csshere')
@endsection

@section('jshere')
@endsection
@section('notif')


@if (session('tipe'))
        @php
        $tipe=session('tipe');
        @endphp
@else
        @php
            $tipe='light';
        @endphp
@endif

@if (session('icon'))
        @php
        $icon=session('icon');
        @endphp
@else
        @php
            $icon='far fa-lightbulb';
        @endphp
@endif

@if (session('status'))

  <div class="alert alert-{{ $tipe }} alert-has-icon alert-dismissible show fade">
    <div class="alert-icon"><i class="{{ $icon }}"></i></div>
                      <div class="alert-body">
                        <div class="alert-title">{{ Str::ucfirst($tipe) }}</div>
                        <button class="close" data-dismiss="alert">
                          <span>&times;</span>
                        </button>
                        {{ session('status') }}
                      </div>
                    </div>
@endif
@endsection

@php
$tipeuser=(Auth::user()->tipeuser);
@endphp

@section('container')



  <div class="section-body">


    <div class="row mt-sm-0">


      <div class="col-6 col-md-6 col-lg-6">

        @if($tipeuser!=='siswa')

        <div class="card">



          <div class="card-body ml-3">




              <form action="{{ route('passwordujian.generate') }}" method="post" class="d-inline ml-5">
                @csrf

                <div class="row">

                            <div class="form-group col-md-6 col-6 mt-0 ml-5">
                        <label for="jml"> Digit Username dan Password</label>
                        <input type="text" name="jml" value="6" class="form-control " max="25" min="2">

                    </div>

                </div>
            <div class="card-footer text-right">
                 <button class="btn btn-danger "
                onclick="return  confirm('Anda yakin melakukan generate Password Ujian? Y/N')"  data-toggle="tooltip" data-placement="top" title="Untuk mengembalikan pengaturan website ke pengaturan default! Data Informasi aplikasi dan sekolah juga direset.">
                <i class="fas fa-tools"></i> Generate Password Ujian!</button>

              </div>
              </form>







        @endif




    </div>


@endsection

@section('container-modals')

@endsection
