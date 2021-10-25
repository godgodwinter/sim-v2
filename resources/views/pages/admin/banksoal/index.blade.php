@extends('layouts.default')

@section('title')
Bank Soal {{$dataajar->mapel->nama}} - {{$dataajar->kelas->tingkatan}} {{$dataajar->kelas->jurusan}} {{$dataajar->kelas->suffix}}
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
                            <a href="{{route('dataajar.banksoal.create',$dataajar->id)}}" type="submit" value="Import"
                                class="btn btn-icon btn-primary btn-sm ml-2"><span class="pcoded-micon"> <i
                                        class="fas fa-download"></i> Tambah Soal </span></a> </form>
</form>

                    </div>
                </div>

                <x-jsmultidel link="{{route('dataajar.banksoal.multidel',$dataajar->id)}}" />

                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th width="8%" class="text-center py-2"> <input type="checkbox" id="chkCheckAll"> All</th>
                            <th >Pertanyaan</th>
                            <th >Jumlah Pilihan</th>
                            <th >Jenis Soal</th>
                            <th >Tingkat kesulitan</th>
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
                                    {!! $data->pertanyaan!=null ? $data->pertanyaan : 'Data tidak ditemukan' !!}
                                </td>
                                <td>
                                    {{$data->banksoaljawaban!=null ? $data->banksoaljawaban->count() : 'Data tidak ditemukan'}}
                                </td>

                                    @php
                                    $kategorisoal_nama='TIdak diketahui';
                                        if($data->kategorisoal_nama==1){
                                            $kategorisoal_nama='Pilihan ganda';
                                        }elseif($data->kategorisoal_nama==2){
                                            $kategorisoal_nama='Pilihan ganda kompleks';
                                        }else{
                                            $kategorisoal_nama='True/False';
                                        }
                                    @endphp
                                <td class="text-capitalize">{{$kategorisoal_nama}}</td>
                                <td class="text-capitalize">{{$data->tingkatkesulitan}}</td>


                                <td class="text-center">
                                    <x-button-edit link="{{route('dataajar.banksoal.edit',[$dataajar->id,$data->id])}}" />
                                    <x-button-delete link="{{route('dataajar.banksoal.delete',[$dataajar->id,$data->id])}}" />

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
