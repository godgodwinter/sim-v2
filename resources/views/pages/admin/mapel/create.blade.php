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
            <div class="breadcrumb-item"><a href="{{route('mapel')}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Tambah</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Tambah</h5>
            </div>
            <div class="card-body">

                <form action="{{route('mapel.store')}}" method="post">
                    @csrf

                    <div class="row">

                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="nama">Nama  <code>*)</code></label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}" required>
                        @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="kkm">KKM  <code>*)</code></label>
                        <input type="number" name="kkm" min="1" max="100" id="kkm" class="form-control @error('kkm') is-invalid @enderror" value="{{ old('kkm') ? old('kkm') : '75'}}" required>
                        @error('kkm')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>


                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label>Tipe <code>*)</code></label>
                        <select class="form-control form-control-lg" required name="tipepelajaran">
                              @if (old('tipepelajaran'))
                              <option>{{old('tipepelajaran')}}</option>
                              @endif
                          @foreach ($tipepelajaran as $t)
                              <option>{{ $t->nama }}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label>jurusan <code>//jika tipe bukan jurusan maka otomatis akan berisi umum</code></label>
                        <select class="form-control form-control-lg" required name="jurusan">
                              @if (old('jurusan'))
                              <option>{{old('jurusan')}}</option>
                              @endif
                          @foreach ($jurusan as $t)
                              <option value="{{ $t->kode }}"> {{ $t->kode }}  - {{ $t->nama }}</option>
                          @endforeach
                        </select>
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
