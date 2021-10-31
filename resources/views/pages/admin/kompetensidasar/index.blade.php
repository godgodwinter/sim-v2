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

                <div class="d-flex bd-highlight mb-0 align-items-center">

                    <div class="p-2 bd-highlight">

                        <form action="{{ route('silabus.cari') }}" method="GET" class=" d-inline">
                            <input type="text" class="babeng babeng-select  ml-0" name="cari">
                        </div>

                    <div class="p-2 bd-highlight">
                            <span>
                                <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                    value="Cari">
                            </span>
                    </div>

                    <div class="ml-auto p-2 bd-highlight">

                <button type="button" class="btn btn-icon btn-primary btn-sm ml-0 ml-sm-0"
                    data-toggle="modal" data-target="#importExcel"><i class="fas fa-upload"></i>
                    Import
                </button>
                <a href="{{ route('dataajar.kompetensidasar.exportkd',[$dataajar->id]) }}" type="submit" value="Import"
                    class="btn btn-icon btn-primary btn-sm mr-0"><span class="pcoded-micon"> <i
                            class="fas fa-download"></i> Export </span></a>
                        <x-button-create link="{{route('dataajar.kompetensidasar.create',$dataajar->id)}}"></x-button-create>
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
                            <th  class="text-center py-2 babeng-min-row"> <input type="checkbox" id="chkCheckAll"> All</th>
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
                                <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->id }}">
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
                                <td  class="text-center babeng-min-row"> <a href="{{route('dataajar.kompetensidasar.materipokok.index',[$dataajar->id,$data->id])}}" class="btn btn-icon btn-info btn-sm ml-1"  data-toggle="tooltip" data-placement="top" title="Detail Materi!"><i class="fas fa-info-circle"></i></a>

                                    <x-button-edit link="{{route('dataajar.kompetensidasar.edit',[$dataajar->id,$data->id])}}" />
                                        <x-button-delete link="{{route('dataajar.kompetensidasar.delete',[$dataajar->id,$data->id])}}" />
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
<div class="d-flex justify-content-between flex-row-reverse mt-3">
    <div >
{{ $datas->onEachSide(1)
  ->links() }}
    </div>
    <div>
<a href="#" class="btn btn-sm  btn-danger mb-2" id="deleteAllSelectedRecord"
            onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"  data-toggle="tooltip" data-placement="top" title="Hapus Terpilih">
            <i class="fas fa-trash-alt mr-2"></i> Hapus Terpilih</i>
        </a></div></div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('containermodal')
<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form method="post" action="{{ route('dataajar.kompetensidasar.importkd',[$dataajar->id]) }}" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import KD dan Materi</h5>
          </div>
          <div class="modal-body">
              {{ csrf_field() }}
            <div class="row">
                <div class="col-12">

                    <label>Pilih file excel(.xlsx)</label>
                    <div class="form-group">
                      <input type="file" name="file" required="required">
                    </div>

                </div>
                {{-- <div class="col-12">
                    <label>Jumlah Materi</label>
                    <div class="form-group">
                      <input type="number" class="form-control" name="jml" required="required">
                    </div>

                </div> --}}
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Import</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
