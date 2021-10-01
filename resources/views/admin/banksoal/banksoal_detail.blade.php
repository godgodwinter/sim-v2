@section('title','Generate Bank soal Untuk Moodle')
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
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="{{ asset("assets/") }}/img/products/product-3-50.png"
                        class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="form-group col-md-12 col-12 mt-1 text-right">
                            <a href="/admin/kompetensidasar/{{base64_encode($datas->pelajaran_nama)}}/{{base64_encode($datas->kelas_nama)}}/{{base64_encode($datas->tapel_nama)}}/materipokok/banksoal/{{base64_encode($datas->materipokok_nama)}}/{{base64_encode($datas->kompetensidasar_kode)}}/{{base64_encode($datas->kompetensidasar_tipe)}}" class="btn btn-icon btn-dark ml-3 btn-sm"> <i class="fas fa-backward"></i> Batal</a>

                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal"
                                data-target="#importExcel"><i class="fas fa-upload"></i>
                                Import
                            </button>
                            <a href="/admin/@yield('linkpages')/export" type="submit" value="Import"
                                class="btn btn-icon btn-primary btn-sm"><span class="pcoded-micon"> <i
                                        class="fas fa-download"></i> Export </span></a>
                        </div>
                    </div>
                </div>
                <div class="card-body -mt-5">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <tr>
                                <th width="10px" class="text-center"> No </th>
                                <th> Jawaban </th>
                                <th width="15%" class="text-center" >Hasil </th>
                                <th width="15%" class="text-center" >Nilai </th>
                                {{-- <th> Nilai </th> --}}
                                <th width="15%" class="text-center"> Aksi </th>
                            </tr>
                            @foreach ($datajawaban as $data)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$data->jawaban}}</td>
                                    <td class="text-center text-capitalize">{{$data->hasil}}</td>
                                    <td class="text-center text-capitalize">{{$data->nilai}}</td>
                                    <td class="text-center">
                                        <x-button-edit link="/admin/banksoaldetail/{{$data->id}}" />
                                        <x-button-delete link="/admin/banksoaldetail/{{$data->id}}" />
                                    </td>
                                </tr>
                            @endforeach




                        </table>
                    </div>
                    <div class="card-footer text-right">
                    </div>
                </div>

            </div>


        </div>

        <div class="col-12 col-md-12 col-lg-12">

            <div class="card">
                <form
                    action="{{url('/admin/')}}/banksoal/{{$datas->id}}/detail"
                    method="post">
                    @csrf
                    <div class="card-header">
                        <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH JAWABAN
                            </span>
                    </div>
                    <div class="card-body">
                        <div class="row">


                            <div class="form-group col-md-6 col-12">
                                <label for="jawaban">Jawaban</label>
                                <input type="text" name="jawaban" id="jawaban"
                                    class="form-control @error('jawaban') is-invalid @enderror"
                                    required>
                                @error('jawaban')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label for="jawaban">Hasil</label>
                            <select class="form-control form-control-sm" name="hasil" >
                                  <option class="text-capitalize">salah</option>
                                  <option class="text-capitalize">benar</option>


                            </select>
                            </div>



                        </div>

                        <div class="card-footer text-right">
                            <a href="/admin/kompetensidasar/{{base64_encode($datas->pelajaran_nama)}}/{{base64_encode($datas->kelas_nama)}}/{{base64_encode($datas->tapel_nama)}}/materipokok/banksoal/{{base64_encode($datas->materipokok_nama)}}/{{base64_encode($datas->kompetensidasar_kode)}}/{{base64_encode($datas->kompetensidasar_tipe)}}" class="btn btn-icon btn-dark ml-3"> <i class="fas fa-backward"></i> Batal</a>
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
