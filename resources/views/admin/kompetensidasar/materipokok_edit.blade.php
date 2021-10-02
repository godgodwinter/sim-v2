@extends('layouts.layoutadminv3')

@section('title')
Kompetensi Dasar - {{$datas->tapel_nama}} - {{$datas->kelas_nama}} - {{$datas->pelajaran_nama}}
@endsection
@section('halaman')
<div class="breadcrumb-item"><a href="{{route('siakaddataajar')}}"> Data ajar</a></div>
<div class="breadcrumb-item"> Kompetensi dasar</div>
@endsection
@section('csshere')
<style>
    .divbutton {
        height: 30px;
        /* background: #000; */
    }

    #buttondel {
        display: none;
    }

    .divbutton:hover #buttondel {
        display: block;
    }

    /* .coba {
    display: flex;
} */

</style>
@endsection

@section('jshere')
@endsection


@section('notif')

@if (session('tipe'))
@php
$tipe=session('tipe');
@endphp
@else
@php
$tipe='light';
@endphp
@endif

@if (session('icon'))
@php
$icon=session('icon');
@endphp
@else
@php
$icon='far fa-lightbulb';
@endphp
@endif

@php
$message=session('status');
@endphp
@if (session('status'))
<x-alert tipe="{{ $tipe }}" message="{{ $message }}" icon="{{ $icon }}" />

@endif
@endsection

{{-- DATATABLE-END --}}
@section('container')


<div class="section-body">
    <div class="row mt-sm-4">

        <div class="col-12 col-md-12 col-lg-4">
            <div class="card">
                <form action="/admin/materipokok/edit/{{$datas->id}}" method="post">
                    @csrf
                    <div class="card-header">
                        <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12 col-12 mt-0">
                                <label for="nama">Pilih Kompetensi Dasar</label>

                                {{-- {{dd($datas)}} --}}

                                <select class="form-control form-control-sm" name="kompetensidasar_id">

                                    <option value="{{$datas->kompetensidasar_kode}}"> {{ $datas->kompetensidasar_kode.' - '.$datas->kompetensidasar_nama }}</option>

                                </select>
                            </div>

                            <div class="form-group col-md-12 col-12">
                                <label for="nama">Judul</label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror" value="{{$datas->nama}}"
                                    required>
                                @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 col-12">
                                <label for="link">Link Materi</label>
                                <input type="link" name="link" id="link"
                                    class="form-control @error('link') is-invalid @enderror" value="{{$datas->link}}"
                                    required>
                                @error('link')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>
            </div>
            <div class="card-footer text-right">

                <a href="/admin/kompetensidasar/{{base64_encode($datas->pelajaran_nama)}}/{{base64_encode($datas->kelas_nama)}}/{{base64_encode($datas->tapel_nama)}}" class="btn btn-icon btn-dark ml-3"> <i class="fas fa-backward"></i> Batal</a>
                <button class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>






</div>
</div>
@endsection

@section('container-modals')


@endsection
