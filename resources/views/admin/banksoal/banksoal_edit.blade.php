@section('title','Bank Soal')
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
                    action="{{url('/admin/')}}/banksoal/{{$datas->id}}"
                    method="post">
                    @method('put')
                    @csrf
                    <div class="card-header">
                        <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT
                            SOAL</span>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-md-6 col-6">
                                <label for="nama">Pertanyaan</label> :
                                {{-- <label for="nama" class="text-dark" id="tingkatkesulitan">Tingkat kesulitan</label> --}}
                                <textarea class="form-control" style="min-width: 100%;height:100%;" name="pertanyaan"
                                    id="pertanyaan" required>{{$datas->pertanyaan}}</textarea>
                            </div>
                            <script>
                                $(function () {


                                function fetch_customer_data(query = '') {
                                    $.ajax({
                                        url: "{{ route('api.fungsi.tingkatkesulitan') }}",
                                        method: 'GET',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            pertanyaan: pertanyaan,
                                        },
                                        dataType: 'json',
                                        success: function (data) {
                                            console.log(data.output);
                                            $('#tingkatkesulitan').val(data.output);
                                            $('#tingkatkesulitan').prop('class','form-control text-capitalize '+ data.warna);
                                        }
                                    })
                                }
                                // console.log( "ready!" );
                                $("#pertanyaan").keyup(function () {
                                    pertanyaan = $("#pertanyaan").val();

                                    data = $("textarea[name=pertanyaan]").val();
                                    // alert(data);
                                    var query = $(this).val();
                                    fetch_customer_data(query);
                                });
                                //    alert(pertanyaan);
                                });

                            </script>
                            {{-- <div class="form-group col-md-6 col-6">
                                <label for="nilai">nilai</label>
                                <input type="number" name="nilai" id="nilai"
                                    class="form-control @error('nilai') is-invalid @enderror" value="100"
                                    required min="0" max="100">
                                @error('nilai')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div> --}}
                            <div class="form-group col-md-6 col-6">
                                <label for="tingkatkesulitan">Tingkat Kesulitan</label>
                                <input type="text" name="tingkatkesulitan" id="tingkatkesulitan"
                                    class="form-control text-dark text-capitalize" value="{{$datas->tingkatkesulitan}}"
                                    required readonly >

                            </div>

                            <div class="form-group col-md-6 col-6">
                                <label for="kodegenerate">kodegenerate</label>
                                <input type="text" name="kodegenerate" id="kodegenerate"
                                    class="form-control @error('kodegenerate') is-invalid @enderror"
                                    value="{{$datas->kodegenerate}}" required readonly>
                                @error('kodegenerate')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
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
