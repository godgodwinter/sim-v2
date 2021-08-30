@extends('layouts.layoutadmin1')

@section('title','Start of Year')
@section('halaman','Index')

@section('csshere')
@endsection

@section('jshere')
@endsection
@section('notif')


@if(session('tipe'))
    @php
        $tipe=session('tipe');
    @endphp
@else
    @php
        $tipe='light';
    @endphp
@endif

@if(session('icon'))
    @php
        $icon=session('icon');
    @endphp
@else
    @php
        $icon='far fa-lightbulb';
    @endphp
@endif

@if(session('status'))

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
    <h2 class="section-title"> Start of Year dilakukan pada awal tahun pelajaran. Untuk membantu memulai proses input data pada awal tahun pelajaran. Data-data yang digunakan dari data tahun pelajaran sebelumnya.</h2>
    {{-- <p class="section-lead">
     
    </p> --}}

    <div class="row mt-sm-4">

        <div class="col-12 col-md-12 col-lg-7">

            <div class="card profile-widget mt-5">
                <div class="profile-widget-header">
                    <img alt="image" src="https://ui-avatars.com/api/?name=PK&color=FFEDDA&background=3DB2FF"
                        class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <h3 class="ml-5 mt-4"> Penjalasan Alur SoY!</h3>
                    </div>


                    <div class="card-body">
                        <p> 1. Mengambil data tahun pelajaran aktif di pengaturan kemudian ditambahkan 1 tahun pelajaran, misal : Tahun aktif 2020/2021 menjadi 2021/2022. </p>
                      

                        <p> 2. Mengambil data arsip dengan kondisi tahun pelajaran adalah tahun aktif sebelum di tambahkan 1. Jadi pada contoh di atas adalah 2020/2021</p>

                        <p> 3. Data siswa dan tagihan atur kolom kelas X dan XI akan di tambah 1, kelas XII akan di ubah menjadi alumni. Nominal tagihan  di ambil dari dari nominal tagihan defaul pada menu pengaturan." </p>
                        
                        <p> 4. Fungsi tambah semua akan di jalankan jadi siswa dengan kelas baru akan masuk ke menu tagihan siswa." </p>

                        <div class="section-title mt-0">Catatan : </div>
                        <blockquote>
                          1. Pastikan telah ada data pada tahun sebelumnya dan telah dilakukan EoY atau End of Year. Jika belum lakukan EoY terlebih dahulu1
                    
                        <br>
                          2. Jika data pada tahun sebelumnya belum ada. Atau ingin memulai aplikasi dari awal. Tambahkan saja data di menu biasa. Tidak perlu menggunakan SoY.
                       
                          <br>
                          3. Jika ingin meghapus data atau hanya ingin memulai aplikasi dari awal bisa menggunakan menu Hard Reset pada menu pengaturan.
                        </blockquote>


                    </div>

                </div>



            </div>
        </div>


        <div class="col-12 col-md-12 col-lg-5">
          <div class="card profile-widget mt-5">
              <div class="profile-widget-header">
                  <img alt="image"
                      src="https://ui-avatars.com/api/?name=EoY&color=FFEDDA&background=3DB2FF"
                      class="rounded-circle profile-widget-picture">
                  <div class="profile-widget-items">
                      <h3 class="ml-5 mt-4">Lakukan Start of Year!</h3>
                  </div>


                  <div class="card-body">
                     
                      {{-- <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example"> --}}
                        <div class="text-right">
                            <form action="{{ route('eoy.do') }}" method="post" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-lg"
                                    onclick="return  confirm('Anda yakin melakukan EoY? Y/N')"  data-toggle="tooltip" data-placement="top" title="Hapus Data!"><span
                                        class="pcoded-micon"> <i class="far fa-calendar-check"></i> Start of Year!</span></button>
                            </form>
                          {{-- <a href="{{ route('tagihanatur') }}" type="button"
                              class="btn btn-danger btn-lg"><i class="far fa-calendar-check"></i> EoY!</a> --}}
                      {{-- </div> --}}
                      </div>





                  </div>

              </div>



          </div>

      </div>




    </div>

    @endsection

    @section('container-modals')

    @endsection
