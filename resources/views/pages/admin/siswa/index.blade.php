@extends('layouts.default')

@section('title')
Siswa
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

                <div id="babeng-bar" class="text-center mt-2">

                    <div id="babeng-row ">

                        <form action="{{ route('siswa.cari') }}" method="GET">
                            <input type="text" class="babeng babeng-select  ml-0" name="cari">

                            <select class="js-example-basic-single babeng babeng-select @error('kelas')
                            is-invalid
                        @enderror" name="kelas"  style="width: 100%" >

                            <option disabled selected value=""> Pilih Kelas</option>
                            @foreach ($kelas as $t)
                                <option value="{{ $t->id }}"> {{ $t->tingkatan }} {{ $t->jurusan }} {{ $t->suffix }} </option>
                            @endforeach
                            </select>
                            <span>
                                <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                    value="Cari">
                            </span>

                            <a href="{{route('siswa.create')}}" type="submit" value="Import"
                                class="btn btn-icon btn-primary btn-sm ml-2"><span class="pcoded-micon"> <i
                                        class="fas fa-download"></i> Tambah </span></a> </form>

                    </div>
                </div>

                <x-jsmultidel link="{{route('siswa.multidel')}}" />

                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th width="8%" class="text-center py-2"> <input type="checkbox" id="chkCheckAll"> All</th>
                            <th >Nama</th>
                            <th >Kelas</th>
                            <th >Email</th>
                            <th >Photo</th>
                            <th width="10%" class="text-center">Aksi</th>
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
                                    @php
                                    $siswa=asset('/storage/').'/'.$data->siswafoto;
                                    @endphp
                                <img alt="image" src="{{$data->siswafoto!=null  ? $siswa : 'https://ui-avatars.com/api/?name=Admin&color=7F9CF5&background=EBF4FF'}}" class="img-thumbnail" data-toggle="tooltip" title="{{$data->nama}}" width="60px" height="60px" style="object-fit:cover;">
                                </td>


                                <td class="text-center">
                                    {{-- <x-button-reset-pass link="/admin/{{ $pages }}/{{$data->id}}/reset" /> --}}
                                    <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
                                    <x-button-delete link="/admin/{{ $pages }}/{{$data->id}}" />
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
