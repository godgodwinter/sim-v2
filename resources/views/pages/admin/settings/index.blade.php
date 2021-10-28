@extends('layouts.default')

@section('title')
Pengaturan
@endsection

@push('before-script')
    @if (session('status'))
    <x-sweetalertsession tipe="{{session('tipe')}}" status="{{session('status')}}"/>
    @endif
@endpush


@section('content')
        <section class="section">
            <div class="section-header">
            <h1>@yield('title')</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">Dashboard</a></div>
                {{-- <div class="breadcrumb-item"><a href="#">Layout</a></div> --}}
                <div class="breadcrumb-item">@yield('title')</div>
            </div>
            </div>

            <div class="section-body">
            <div class="card">
                <div class="card-header">
                <h4>Pengaturan Aplikasi</h4>
                </div>
                <div class="card-body">

                    <form action="/admin/settings/1" method="post" enctype="multipart/form-data">
                        @method('put')
                        @csrf

                        <div class="row">

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="app_nama">Nama Aplikasi <code>*)</code></label>
                            <input type="text" name="app_nama" id="app_nama" class="form-control @error('app_nama') is-invalid @enderror" value="{{$datas->app_nama}}" required>
                            @error('app_nama')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="app_namapendek">Singkatan Aplikasi <code>*)</code></label>
                            <input type="text" name="app_namapendek" id="app_namapendek" class="form-control @error('app_namapendek') is-invalid @enderror" value="{{$datas->app_namapendek}}" required>
                            @error('app_namapendek')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="paginationjml">Pagination <code>*)</code></label>
                            <input type="number" name="paginationjml" id="paginationjml" class="form-control @error('paginationjml') is-invalid @enderror" value="{{$datas->paginationjml}}" required min="3" max="100">
                            @error('paginationjml')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>


                        </div>



                </div>
            </div>
            <div class="card">
                <div class="card-header">
                <h4>Informasi Sekolah</h4>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="lembaga_nama">Nama Sekolah <code>*)</code></label>
                            <input type="text" name="lembaga_nama" id="lembaga_nama" class="form-control @error('lembaga_nama') is-invalid @enderror" value="{{$datas->lembaga_nama}}" required>
                            @error('lembaga_nama')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="lembaga_jalan">Alamat <code>*)</code></label>
                            <input type="text" name="lembaga_jalan" id="lembaga_jalan" class="form-control @error('lembaga_jalan') is-invalid @enderror" value="{{$datas->lembaga_jalan}}" required>
                            @error('lembaga_jalan')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="lembaga_telp">No.Telp <code>*)</code></label>
                            <input type="text" name="lembaga_telp" id="lembaga_telp" class="form-control @error('lembaga_telp') is-invalid @enderror" value="{{$datas->lembaga_telp}}" required >
                            @error('lembaga_telp')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="lembaga_kota">Kota <code>*)</code></label>
                            <input type="text" name="lembaga_kota" id="lembaga_kota" class="form-control @error('lembaga_kota') is-invalid @enderror" value="{{$datas->lembaga_kota}}" required >
                            @error('lembaga_kota')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="sekolahttd">Nama Kepala Sekolah <code>*)</code></label>
                            <input type="text" name="sekolahttd" id="sekolahttd" class="form-control @error('sekolahttd') is-invalid @enderror" value="{{$datas->sekolahttd}}" required >
                            @error('sekolahttd')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="sekolahttd2">TTD Kepala Sekolah 2 <code>*)</code></label>
                            <input type="text" name="sekolahttd2" id="sekolahttd" class="form-control @error('sekolahttd2') is-invalid @enderror" value="{{$datas->sekolahttd2}}" required >
                            @error('sekolahttd2')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>



                        </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                <h4>Password dan Data Default</h4>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="tapelaktif">Tapel <code>*)</code></label>
                            <select name="tapelaktif" id="tapelaktif" class="form-control @error('tapelaktif') is-invalid @enderror">


                                <option>{{$datas->tapelaktif}}</option>

                            @foreach ($tapel as $t)
                                <option>{{ $t->nama }}</option>
                            @endforeach
                            </select>
                            {{-- <input type="text" name="tapelaktif" id="tapelaktif" class="form-control @error('tapelaktif') is-invalid @enderror" value="{{$datas->tapelaktif}}" required> --}}
                            @error('tapelaktif')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="semester">Semester <code>*)</code></label>
                            <select name="semesteraktif" id="semesteraktif" class="form-control @error('semesteraktif') is-invalid @enderror">
                                @if ($datas->semesteraktif=='1')
                                <option value="1">{{$datas->semesteraktif.'(SATU)'}}</option>
                                @elseif ($datas->semesteraktif=='2')
                                <option value="2">{{$datas->semesteraktif.'(DUA)'}}</option>
                                @endif

                                <option value="1">1(SATU)</option>
                                <option value="2">2(DUA)</option>
                            </select>
                            {{-- <input type="text" name="tapelaktif" id="tapelaktif" class="form-control @error('tapelaktif') is-invalid @enderror" value="{{$datas->tapelaktif}}" required> --}}
                            @error('semesteraktif')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="nominaltagihandefault">Nominal Default Tagihan Atur<br>{{number_format($datas->nominaltagihandefault,2);}} <code>*)</code></label>
                            <input type="number" name="nominaltagihandefault" id="nominaltagihandefault" class="form-control @error('nominaltagihandefault') is-invalid @enderror" value="{{$datas->nominaltagihandefault}}" required >
                            @error('nominaltagihandefault')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="minimalpembayaranujian">Minimal Pembayaran Ujian<br> <code>*)</code></label>
                            <input type="number" name="minimalpembayaranujian" id="minimalpembayaranujian" class="form-control @error('minimalpembayaranujian') is-invalid @enderror" value="{{$datas->minimalpembayaranujian}}" required >
                            @error('minimalpembayaranujian')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="passdefaultsiswa">Password Siswa Default <code>*)</code></label>
                            <input type="text" name="passdefaultsiswa" id="passdefaultsiswa" class="form-control @error('passdefaultsiswa') is-invalid @enderror" value="{{$datas->passdefaultsiswa}}" required>
                            @error('passdefaultsiswa')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="passdefaultortu">Password Ortu Default <code>*)</code></label>
                            <input type="text" name="passdefaultortu" id="passdefaultortu" class="form-control @error('passdefaultortu') is-invalid @enderror" value="{{$datas->passdefaultortu}}" required>
                            @error('passdefaultortu')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="passdefaultpegawai">Password pegawai Default <code>*)</code></label>
                            <input type="text" name="passdefaultpegawai" id="passdefaultpegawai" class="form-control @error('passdefaultpegawai') is-invalid @enderror" value="{{$datas->passdefaultpegawai}}" required>
                            @error('passdefaultpegawai')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>






                        </div>
                        @push('after-script')
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                      $.uploadPreview({
                                        input_field: "#image-upload",   // Default: .image-upload
                                        preview_box: "#image-preview",  // Default: .image-preview
                                        label_field: "#image-label",    // Default: .image-label
                                        label_default: "Logo Sekolah",   // Default: Choose File
                                        label_selected: "Ganti Logo Sekolah",  // Default: Change File
                                        no_label: false                 // Default: false
                                      });



                                    });
                                </script>
                        @endpush

                                <div class="form-group row mb-4 mt-3">

                                    <div class="col-sm-6 col-md-6">
                                        <center>
                                        @php
                                        $sekolah_logo=asset('/storage/').'/'.$datas->lembaga_logo;
                                        $randomimg='https://ui-avatars.com/api/?name='.$datas->lembaga_nama.'&color=7F9CF5&background=EBF4FF';
                                        // dd($sekolah_logo)
                                        @endphp
                                      <img alt="image" src="{{$datas->lembaga_logo!=null ? $sekolah_logo : $randomimg}}" class="rounded-circle profile-widget-picture" style="object-fit:cover;"  width="200" height="200">
                                        </center>
                                    </div>

                                    <div class="col-sm-4 col-md-4">
                                      <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label2">Ganti Logo Sekolah</label>
                                        <input type="file" name="lembaga_logo" id="image-upload" class="@error('lembaga_logo')
                                        is_invalid
                                    @enderror"  accept="image/png, image/gif, image/jpeg" />

                                    @error('lembaga_logo')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                      </div>
                                    </div>
                                </div>
                        <div class="card-footer text-right mr-5">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                <h4>Seeder dan Reset Data</h4>
                </div>
                <div class="card-body">

                    <form action="{{route('seeder.kelas')}}" method="post" class="d-inline">
                        @csrf
                        <button class="btn btn-info">Seeder Data Kelas</button>
                    </form>

                    <form action="{{route('seeder.siswa')}}" method="post" class="d-inline">
                        @csrf
                        <button class="btn btn-info">Seeder Data Siswa</button>
                    </form>


                    <form action="{{route('seeder.guru')}}" method="post" class="d-inline">
                        @csrf
                        <button class="btn btn-info">Seeder Data Guru</button>
                    </form>


                    {{-- <form action="{{route('seeder.mapel')}}" method="post" class="d-inline">
                        @csrf
                        <button class="btn btn-info">Seeder Data Mapel</button>
                    </form> --}}


                    <form action="{{route('kko')}}" method="get" class="d-inline">
                        @csrf
                        <button class="btn btn-success">Fungsi KKO</button>
                    </form>
                    <br>
                    <br>

                    <form action="{{route('seeder.hard')}}" method="post"  class="d-inline ">
                        @csrf
                        <button class="btn btn-danger">Hard Reset</button>
                    </form>

                    <form action="{{route('cleartemp')}}" method="post"  class="d-inline ">
                        @csrf
                        <button class="btn btn-danger">Clear Temporary</button>
                    </form>

                </div>
            </div>
            </div>
        </section>
@endsection
