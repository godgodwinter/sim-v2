@extends('layouts.default')

@section('title')
Kelas
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
            <div class="breadcrumb-item"><a href="{{route('kelas')}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Tambah</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Tambah</h5>
            </div>
            <div class="card-body">

                <form action="{{route('kelas.store')}}" method="post">
                    @csrf

                    <div class="row">


                    <div class="form-group col-md-3 col-3 mt-0 ml-5">
                      <label class="form-label">Pilih Tingkatan</label>
                      <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                          <input type="radio" name="tingkatan" value="X" class="selectgroup-input" checked="">
                          <span class="selectgroup-button">X</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="tingkatan" value="XI" class="selectgroup-input">
                          <span class="selectgroup-button">XI</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="tingkatan" value="XII" class="selectgroup-input">
                          <span class="selectgroup-button">XII</span>
                        </label>

                      </div>
                    </div>
                    <div class="form-group col-md-3 col-3 mt-0 ml-5">
                      <label class="form-label">Pilih Jurusan</label>
                      <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                          <input type="radio" name="jurusan" value="OTO" class="selectgroup-input" checked="">
                          <span class="selectgroup-button">OTO</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="jurusan" value="TKJ" class="selectgroup-input">
                          <span class="selectgroup-button">TKJ</span>
                        </label>

                      </div>
                    </div>
                        <div class="form-group col-md-3 col-3 mt-0 ml-5">
                        <label for="nama">Suffix <code>*)</code></label>
                        <input type="text" name="suffix" id="suffix" class="form-control @error('suffix') is-invalid @enderror" value="{{old('suffix') ? old('suffix') : '1'}}" required>
                        @error('suffix')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>



                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="guru_id">Pilih Walikelas <code></code></label>

                        <select class="form-control  @error('guru_id') is-invalid @enderror" name="guru_id" required>
                            @forelse ($walikelas as $d)
                                <option value="{{$d->id}}">{{$d->nomerinduk}} -  {{$d->nama}}</option>
                            @empty
                                <option value=""> Data belum tersedia</option>
                            @endforelse
                        </select>
                        @error('guru_id')<div class="invalid-feedback"> {{$message}}</div>
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
