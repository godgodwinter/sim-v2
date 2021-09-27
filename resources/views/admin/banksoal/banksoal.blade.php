@section('title','Bank Soal')
@section('halaman')
<div class="breadcrumb-item"><a href="{{route('siakaddataajar')}}"> Data ajar</a></div>
<div class="breadcrumb-item"><a href="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}">
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
                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal"
                                data-target="#importExcel"><i class="fas fa-upload"></i>
                                Import
                            </button>
                            <a href="/admin/@yield('linkpages')/export" type="submit" value="Import"
                                class="btn btn-icon btn-primary btn-sm"><span class="pcoded-micon"> <i
                                        class="fas fa-download"></i> Export </span></a>

                                        <a href="{{route('moodle.generate.xmlget')}}" type="submit" value="Import"
                                            class="btn btn-icon btn-primary btn-sm"><span class="pcoded-micon"> <i
                                                    class="fas fa-download"></i> XML Example</span></a>

                                        <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal"
                                            data-target="#moodlegenerate"><i class="fas fa-upload"></i>
                                            Generate Ke Moodle
                                        </button>

                        </div>
                    </div>
                </div>
                <div class="card-body -mt-5">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <tr>
                                <th width="10px" class="text-center"> No </th>
                                <th> Pertanyaan </th>
                                <th width="15%" class="text-center" >Jumlah Pilihan </th>
                                {{-- <th> Nilai </th> --}}
                                <th width="15%" class="text-center">Tingkat Kesulitan </th>
                                <th width="15%" class="text-center"> Aksi </th>
                            </tr>

                                @foreach ($datas as $data)
                                 <tr>
                                <td>{{$loop->index+1}}</td>
                                <td class="text-capitalize">{{$data->pertanyaan}}</td>
                                @php
                                    $jml=DB::table('banksoal_jawaban')->where('kodegenerate',$data->kodegenerate)->count();
                                @endphp
                                <td class="text-center"> {{$jml}} </td>
                                {{-- <td> 0 </td> --}}
                                <td class="text-center text-capitalize"> {{$data->tingkatkesulitan}} </td>
                                <td class="text-center">

                                    <a href="/admin/banksoal/{{$data->id}}/detail"  class="btn btn-info btn-sm"  data-toggle="tooltip" data-placement="top"    title="Detail Bank Soal!"> <i class="fas fa-angle-double-right"></i> </a>
                                    <x-button-edit link="/admin/banksoal/{{$data->id}}" />
                                    <x-button-delete link="/admin/banksoal/{{$data->id}}" />

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
                    action="{{url('/admin/')}}/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}/materipokok/banksoal/{{$materipokok_nama}}/{{$kompetensidasar_kode}}/{{$kompetensidasar_tipe}}"
                    method="post">
                    @csrf
                    <div class="card-header">
                        <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH
                            MATERI</span>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-md-6 col-6">
                                <label for="nama">Pertanyaan</label> :
                                {{-- <label for="nama" class="text-dark" id="tingkatkesulitan">Tingkat kesulitan</label> --}}
                                <textarea class="form-control" style="min-width: 100%;height:100%;" name="pertanyaan"
                                    id="pertanyaan" required></textarea>
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
                                    class="form-control text-dark text-capitalize" value="mudah"
                                    required readonly >

                            </div>

                            <div class="form-group col-md-6 col-6">
                                <label for="kodegenerate">kodegenerate</label>
                                <input type="text" name="kodegenerate" id="kodegenerate"
                                    class="form-control @error('kodegenerate') is-invalid @enderror"
                                    value="{{$kodegenerate}}" required readonly>
                                @error('kodegenerate')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>


                        </div>

                        <div class="card-footer text-right">
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

<!-- moodle generate Excel -->
<div class="modal fade" id="moodlegenerate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('moodle.generate.xmlget_do') }}" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Moodle Generate Soal 2</h5>
                </div>
                <div class="modal-body">

                    {{ csrf_field() }}


                    <div class="form-group">
                        <label for="jumlahsoal">Jumlah Soal</label>
                        <input type="number" class="form-control" name="jumlahsoal" id="jumlahsoal" required="required" value="30" min="1">
                        <input type="hidden" class="form-control" name="pelajaran_nama" id="jumlahsoal" required="required" value="{{$pelajaran_nama}}">
                        <input type="hidden" class="form-control" name="kelas_nama" id="jumlahsoal" required="required" value="{{$kelas_nama}}">
                        <input type="hidden" class="form-control" name="tapel_nama" id="jumlahsoal" required="required" value="{{$tapel_nama}}">
                        <input type="hidden" class="form-control" name="materipokok_nama" id="jumlahsoal" required="required" value="{{$materipokok_nama}}">
                        <input type="hidden" class="form-control" name="kompetensidasar_kode" id="jumlahsoal" required="required" value="{{$kompetensidasar_kode}}">
                        <input type="hidden" class="form-control" name="kompetensidasar_tipe" id="jumlahsoal" required="required" value="{{$kompetensidasar_tipe}}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
