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
                <form action="/admin/kompetensidasar/edit/{{$datas->id}}" method="post">
                    @csrf
                    <div class="card-header">
                        <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT
                            {{ Str::upper($pages) }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12 col-12 mt-0">
                                <label for="nama">Pilih Tipe</label>

                                <select class="form-control form-control-sm" name="tipe" id="kd_tipe" required readonly>

                                    <option value="{{$datas->tipe}}">{{$datas->tipe}}</option>

                                </select>
                                <input type="hidden" name="tapel_nama" value="{{$datas->tapel_nama}}">
                                <input type="hidden" name="kelas_nama" value="{{$datas->kelas_nama}}">
                                <input type="hidden" name="pelajaran_nama" value="{{$datas->pelajaran_nama}}">
                            </div>

                            <div class="form-group col-md-12 col-12">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror" value="{{$datas->nama}}"
                                    required>
                                @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>

                        <div class="form-group col-md-12 col-12">
                            <label>Kode</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="kodeprefix">
                                        @php
                                            $kodeprefix='3';
                                            if($datas->tipe=='Ketrampilan'){
                                                $kodeprefix='4';
                                            }
                                        @endphp
                                        <b>{{$kodeprefix}}.</b>
                                    </div>
                                </div>
                                <input type="number" min="1" name="kode" id="kodegenerate"
                                    class="form-control @error('kode') is-invalid @enderror" value="{{$datas->kode}}" required readonly>
                                @error('kode')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>


                    </div>


            </div>
            <div class="card-footer text-right">

                <a href="/admin/kompetensidasar/{{base64_encode($datas->pelajaran_nama)}}/{{base64_encode($datas->kelas_nama)}}/{{base64_encode($datas->tapel_nama)}}" class="btn btn-icon btn-dark ml-3"> <i class="fas fa-backward"></i> Batal</a>
                <button class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>

    <div class="col-12 col-md-12 col-lg-8">
        <div class="card">
            <form action="/admin/kompetensidasar/{{base64_encode($datas->pelajaran_nama)}}/{{base64_encode($datas->kelas_nama)}}/{{base64_encode($datas->tapel_nama)}}/materi"
                method="post">
                @csrf
                <div class="card-header">
                    <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> Tambah Materi Pokok</span>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-12 col-12 mt-0">
                            <label for="nama">Pilih Kompetensi Dasar</label>


                            <select class="form-control form-control-sm" name="kompetensidasar_id">




                                <option value="{{$datas->id}}"> {{ $kodeprefix.$datas->kode }} . {{$datas->nama}}</option>

                            </select>
                        </div>

                        <div class="form-group col-md-12 col-12">
                            <label for="nama">Judul</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}"
                                required>
                            @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 col-12">
                            <label for="link">Link Materi</label>
                            <input type="link" name="link" id="link"
                                class="form-control @error('link') is-invalid @enderror" value="{{old('link')}}"
                                required>
                            @error('link')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>


                    </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Tambah Materi</button>
            </div>


                </div>
        </div>
    </div>


</div>
</div>
@endsection

@section('container-modals')


@endsection
