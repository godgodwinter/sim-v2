@extends('layouts.default')

@section('title')
Absensi
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
            <div class="card-body">

                <div id="babeng-bar" class="text-left mt-2">

                    <div id="babeng-row ">

                        <form action="{{ route('guru.absensi.cari') }}" method="GET">
                            <input type="text" class="babeng babeng-select  ml-0" name="cari">

                            <span>
                                <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                    value="Cari">
                            </span>
</form>

                    </div>
                </div>

                <x-jsmultidel link="{{route('mapel.multidel')}}" />

                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row">
                                No</th>
                            <th >Nama Kelas</th>
                            <th >Walikelas</th>
                            <th >Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">
                                    {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
                                <td>
                                    {{$data->tingkatan.' '.$data->jurusan.' '.$data->suffix}}
                                </td>
                                <td>
                                    {{$data->guru!=null ? $data->guru->nama : 'Data tidak ditemukan'}}
                                </td>


                                <td class="text-center babeng-min-row">
                                    <a href="{{route('guru.absensi.detail',$data->id)}}" type="button" class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="top" title="Input Absensi Siswa!" >
                                    <i class="fas fa-id-card-alt"></i>
                                </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

@php
$cari=$request->cari;
@endphp
{{ $datas->onEachSide(1)
  ->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
