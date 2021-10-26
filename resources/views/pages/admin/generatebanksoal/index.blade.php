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
            <div class="breadcrumb-item">@yield('title')</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">

                <x-button-create link="{{route('dataajar.generatebanksoal.create',$dataajar->id)}}"></x-button-create>


                <a href="{{route('dataajar.banksoal',[$dataajar->id])}}"
                    class="btn btn-success btn-sm py-1" data-toggle="tooltip" data-placement="top" title="Lihat Bank Soal"> <i
                    class="far fa-file-archive"></i> Bank Soal</a>

                <x-jsmultidel link="{{route('dataajar.banksoal.multidel',$dataajar->id)}}" />

                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row"> <input type="checkbox" id="chkCheckAll"> All</th>
                            <th >Jumlah Soal</th>
                            <th >Acak Soal</th>
                            <th >Acak Jawaban</th>
                            <th >Tanggal Generate</th>
                            <th >Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">
                                    <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->id }}">
                                    {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
                                <td>
                                    {!! $data->jml!=null ? $data->jml : 'Data tidak ditemukan' !!} Soal
                                </td>
                                <td>
                                    {{$data->soal!=null ? $data->soal : 'Data tidak ditemukan'}}
                                </td>
                                <td>
                                    {{$data->jawaban!=null ? $data->jawaban : 'Data tidak ditemukan'}}
                                </td>

                                <td>
                                    {{$data->jawaban!=null ? Fungsi::tanggalindo($data->tgl) : 'Data tidak ditemukan'}}
                                </td>



                                <td class="text-center babeng-min-row">

                                    <a href="{{route('dataajar.generatebanksoal.xml',[$dataajar->id,$data->id])}}"
                                        class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Export XML / Moodle Format"> <i class="fas fa-puzzle-piece" target="_blank"></i></a>
                                    <a href="{{route('dataajar.generatebanksoal.pdfsoal',[$dataajar->id,$data->id])}}"
                                            class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Cetak Soal / .pdf" target="_blank"> <i class="fas fa-file-word"></i> </a>
                                    <a href="{{route('dataajar.generatebanksoal.pdfkunci',[$dataajar->id,$data->id])}}"
                                                    class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Cetak Kunci Jawaban / .pdf" target="_blank"> <i class="far fa-file-word"></i> </a>
                                  <x-button-delete link="{{route('dataajar.generatebanksoal.delete',[$dataajar->id,$data->id])}}" />

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
<a href="#" class="btn btn-sm  btn-danger mb-2" id="deleteAllSelectedRecord"
            onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"  data-toggle="tooltip" data-placement="top" title="Hapus Terpilih">
            <i class="fas fa-trash-alt mr-2"></i> Hapus Terpilih</i>
        </a>
            </div>
        </div>
    </div>
</section>
@endsection
