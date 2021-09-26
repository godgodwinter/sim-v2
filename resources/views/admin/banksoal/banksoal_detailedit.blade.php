@section('title','Edit Jawaban')
@section('halaman')
{{-- {{dd($datas)}} --}}
<div class="breadcrumb-item"><a href="{{route('siakaddataajar')}}"> Data ajar</a></div>
<div class="breadcrumb-item"><a href="/admin/kompetensidasar/{{$datas->pelajaran_nama}}/{{$datas->kelas_nama}}/{{$datas->tapel_nama}}">
        Kompetensi dasar</a></div>
<div class="breadcrumb-item">Bank soal</div>
@endsection
@section('csshere')
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






        <div class="col-12 col-md-12 col-lg-12">

            <div class="card">
                <form
                    action="{{url('/admin/')}}/banksoaldetailupdate/{{$datas->id}}"
                    method="post">
                    @method('put')
                    @csrf
                    <div class="card-header">
                        <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT JAWABAN
                            </span>
                    </div>
                    <div class="card-body">
                        <div class="row">


                            <div class="form-group col-md-6 col-6">
                                <label for="jawaban">Jawaban</label>
                                <input type="text" name="jawaban" id="jawaban"
                                    class="form-control @error('jawaban') is-invalid @enderror"
                                    required value="{{$datas->jawaban}}">
                                @error('jawaban')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 col-6">
                                <label for="nilai">Hasil</label>
                            <select class="form-control form-control-sm" name="nilai" >
                                  <option class="text-capitalize">{{$datas->nilai}}</option>
                                  <option class="text-capitalize">salah</option>
                                  <option class="text-capitalize">benar</option>


                            </select>
                            </div>



                        </div>

                        <div class="card-footer text-right">
                            <a href="/admin/banksoal/{{$banksoal_id}}/detail" class="btn btn-icon btn-dark ml-3"> <i class="fas fa-backward"></i> Batal</a>
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                </form>

            </div>
        </div>
    </div>


</div>
</div>
@endsection

@section('container-modals')

<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('kelas.import') }}" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                </div>
                <div class="modal-body">

                    {{ csrf_field() }}

                    <label>Pilih file excel(.xlsx)</label>
                    <div class="form-group">
                        <input type="file" name="file" required="required">
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
