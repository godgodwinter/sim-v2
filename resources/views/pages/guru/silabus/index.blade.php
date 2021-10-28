@extends('layouts.default')

@section('title')
Silabus
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



                <form action="{{ route('guru.silabus.cari') }}" method="GET" class="d-inline">
                    <div class="row mt-0">

                            <div class="col-4 col-md-2">
                                <input type="text" class="form-control form-control-sm" name="cari" placeholder="Cari . . ." autocomplete="off" value="{{$request->cari!=null ? $request->cari : '' }}">
                            </div>
                            <div class="col-4 col-md-2">

                                <select class="js-example-basic-single py-0  @error('kelas_id')
                                is-invalid
                            @enderror" name="kelas_id"  style="width: 100%" >

                                <option disabled selected value=""> Pilih Kelas</option>
                                @foreach ($kelas as $t)
                                    <option value="{{ $t->id }}"> {{ $t->tingkatan }} {{ $t->jurusan }} {{ $t->suffix }} </option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-4 col-md-2">
                                    <button class="btn btn-info ml-0 mt-0 mt-sm-0 px-4 py-1 " type="submit"
                                        value="Cari"> <span class="pcoded-micon"><i class="fas fa-search"></i> Cari </button>


                            </div>
                            <div class="col-12 col-md-6 mt-2 mt-md-0 text-right">

                            </div>

                    </div>
                </form>


                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row">
                                 No</th>
                            <th >Mapel</th>
                            <th >Kelas</th>
                            <th >Guru Pengajar</th>
                            <th >Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">
                                    {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
                                <td>
                                    {{$data->mapel!=null ? $data->mapel->nama : 'Data tidak ditemukan' }}
                                </td>
                                <td>
                                    {{$data->kelas!=null ? $data->kelas->tingkatan.' '.$data->kelas->jurusan.' '.$data->kelas->suffix : 'Data tidak ditemukan'}}
                                </td>

                                <td  data-toggle="modal" data-target="#pilihguru{{$data->id}}">
                                    <label for="" class="text-{{$data->guru!=null ? 'dark' : 'danger'}}">{{$data->guru!=null ? $data->guru->nama : 'Data tidak ditemukan'}}</label>
                                </td>


                                <td class="text-center babeng-min-row">

                                    <a href="{{route('dataajar.kompetensidasar',$data->id)}}" type="button" class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="top" title="Detail Silabus!" >
                                        <i class="fas fa-inbox"></i>
                                    </a>
                                    <a href="{{route('dataajar.banksoal',$data->id)}}"
                                        class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Bank Soal!"> <i
                                            class="far fa-file-archive"></i> </a>
                                    {{-- <a href="{{route('dataajar.generatebanksoal',$data->id)}}"
                                        class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Generate Soal Ujian!"> <i class="fas fa-file-export"></i> </a> --}}
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


@section('containermodal')
        @forelse ($datas as $data)
              <div class="modal fade" id="pilihguru{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{route('store.pengajar',$data->id)}}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pilih Guru Pengajar {{ $data->tingkatan}} {{$data->jurusan}} {{$data->suffix}}</h5>
                      </div>
                      <div class="modal-body">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <select class="js-example-basic-single form-control-sm @error('guru_id')
                            is-invalid
                        @enderror" name="guru_id"  style="width: 75%" required>
                            @if($data->guru!=null)
                            <option value="{{ $data->guru->id }}" selected> {{ $data->guru->nama }}</option>
                            @else
                            <option disabled selected value=""> Pilih Walikelas</option>
                            @endif
                            @foreach ($guru as $t)
                                <option value="{{ $t->id }}"> {{ $t->nama }}</option>
                            @endforeach
                          </select>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>


              @empty

              @endforelse


@endsection
