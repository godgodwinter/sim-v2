@extends('layouts.layoutadmin1')

@section('title','Guide')
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
    <h2 class="section-title">Hi, {{ Auth::user()->name }} ! Berikut beberapa petunjuk penggunaan aplikasi di Sistem
        Ini.</h2>
    {{-- <p class="section-lead">
     
    </p> --}}

    <div class="row mt-sm-4">

        <div class="col-12 col-md-12 col-lg-12">

            <div class="card profile-widget mt-5">
                <div class="profile-widget-header">
                    <img alt="image" src="https://ui-avatars.com/api/?name=Tagihan Siswa&color=FFEDDA&background=3DB2FF"
                        class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <h3 class="ml-5 mt-4">Langkah Mengatur Tagihan Siswa </h3>
                    </div>


                    <div class="card-body">
                        <p> 1. Isi atau Import data Tahun Pelajaran </p>
                        <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                            <a href="{{ route('tapel') }}" type="button" class="btn btn-info "><i
                                    class="fas fa-user-graduate"></i> Menu Tahun Pelajaran</a>
                        </div>

                        <p> 2. Isi atau Import data kelas yang ada di sekolah</p>
                        <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                            <a href="{{ route('kelas') }}" type="button" class="btn btn-info "><i
                                    class="fas fa-user-graduate"></i> Menu Kelas</a>
                        </div>

                        <p> 3. Isi atau Import data Tagihan Perkelas di menu tagihan atur </p>
                        <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                            <a href="{{ route('tagihanatur') }}" type="button"
                                class="btn btn-light "><i class="fas fa-user-graduate"></i> Menu Tagihan Atur</a>
                        </div>

                        <p> Anda juga dapat menggunakan tombol tambah semua untuk memasukan semua kelas yang belum atur
                            tagihanya </p>
                        <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">

                            <a href="/admin/datatagihan/addall" class="btn btn-icon btn-warning btn-md"
                                data-toggle="tooltip" data-placement="top"
                                title="Fungsi Tambah semua kelas yang belum di setting. Kemudian Syncron ke menu tagihan siswa!"><span
                                    class="pcoded-micon"> <i class="far fa-plus-square"></i> Fungsi Tambah Semua
                                </span></a>
                        </div>


                        <p> 4. Kemudian isi atau Import data Siswa </p>
                        <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                            <a href="{{ route('tagihanatur') }}" type="button"
                                class="btn btn-danger "><i class="fas fa-user-graduate"></i> Menu Tagihan Atur</a>
                        </div>


                        <h5> Menu tagihan siswa siap digunakan! </h5>


                    </div>

                </div>



            </div>
        </div>


        <div class="col-12 col-md-12 col-lg-12">
          <div class="card profile-widget mt-5">
              <div class="profile-widget-header">
                  <img alt="image"
                      src="https://ui-avatars.com/api/?name=Memulai Pemasukan&color=FFEDDA&background=3DB2FF"
                      class="rounded-circle profile-widget-picture">
                  <div class="profile-widget-items">
                      <h3 class="ml-5 mt-4">Memasukan gambar scan dokumen penunjang tagihan siswa</h3>
                  </div>


                  <div class="card-body">
                      <p> 1. masuk menu tagihan atur</p>
                      <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                          <a href="{{ route('tagihanatur') }}" type="button"
                              class="btn btn-info "><i class="fas fa-user-graduate"></i> Menu Tagihan Atur</a>
                      </div>

                      <p> 2. Pilih tahun pelajaran dan kelas kemudian edit/ubahdata, tombolnya seperti disamping
                        <button  class="btn btn-icon btn-warning btn-sm"  data-toggle="tooltip" data-placement="top" title="Ubah data!"><i class="fas fa-edit"></i></button>

                      </p>
                      <p> 3. Upload gambar scan penunjang tagihan</p>
                      <p> 4. Kemudian Simpan</p>





                  </div>

              </div>



          </div>

      </div>
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card profile-widget mt-5">
              <div class="profile-widget-header">
                  <img alt="image"
                      src="https://ui-avatars.com/api/?name=M U&color=FFEDDA&background=3DB2FF"
                      class="rounded-circle profile-widget-picture">
                  <div class="profile-widget-items">
                      <h3 class="ml-5 mt-4">Mengatur user dan password ujian (moodle)</h3>
                  </div>


                  <div class="card-body">
                      <p> 1. masuk menu siswa</p>
                      <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                          <a href="{{ route('siswa') }}" type="button"
                              class="btn btn-info "><i class="fas fa-user-graduate"></i> Menu Siswa</a>
                      </div>

                      <p> 2. Pilih siswa kemudian edit, tombolnya seperti disamping
                        <button  class="btn btn-icon btn-warning btn-sm"  data-toggle="tooltip" data-placement="top" title="Ubah data!"><i class="fas fa-edit"></i></button>

                      </p>
                      <p> 3.  MAsukkan data User Ujian dan Password Ujian (sesuaikan dengan data ujian)</p>
                      <p> 4. Kemudian Simpan</p>





                  </div>

              </div>



          </div>

      </div>


        <div class="col-12 col-md-12 col-lg-12">
            <div class="card profile-widget mt-5">
                <div class="profile-widget-header">
                    <img alt="image"
                        src="https://ui-avatars.com/api/?name=Memulai Aplikasi&color=FFEDDA&background=3DB2FF"
                        class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <h3 class="ml-5 mt-4">Langkah Memulai Aplikasi</h3>
                    </div>


                    <div class="card-body">
                        <p> 1. Atur data Sekolah dan data default lainya di pengaturan</p>
                        <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                            <a href="{{ route('settings') }}" type="button" class="btn btn-info "><i
                                    class="fas fa-user-graduate"></i> Menu Pengaturan</a>
                        </div>

                        <p> 2. Atur data Profile, photo, email dan password anda</p>
                        <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                            <a href="{{ url('user/profile') }}" type="button"
                                class="btn btn-info "><i class="fas fa-user-graduate"></i> Menu Profile</a>
                        </div>


                        <p> 3. Atur data kategori per menu</p>
                        <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                            <a href="{{ route('kategori') }}" type="button"
                                class="btn btn-warning "><i class="fas fa-user-graduate"></i> Menu Kategori</a>
                        </div>



                    </div>

                </div>



            </div>

        </div>


        <div class="col-12 col-md-12 col-lg-12">
            <div class="card profile-widget mt-5">
                <div class="profile-widget-header">
                    <img alt="image"
                        src="https://ui-avatars.com/api/?name=Memulai Pemasukan&color=FFEDDA&background=3DB2FF"
                        class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <h3 class="ml-5 mt-4">Menggunakan Menu pemasukan</h3>
                    </div>


                    <div class="card-body">
                        <p> 1. Atur Kategori Pemasukan di menu kategori</p>
                        <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                            <a href="{{ route('kategori') }}" type="button"
                                class="btn btn-warning "><i class="fas fa-user-graduate"></i> Menu Kategori</a>
                        </div>

                        <p> 2. Masukkan data pemasukan dan tanggal pemasukan diinput di menu pemasukan</p>
                        <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                            <a href="{{ route('pemasukan') }}" type="button"
                                class="btn btn-info "><i class="fas fa-user-graduate"></i> Menu Pemasukan</a>
                        </div>





                    </div>

                </div>



            </div>

        </div>



    </div>

    @endsection

    @section('container-modals')

    @endsection
