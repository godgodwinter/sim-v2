@extends('layouts.default')

@section('title')
Materi Pokok {{$kd->nama}}
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
            <div class="breadcrumb-item"><a href="{{route('dataajar.kompetensidasar',$dataajar->id)}}"> KD {{$dataajar->mapel->nama}} - {{$dataajar->kelas->tingkatan}} {{$dataajar->kelas->jurusan}} {{$dataajar->kelas->suffix}}</a></div>
            <div class="breadcrumb-item"><a href="{{route('dataajar.kompetensidasar.materipokok.index',[$dataajar->id,$kd->id])}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Tambah</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Tambah</h5>
            </div>
            <div class="card-body">

                <form action="{{route('dataajar.kompetensidasar.materipokok.store',[$dataajar->id,$kd->id])}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

@push('after-style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="{{ asset("assets/") }}/stisla/summernote-bs4.js"></script>
@endpush
                        <div class="form-group col-md-6 col-12 ml-5">
                        <label for="nama">Judul</label> :
                        <textarea class="form-control " style="min-width: 100%;height:100%;" name="nama"
                            id="nama"  ></textarea>
                        </div>
                        @push('after-script')
                        <script>

                            $(document).ready(function() {
                                // $('#pertanyaan').summernote({focus: true});
                            });
                        </script>

                @endpush

                <div class="form-group col-md-3 col-3 mt-0 ml-5">
                    <label class="form-label">Upload Materi</label>
                    <div class="input-group">
                        <input type="file"  name="link"
                            class="form-control @error('link') is-invalid @enderror" required>
                        @error('link')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>
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
