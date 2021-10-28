@extends('layouts.default')

@section('title')
Reset Password Siswa
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

                        <form action="{{ route('settings.resetpassword.cari') }}" method="GET">

                            <div class="d-flex bd-highlight mb-3 align-items-center">

                                <div class="p-2 bd-highlight">
                                    <input type="text" class="form-control form-control-sm" name="cari" placeholder="Cari . . ." autocomplete="off" value="{{$request->cari!=null ? $request->cari : '' }}">
                                </div>
                                <div class="p-2 bd-highlight">

                                    <select class="js-example-basic-single py-0  @error('kelas_id')
                                    is-invalid
                                @enderror" name="kelas_id"  style="width: 100%" >

                                    <option disabled selected value=""> Pilih Kelas</option>
                                    @foreach ($kelas as $t)
                                        <option value="{{ $t->id }}"> {{ $t->tingkatan }} {{ $t->jurusan }} {{ $t->suffix }} </option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="p-2 bd-highlight">
                                        <button class="btn btn-info ml-0 mt-0 mt-sm-0 px-4 py-1 " type="submit"
                                            value="Cari"> <span class="pcoded-micon"><i class="fas fa-search"></i> Cari </button>


                                </div>
                                <div class="ml-auto p-2 bd-highlight">
                                    <a href="{{route('settings.resetpassword.resetsemua')}}" type="submit" value="Import"
                                    class="btn btn-icon btn-primary btn-sm ml-2"><span class="pcoded-micon"> <i class="fas fa-redo-alt"></i> Reset Semua </span></a>


                        </div>
                        </div>

                          </form>

                <x-jsmultidel link="{{route('siswa.multidel')}}" />

                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row"> <input type="checkbox" id="chkCheckAll"> All</th>
                            <th >Nama</th>
                            <th >Kelas</th>
                            <th >Email</th>
                            <th >Photo</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">
                                    <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->id }}">
                                    {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
                                <td>
                                    {{Str::limit($data->nama,25,' ...')}}
                                </td>
                                <td>
                                    {{ $data->kelas_id!=null ? $data->kelas->tingkatan.' '.$data->kelas->jurusan.' '.$data->kelas->suffix : 'Data tidak ditemukan'}}
                                </td>
                                <td>
                                    {{ $data->users!=null ? $data->users->email : 'Data tidak ditemukan'}}
                                </td>
                                <td>
                                    <img alt="image" src="https://ui-avatars.com/api/?name={{ $data->nama }}&color=7F9CF5&background=EBF4FF" class="rounded mx-auto d-block" width="50px" height="50px">
                                </td>


                                <td class="text-center babeng-min-row">
                                    <x-button-reset-pass link="{{ route('siswa.reset',$data->id)}}" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-between flex-row-reverse mt-3">
                    <div >
@php
$cari=$request->cari;
@endphp
{{ $datas->onEachSide(1)
  ->links() }}
                    </div>
                    <div >
<a href="#" class="btn btn-sm  btn-danger mb-2" id="deleteAllSelectedRecord"
            onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"  data-toggle="tooltip" data-placement="top" title="Hapus Terpilih">
            <i class="fas fa-trash-alt mr-2"></i> Hapus Terpilih</i>
        </a>
                    </div></div>
            </div>
        </div>
    </div>
</section>
@endsection
