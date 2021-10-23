@extends('layouts.default')

@section('title')
Bank Soal
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

                <form action="{{route('dataajar.banksoal.store',$dataajar->id)}}" method="post">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-6 col-6 mt-0 ml-5">
                            <label class="form-label">Jenis Soal</label>
                            <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="kategorisoal_nama" value="Pilihan Ganda" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Pilihan Ganda</span>
                            </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="kategorisoal_nama" value="Pilihan Ganda Kompleks" class="selectgroup-input" >
                                <span class="selectgroup-button">Pilihan Ganda Kompleks</span>
                              </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="kategorisoal_nama" value="True/False" class="selectgroup-input">
                                <span class="selectgroup-button">True/False</span>
                              </label>

                            </div>
                          </div>


                        <div class="form-group col-md-3 col-3 mt-0 ml-5">
                            <label class="form-label">Tingkat Kesulitan</label>
                            <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="tingkatkesulitan" value="Mudah" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Mudah</span>
                            </label>


                            </div>
                          </div>
@push('after-style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="{{ asset("assets/") }}/stisla/summernote-bs4.js"></script>
@endpush
                          <div class="form-group col-md-6 col-12 ml-5">
                            <label for="nama">Pertanyaan</label> :
                            <textarea class="form-control summernote-simple" style="min-width: 100%;height:100%;" name="pertanyaan"
                                id="pertanyaan" required></textarea>
                        </div>

                        <div class="form-group col-md-3 col-3 mt-0 ml-5">
                            <div id="image-preview" class="image-preview  @error('file') is-invalid @enderror">
                                <label for="image-upload" id="image-label">Tambah Gambar</label>
                                <input type="file" name="file" id="image-upload" />
                        @error('file')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                            </div>
                  </div>


                    </div>
                    <div class="row">
                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="nama">Pilihan Jawaban 1 <code>*)</code></label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}" required>
                            @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-2 col-2 mt-0 ml-5">
                            <label class="form-label">Hasil Jawaban 1</label>
                            <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="hasiljawaban1" value="Benar" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Benar</span>
                            </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="hasiljawaban1" value="Salah" class="selectgroup-input" >
                                <span class="selectgroup-button">Salah</span>
                              </label>

                            </div>
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
