@extends('layouts.default')

@section('title')
Generate Bank Soal {{$dataajar->mapel->nama}} - {{$dataajar->kelas->tingkatan}} {{$dataajar->kelas->jurusan}} {{$dataajar->kelas->suffix}}
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
            <div class="breadcrumb-item"><a href="{{route('silabus')}}">Silabus</a></div>
            <div class="breadcrumb-item"><a href="{{route('dataajar.banksoal',$dataajar->id)}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Tambah</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Tambah</h5>
            </div>
            <div class="card-body">

                <form action="{{route('dataajar.generatebanksoal.store',$dataajar->id)}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">


                        <div class="form-group col-md-3 col-3 mt-0 ml-5">
                            <label class="form-label">Jumlah Soal</label>
                            <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="number" min="1" max="500" name="jml" value="30" class="form-control">
                            </label>


                            </div>
                          </div>
                        <div class="form-group col-md-3 col-3 mt-0 ml-5">
                            <label class="form-label">Acak Soal ?</label>
                            <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="soal" value="Ya" class="selectgroup-input" >
                                <span class="selectgroup-button">Ya</span>
                            </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="soal" value="Tidak" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Tidak</span>
                              </label>

                            </div>
                          </div>
                              <div class="form-group col-md-3 col-3 mt-0 ml-5">
                                  <label class="form-label">Acak Jawaban ?</label>
                                  <div class="selectgroup w-100">
                                  <label class="selectgroup-item">
                                      <input type="radio" name="jawaban" value="Ya" class="selectgroup-input" >
                                      <span class="selectgroup-button">Ya</span>
                                  </label>
                                    <label class="selectgroup-item">
                                      <input type="radio" name="jawaban" value="Tidak" class="selectgroup-input" checked="">
                                      <span class="selectgroup-button">Tidak</span>
                                    </label>

                                  </div>
                                </div>


                    <div class="form-group col-md-3 col-3 mt-0 ml-5">
                        <label for="tgl">Tanggal Ujian<code>*)</code></label>
                        <input type="date" name="tgl" id="tgl" class="form-control @error('tgl') is-invalid @enderror" value="{{old('tgl') ? old('tgl') : date('Y-m-d')}}" required>
                        @error('tgl')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>





                    </div>
                    <div class="row" id="formjawaban">
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
