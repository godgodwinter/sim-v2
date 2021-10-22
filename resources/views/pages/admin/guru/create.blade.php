@extends('layouts.default')

@section('title')
Tahun Pelajaran
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
            <div class="breadcrumb-item"><a href="{{route('guru')}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Tambah</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Tambah</h5>
            </div>
            <div class="card-body">

                <form action="{{route('guru.store')}}" method="post">
                    @csrf

                    <div class="row">

                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="nomerinduk">Nomer Induk <code>*)</code></label>
                        <input type="text" name="nomerinduk" id="nomerinduk" class="form-control @error('nomerinduk') is-invalid @enderror" value="{{old('nomerinduk')}}" required>
                        @error('nomerinduk')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="nama">Nama Guru<code>*)</code></label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}" required>
                        @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>


                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="alamat">Alamat<code>*)</code></label>
                        <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{old('alamat')}}" required>
                        @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="telp">No Hp<code>*)</code></label>
                        <input type="text" name="telp" id="telp" class="form-control @error('telp') is-invalid @enderror" value="{{old('telp')}}" required>
                        @error('telp')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>

                    {{-- <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="username">Username<code></code></label>

                        <input type="text" class="form-control  @error('username') is-invalid @enderror" name="username" required  value="{{old('username')}}">

                        @error('username')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div> --}}


                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="alamat">Email<code></code></label>

                        <input type="text" class="form-control  @error('email') is-invalid @enderror" name="email" required  value="{{old('email')}}">

                        @error('email')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>


                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="alamat">Password<code></code></label>


                        <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required>

                        @error('password')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="alamat">Konfirmasi Password<code></code></label>


                        <input type="password" class="form-control  @error('password2') is-invalid @enderror" name="password2" required>

                        @error('password2')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>


                    </div>

                    <div class="card-footer text-right mr-5">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</section>
@endsection
