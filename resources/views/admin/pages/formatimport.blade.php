@extends('layouts.layoutadmin1')

@section('title','Beranda')
@section('halaman','Index')

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

@if(($tipeuser)==='kepsek')
  @php
      $hakakses='Kepala Sekolah';
  @endphp
@elseif(($tipeuser)==='admin')
@php
    $hakakses='Administrator';
@endphp
@elseif(($tipeuser)==='siswa')
@php
    $hakakses='Siswa';
@endphp
@endif



@section('container')




  <div class="section-body">
    <h2 class="section-title">Hi, {{ Auth::user()->name }}  ! Berikut beberapa format untuk melakukan import tiap menu di Sistem Ini.</h2>
    {{-- <p class="section-lead">
     
    </p> --}}

    <div class="row mt-sm-4">

    @if($tipeuser==='admin')
    <div class="col-12 col-md-12 col-lg-6">

        <div class="card profile-widget mt-5">
            <div class="profile-widget-header">
              <img alt="image" src="https://ui-avatars.com/api/?name=Menu Mastering&color=FFEDDA&background=3DB2FF" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">
                <h3 class="ml-5 mt-4">Format Import Menu Mastering</h3>
              </div>
               
                
                <div class="card-body">
                  {{-- <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                    <a  href="{{ route('kategori') }}" type="button" class="btn btn-warning"><i class="fab fa-korvue"></i> Kategori</a>
                  </div> --}}
                  {{-- <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                    <a  href="{{ route('tapel') }}" type="button" class="btn btn-primary"><i class="fas fa-calendar-alt"></i> Tahun Pelajaran</a>
                    <a  href="{{ route('kelas') }}" type="button" class="btn btn-primary"><i class="fas fa-school"></i> Kelas</a>   
                  </div> --}}
                    <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                    <a  href="{{ url('assets/formatimport/sim-siswa.xlsx') }}"  target="_blank" type="button" class="btn btn-info"><i class="fas fa-user-graduate"></i> Siswa</a>
                    <a  href="{{ url('assets/formatimport/sim-pegawai.xlsx') }}"  target="_blank"  type="button" class="btn btn-info"><i class="fas fa-building"></i> Pegawai</a>
                  </div>
                
    
                  </div>
                
            </div>
    
         
        
          </div>
          </div>
    <div class="col-12 col-md-12 col-lg-6">
         
    

       
    <div class="card profile-widget mt-5">
      <div class="profile-widget-header">
        <img alt="image" src="https://ui-avatars.com/api/?name=Menu Transaksi&color=FFEDDA&background=3DB2FF" class="rounded-circle profile-widget-picture">
        <div class="profile-widget-items">
          <h3 class="ml-5 mt-4">Format Import Menu Transaksi</h3>
        </div>
         
          
          <div class="card-body">
         
            {{-- <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
              <a  href="{{ route('pemasukan') }}" type="button" class="btn btn-light"><i class="fas fa-hand-holding-usd"></i> Pemasukan</a>
              <a  href="{{ route('pengeluaran') }}" type="button" class="btn btn-light"><i class="fas fa-file-invoice-dollar"></i> Pengeluaran</a>
            </div> --}}
            {{-- <div class="clearfix"></div> --}}
            <div class="btn-group btn-group-lg mt-3" role="group" aria-label="Basic example">
              
              <a   href="{{ url('assets/formatimport/sim-tagihanatur.xlsx') }}"  target="_blank" type="button" class="btn btn-danger"><i class="fas fa-fire"></i> Tagihan Atur </a>
              <a   href="{{ url('assets/formatimport/sim-tagihansiswa.xlsx') }}"  target="_blank" type="button" class="btn btn-danger"><i class="fas fa-graduation-cap"></i> Tagihan Siswa </a>
              <a   href="{{ url('assets/formatimport/sim-tagihansiswadetail.xlsx') }}"  target="_blank" type="button" class="btn btn-danger"><i class="fas fa-graduation-cap"></i> Tagihan Siswa Detail</a>
            </div>

            

            </div>
          
      </div>

   
  
    </div>







    </div>
    @endif


@if($tipeuser==='admin')
<div class="col-12 col-md-12 col-lg-6">

        


</div>
@endif



  </div>
  
@endsection

@section('container-modals')

@endsection
