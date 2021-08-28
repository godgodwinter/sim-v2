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



{{-- DATALAPORAN --}}
@php
$sumpemasukan = DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])
  ->sum('nominal');

$countpemasukan = DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])
  ->count();

$sumpemasukanbos = DB::table('pemasukan')->where('kategori_nama','Dana Bos')
  ->sum('nominal');

$countpemasukanbos = DB::table('pemasukan')->where('kategori_nama','Dana Bos')
  ->count();

$countpengeluaran = DB::table('pengeluaran')
  ->count();


$sumpengeluaran = DB::table('pengeluaran')
  ->sum('nominal');

$sumtagihansiswa = DB::table('tagihansiswadetail')
  ->sum('nominal');

$counttagihansiswa = DB::table('tagihansiswadetail')
  ->count();

$totalpemasukan=$sumpemasukan+$sumtagihansiswa+$sumpemasukanbos;
$sisasaldo=$totalpemasukan-$sumpengeluaran;


$ambilkepsek = DB::table('users')
->where('tipeuser','kepsek')
  ->get();
  foreach ($ambilkepsek as $kepsek) {
      # code...
  }
@endphp
{{-- DATALAPORAN-END --}}
@section('container')


{{-- <div class="section-header">
    <h1>Typography</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>
      <div class="breadcrumb-item">Typography</div>
    </div>
  </div> --}}


  <div class="section-body">
    <h2 class="section-title">Hi, {{ Auth::user()->name }} dari {{ $sekolahnama }} ! Anda Login sebagai {{ $hakakses }}</h2>
    <p class="section-lead">
     Berikut beberapa Informasi tetang data dan menu di Sistem Ini.
    </p>

    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-6">
        <div class="card profile-widget">
          <div class="profile-widget-header">
            <img alt="image" src="../assets/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Kelas</div>
                <div class="profile-widget-item-value"> {{ $kelas }} Kelas</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Siswa</div>
                <div class="profile-widget-item-value">{{ $siswa }} Siswa</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Lunas</div>
                <div class="profile-widget-item-value">{{ $lunas }} </div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Belum Lunas</div>
                <div class="profile-widget-item-value"> {{ $belumlunas }} </div>
              </div>
            </div>
          </div>

          {{-- <div class="card-footer text-center">
            <div class="font-weight-bold mb-2">Lihat Selengkapnya</div>
            <a href="#" class="btn btn-info mr-1">
              <i class="fas fa-angle-double-right"></i>
            </a>
            
          </div> --}}
       
      
        </div>


        <div class="card profile-widget mt-5">
            <div class="profile-widget-header">
              <img alt="image" src="../assets/img/products/product-4-50.png" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">
             
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Dana BOS</div>
                  <div class="profile-widget-item-value">@currency($sumpemasukanbos)</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pemasukan Selain Dana BOS</div>
                  <div class="profile-widget-item-value">@currency($sumpemasukan)</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pembayaran Siswa</div>
                  <div class="profile-widget-item-value">@currency($sumtagihansiswa)</div>
                </div>
              </div>

              <div class="profile-widget-items mt-4">
             
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pengeluaran</div>
                  <div class="profile-widget-item-value">@currency($sumpengeluaran)</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Saldo</div>
                  <div class="profile-widget-item-value">@currency($sisasaldo)</div>
                </div>
              </div>
            </div>
            {{-- <div class="card-footer text-center">
                <div class="font-weight-bold mb-2">Lihat Selengkapnya</div>
                <a href="#" class="btn btn-info mr-1">
                  <i class="fas fa-angle-double-right"></i>
                </a>
                
              </div> --}}
        
          </div>




          @if($tipeuser==='admin')
          <div class="card profile-widget mt-5">
            <div class="profile-widget-header">
              <img alt="image" src="https://ui-avatars.com/api/?name=Menu Mastering&color=FFEDDA&background=3DB2FF" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">
                <h3 class="ml-5 mt-4">Menu Mastering</h3>
              </div>
               
                
                <div class="card-body">
                  <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                    <a  href="{{ route('kategori') }}" type="button" class="btn btn-warning"><i class="fab fa-korvue"></i> Kategori</a>
                  </div>
                  <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                    <a  href="{{ route('tapel') }}" type="button" class="btn btn-primary"><i class="fas fa-calendar-alt"></i> Tahun Pelajaran</a>
                    <a  href="{{ route('kelas') }}" type="button" class="btn btn-primary"><i class="fas fa-school"></i> Kelas</a>   
                  </div>
                    <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                    <a  href="{{ route('siswa') }}" type="button" class="btn btn-info"><i class="fas fa-user-graduate"></i> Siswa</a>
                    <a  href="{{ route('pegawai') }}" type="button" class="btn btn-info"><i class="fas fa-building"></i> Pegawai</a>
                  </div>
                
    
                  </div>
                
            </div>
    
         
        
          </div>



          <div class="card profile-widget mt-5">
            <div class="profile-widget-header">
              <img alt="image" src="https://ui-avatars.com/api/?name=Download dan Guide&color=FFEDDA&background=3DB2FF" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">
                <h3 class="ml-5 mt-4">Download dan Guide</h3>
              </div>
               
                
                <div class="card-body">
                  <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                    <a  href="{{ route('kategori') }}" type="button" class="btn btn-warning"><i class="fab fa-korvue"></i> Download Format Import</a>
                  </div>

                  <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                    <a  href="{{ route('tapel') }}" type="button" class="btn btn-primary"><i class="fas fa-calendar-alt"></i> Pentunjuk Penggunaan</a>
                    {{-- <a  href="{{ route('kelas') }}" type="button" class="btn btn-primary"><i class="fas fa-school"></i> Kelas</a>    --}}
                  </div>
                  </div>
                
            </div>
    
         
        
          </div>


          @endif
    

      </div>

    @if($tipeuser==='admin')
    <div class="col-12 col-md-12 col-lg-6">
         
      <div class="card profile-widget mt-5">
        <div class="profile-widget-header">
          <img alt="image" src="https://ui-avatars.com/api/?name=Menu Penting&color=FFEDDA&background=3DB2FF" class="rounded-circle profile-widget-picture">
          <div class="profile-widget-items">
            <h3 class="ml-5 mt-4">Menu Penting</h3>
            
          </div>

          <div class="card-body">
          <div class="btn-group btn-group-lg mt-3" role="group" aria-label="Basic example">

          <a href="{{ route('settings') }}"  class="btn btn-icon btn-light btn-md" data-toggle="tooltip" data-placement="top" title="Untuk mengatur data default, data sekolah dan data lainya!"><span
            class="pcoded-micon"> <i class="fas fa-cog"></i> Pengaturan </span></a href="$add">
                  
            <button type="button" class="btn btn-icon btn-info btn-md" data-toggle="modal"  data-placement="top" title="File sampah sisa export dan import! Agar tidak membebani server."  data-target="#cleartemp"><i class="fas fa-trash"></i>
              Hapus File Sampah
            </button>

          <a href="/admin/datatagihan/addall"  class="btn btn-icon btn-warning btn-md" data-toggle="tooltip" data-placement="top" title="Tambah semua kelas yang belum di setting. Kemudian Syncron ke menu tagihan siswa!"><span
            class="pcoded-micon"> <i class="far fa-plus-square"></i> Tambah Semua </span></a href="$add">
         
              </div>
              </div>
      </div>
      </div>

       
    <div class="card profile-widget mt-5">
      <div class="profile-widget-header">
        <img alt="image" src="https://ui-avatars.com/api/?name=Menu Transaksi&color=FFEDDA&background=3DB2FF" class="rounded-circle profile-widget-picture">
        <div class="profile-widget-items">
          <h3 class="ml-5 mt-4">Menu Transaksi</h3>
        </div>
         
          
          <div class="card-body">
         
            <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
              <a  href="{{ route('pemasukan') }}" type="button" class="btn btn-light"><i class="fas fa-hand-holding-usd"></i> Pemasukan</a>
              <a  href="{{ route('pengeluaran') }}" type="button" class="btn btn-light"><i class="fas fa-file-invoice-dollar"></i> Pengeluaran</a>
            </div>
            <div class="clearfix"></div>
            <div class="btn-group btn-group-lg mt-3" role="group" aria-label="Basic example">
              
              <a  href="{{ route('tagihanatur') }}" type="button" class="btn btn-danger"><i class="fas fa-fire"></i> Tagihan Atur </a>
              <a  href="{{ route('tagihansiswa') }}" type="button" class="btn btn-danger"><i class="fas fa-graduation-cap"></i> Tagihan Siswa </a>
            </div>

            

            </div>
          
      </div>

   
  
    </div>


  <div class="card profile-widget mt-5">
    <div class="profile-widget-header">
      <img alt="image" src="https://ui-avatars.com/api/?name=Menu Reporting&color=FFEDDA&background=3DB2FF" class="rounded-circle profile-widget-picture">
      <div class="profile-widget-items">
        <h3 class="ml-5 mt-4">Menu Reporting</h3>
      </div>
       
        
        <div class="card-body">
         
            <div class="btn-group btn-group-lg mt-3" role="group" aria-label="Basic example">
              <a  href="{{ route('laporan') }}" type="button" class="btn btn-success"> <i class="fab fa-resolving"></i> Laporan </a>
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

              <!-- Import Excel -->
              <div class="modal fade" id="cleartemp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route('cleartemp') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Temporari</h5>
                      </div>
                      <div class="modal-body">
           
                        {{ csrf_field() }}
           
                        <label></label>
           
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus!</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
@endsection
