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

                    <form action="/admin/settings/1" method="post">
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
                <h4>Password dan Data Default</h4>
                </div>
                <div class="card-body">

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

                    <form action="#" method="post" class="d-inline">
                        @csrf
                        <button class="btn btn-info">Seeder Data Kelas</button>
                    </form>

                    <form action="#" method="post" class="d-inline">
                        @csrf
                        <button class="btn btn-info">Seeder Data Siswa</button>
                    </form>


                    <form action="#" method="post" class="d-inline">
                        @csrf
                        <button class="btn btn-info">Seeder Data Guru</button>
                    </form>


                    <form action="#" method="post" class="d-inline">
                        @csrf
                        <button class="btn btn-info">Seeder Data Mapel</button>
                    </form>


                    <form action="#" method="post" class="d-inline">
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
