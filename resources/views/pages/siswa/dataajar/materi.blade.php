@extends('layouts.default')

@section('title')
Kompetensi Dasar {{$dataajar->mapel->nama}} - {{$dataajar->kelas->tingkatan}} {{$dataajar->kelas->jurusan}} {{$dataajar->kelas->suffix}}
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
            <div class="breadcrumb-item">@yield('title')</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">

                <div id="babeng-bar" class="text-center mt-2">

                    <div id="babeng-row ">

                        <form action="{{ route('silabus.cari') }}" method="GET" class=" d-inline">
                            <input type="text" class="babeng babeng-select  ml-0" name="cari">

                            <span>
                                <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                    value="Cari">
                            </span>
                            {{-- <a href="{{route('dataajar.kompetensidasar.create',$dataajar->id)}}" type="submit" value="Import"
                                class="btn btn-icon btn-primary btn-sm ml-2"><span class="pcoded-micon"> <i
                                        class="fas fa-download"></i> Tambah  Materi</span></a> --}}
                                     </form>
</form>

                    </div>
                </div>

                <x-jsmultidel link="{{route('dataajar.kompetensidasar.multidel',$dataajar->id)}}" />

                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th  class="text-center py-2 babeng-min-row">
                                No</th>
                            <th  class="text-center py-2 babeng-min-row">Kode</th>
                            <th >Kompetensi Dasar</th>
                            <th   class="text-center babeng-min-row">Jumlah Materi</th>
                            <th class="text-center ">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                            <td class="text-center">
                                {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>

                                <td class="text-center">
                                    @php
                                        if($data->tipe==1 ? $preffix='3.' : $preffix='4.')
                                    @endphp
                                    {!! $data->kode!=null ? $preffix.$data->kode : 'Data tidak ditemukan' !!}
                                </td>
                                <td>
                                    {{$data->nama!=null ? $data->nama : 'Data tidak ditemukan'}}


                                </td>
                                <td class="text-center">   {{$data->materipokok!=null ? $data->materipokok->count() : '0'}} </td>
                                <td  class="text-center babeng-min-row"> <a href="{{route('menusiswa.materi.detail',[$dataajar->id,$data->id])}}" class="btn btn-icon btn-info btn-sm ml-1"  data-toggle="tooltip" data-placement="top" title="Detail Materi!"><i class="fas fa-info-circle"></i></a>

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
        </a>
            </div>
        </div>
    </div>
</section>
@endsection
