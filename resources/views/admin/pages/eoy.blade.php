@extends('layouts.layoutadmin1')

@section('title','End of Year')
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
    <h2 class="section-title"> End of Year dilakukan pada akhir tahun pelajaran. Untuk mengurangi kesalahan input data pada tahun pelajaran sebelum-sebelumnya</h2>
    {{-- <p class="section-lead">
     
    </p> --}}

    <div class="row mt-sm-4">

        <div class="col-12 col-md-12 col-lg-7">

            <div class="card profile-widget mt-5">
                <div class="profile-widget-header">
                    <img alt="image" src="https://ui-avatars.com/api/?name=PK&color=FFEDDA&background=3DB2FF"
                        class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <h3 class="ml-5 mt-4"> Penjalasan Alur EoY!</h3>
                    </div>


                    <div class="card-body">
                        <p> 1. Data yang sudah di masukkan pada tahun pelajaran aktif akan di insert ke tabel arsip </p>
                      

                        <p> 2. Kemudian semua data yang berhubungan dengan siswa dan pembayaran akan di hapus</p>

                        <p> 3. setting_statusapp diubah menjadi disable "tidak bisa melakukan transaksi pembayaran" </p>

                        <div class="section-title mt-0">Catatan : </div>
                        <blockquote>
                          1. Untuk jaga-jaga ada bug/kesalahan sistem backup dengan melakukan export pada data yang di anggap penting!
                    
                        <br>
                          2. arsipkode dari Tahun aktif pada saat EoY dilakukan! 
                       
                          <br>
                          3. jika data sama maka tidak diinput //if data tidak ditemukan maka insert else update or do nothing
                          <br>
                          4. jika tidak ada pembayaran sama sekali maka EoY tidak dapat dilakukan
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
                      <h3 class="ml-5 mt-4">Lakukan End of Year!</h3>
                  </div>


                  <div class="card-body">
                     
                      {{-- <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example"> --}}
                        <div class="text-right">
                            <form action="{{ route('eoy.do') }}" method="post" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-lg"
                                    onclick="return  confirm('Anda yakin melakukan EoY? Y/N')"  data-toggle="tooltip" data-placement="top" title="Hapus Data!"><span
                                        class="pcoded-micon"> <i class="far fa-calendar-check"></i> EoY!</span></button>
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
