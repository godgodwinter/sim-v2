@section('title')
Kompetensi Dasar - {{base64_decode($tapel_nama)}} - {{base64_decode($kelas_nama)}} - {{base64_decode($pelajaran_nama)}}
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


{{-- DATATABLE --}}
@section('headtable')
<th width="5px" class="text-center">
    <label for="chkCheckAll"> All</label></th>
<th width="20%"> Kompetensi Dasar </th>
<th> Materi </th>
<th width="25%" class="text-center">Aksi</th>
@endsection

@section('bodytable')
{{-- </table> --}}

@foreach ($datas as $data)
@php
$totalrow=0;
$no=$loop->index+1;
@endphp

@php
$datakd=DB::table('kompetensidasar')->where('kode',$data->kode)
->where('pelajaran_nama',$p_nama)
->where('kelas_nama',$k_nama)
->where('tapel_nama',$t_nama)
->orderBy('tipe','desc')
->get();
$jmlkd=DB::table('kompetensidasar')->where('kode',$data->kode)
->where('pelajaran_nama',$p_nama)
->where('kelas_nama',$k_nama)
->where('tapel_nama',$t_nama)
->orderBy('tipe','desc')
->count();
// dd($jmlkd);
@endphp
{{-- <table class="table table-bordered  table-dark table-md"> --}}
<tr id="trdata{{$data->id}}">
    <td rowspan="1" class="tddata">{{$loop->index+1}}</td>
</tr>
@foreach ($datakd as $dkd)
@php
if($dkd->tipe=='Pengetahuan'){
$kodetampil='3.';
}else{
$kodetampil='4.';
}
@endphp
{{-- {{$dkd->tipe}} --}}
@php
$jmlmateri=DB::table('materipokok')
->where('pelajaran_nama',$data->pelajaran_nama)
->where('kelas_nama',$data->kelas_nama)
->where('tapel_nama',$data->tapel_nama)
->where('kompetensidasar_nama',$dkd->nama)
->where('kompetensidasar_tipe',$dkd->tipe)
->where('kompetensidasar_kode',$dkd->kode)
->orderBy('created_at','asc')
->count();

$jmlmateriperkd=DB::table('materipokok')
->where('pelajaran_nama',$data->pelajaran_nama)
->where('kelas_nama',$data->kelas_nama)
->where('tapel_nama',$data->tapel_nama)
->where('kompetensidasar_kode',$dkd->kode)
->orderBy('created_at','asc')
->count();
@endphp
@if($jmlmateri>0)

@php
$ambilmateri=DB::table('materipokok')
->where('pelajaran_nama',$data->pelajaran_nama)
->where('kelas_nama',$data->kelas_nama)
->where('tapel_nama',$data->tapel_nama)
->where('kompetensidasar_nama',$dkd->nama)
->where('kompetensidasar_tipe',$dkd->tipe)
->where('kompetensidasar_kode',$dkd->kode)
->orderBy('created_at','asc')
->get();

$totalrow=$jmlkd+$jmlmateriperkd+1;
@endphp


<tr>
    <td rowspan="{{$jmlmateri+1}}" data-toggle="tooltip" data-placement="top" title=" {{$dkd->tipe}}">
        {{ $kodetampil.$dkd->kode }} {{$dkd->nama}}
        &nbsp;
        <a href="/admin/kompetensidasar/edit/{{$dkd->id}}" class="btn btn-icon btn-warning btn-sm ml-1"  data-toggle="tooltip" data-placement="top" title="Ubah data!"><i class="fas fa-edit"></i></a>
        &nbsp;
        <form action="/admin/kompetensidasar/hapus/{{$dkd->id}}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-icon btn-danger btn-sm"
                onclick="return  confirm('Anda yakin menghapus data ini? Y/N')" data-toggle="tooltip"
                data-placement="top" title="Hapus Data!"><span class="pcoded-micon"> <i
                        class="fas fa-trash"></i></span></button>
        </form>

    </td>
</tr>
@foreach ($ambilmateri as $materi)
<tr>
    <td>
        {{ $kodetampil.$dkd->kode }}.{{$loop->index+1}} {{ $materi->nama }}
    <td>
        @php
        $materipokok=base64_encode($materi->nama);
        $kompetensidasar_kode=base64_encode($dkd->kode);
        $kompetensidasar_tipe=base64_encode($dkd->tipe);
        @endphp
        <a href="{{$materi->link}}" target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip"
            data-placement="top" title="Materi untuk Siswa!"> Link Materi
            {{ $kodetampil.$dkd->kode }}.{{$loop->index+1}} </a>

        <a href="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}/materipokok/{{$materipokok}}/{{$kompetensidasar_kode}}/{{$kompetensidasar_tipe}}/inputnilai"
            class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Nilai Siswa!"> <i
                class="fas fa-user-graduate"></i> </a>

        <a href="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}/materipokok/banksoal/{{$materipokok}}/{{$kompetensidasar_kode}}/{{$kompetensidasar_tipe}}"
            class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Bank Soal!"> <i
                class="far fa-file-archive"></i> </a>
        <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
        <x-button-delete link="/admin/kompetensidasar/materipokok/hapus/{{$materi->id}}" />
    </td>


    </td>
</tr>
<script>
    $(document).ready(function () {
        $("#trdata{{$data->id}}").html('<td rowspan="{{$totalrow}}">{{$no}}</td>');
    });

</script>
@endforeach


@else
@php


$jmlmateriperkd=DB::table('materipokok')
->where('pelajaran_nama',$data->pelajaran_nama)
->where('kelas_nama',$data->kelas_nama)
->where('tapel_nama',$data->tapel_nama)
->where('kompetensidasar_kode',$dkd->kode)
->orderBy('created_at','asc')
->count();
$totalrow=$jmlkd+$jmlmateriperkd+1;
@endphp
<tr>
    <td rowspan="1" data-toggle="tooltip" data-placement="top" title=" {{$dkd->tipe}}">

        {{ $kodetampil.$dkd->kode }} {{$dkd->nama}}
        &nbsp;
        <a href="/admin/kompetensidasar/edit/{{$dkd->id}}" class="btn btn-icon btn-warning btn-sm ml-1"  data-toggle="tooltip" data-placement="top" title="Ubah data!"><i class="fas fa-edit"></i></a>
        &nbsp;
        <form action="/admin/kompetensidasar/hapus/{{$dkd->id}}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-icon btn-danger btn-sm"
                onclick="return  confirm('Anda yakin menghapus data ini? Y/N')" data-toggle="tooltip"
                data-placement="top" title="Hapus Data!"><span class="pcoded-micon"> <i
                        class="fas fa-trash"></i></span></button>
        </form>

    </td>
    <td rowspan="1"> Data Belum ada</td>
    <td rowspan="1"> - </td>
</tr>

<script>
    $(document).ready(function () {
        $("#trdata{{$data->id}}").html('<td rowspan="{{$totalrow}}">{{$no}}</td>');
    });

</script>
{{-- <h6> {{ $kodetampil.$dkd->kode }} . Data Belum ada
</h6> --}}
@endif

@endforeach
@endforeach
{{-- </table> --}}
@endsection

@section('foottable')
{{-- {{ $datas->links() }}
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><i class="far fa-file"></i> Halaman ke-{{ $datas->currentPage() }}</li>
        <li class="breadcrumb-item"><i class="fas fa-paste"></i> {{ $datas->total() }} Total Data</li>
        <li class="breadcrumb-item active" aria-current="page"><i class="far fa-copy"></i> {{ $datas->perPage() }} Data
            Perhalaman</li>
    </ol>
</nav> --}}
@endsection

{{-- DATATABLE-END --}}
@section('container')


<div class="section-body">
    <div class="row mt-sm-4">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="{{ asset("assets/") }}/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="form-group col-md-12 col-12 mt-1 text-right">

                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#add">
                                <i class="fas fa-plus-square"></i>
                                Tambah Kompetensi Dasar
                              </button>
                              <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#add2">
                                  <i class="fas fa-plus-square"></i>
                                  Tambah Materi
                                </button>
                          <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#importExcel"><i class="fas fa-upload"></i>
                            Import
                          </button>
                          <a href="/admin//export" type="submit" value="Import" class="btn btn-icon btn-primary btn-sm"><span
                                class="pcoded-micon"> <i class="fas fa-download"></i> Export </span></a>
                          </div>
                    </div>
                </div>
            {{-- @yield('datatable') --}}
            {{-- {{ dd($datas) }} --}}

                <div class="card-body -mt-5">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                        <tr>
                            @yield('headtable')
                        </tr>
                            @yield('bodytable')

                        </table>
                    </div>
                    <div class="card-footer text-right">
                            @yield('foottable')
                    </div>
                </div>

            </div>


        </div>


</div>
</div>
@endsection

@section('container-modals')

<!-- Import Excel -->
<div class="modal fade bd-example-modal-lg" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kompetensi Dasar</h5>
                </div>
                <div class="modal-body">

                    {{ csrf_field() }}

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12 mt-0">
                                <label for="nama">Pilih Tipe</label>

                                <select class="form-control form-control-sm" name="tipe" id="kd_tipe" required>


                                    <option disabled selected value="">Pilih</option>

                                    <option value="Pengetahuan">Pengetahuan </option>
                                    <option value="Ketrampilan">Ketrampilan</option>
                                </select>
                                <input type="hidden" name="tapel_nama" value="{{base64_decode($tapel_nama)}}">
                                <input type="hidden" name="kelas_nama" value="{{base64_decode($kelas_nama)}}">
                                <input type="hidden" name="pelajaran_nama" value="{{base64_decode($pelajaran_nama)}}">
                            </div>

                            <script>
                                $(document).ready(function () {
                                    function fetch_customer_data(tipe = '', kelas_nama = '', pelajaran_nama =
                                        '', tapel_nama = '') {
                                        $.ajax({
                                            url: "{{ route('api.fungsi.generate.kompetensidasar') }}",
                                            method: 'GET',
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                tipe: tipe,
                                                kelas_nama: kelas_nama,
                                                pelajaran_nama: pelajaran_nama,
                                                tapel_nama: tapel_nama,
                                            },
                                            dataType: 'json',
                                            success: function (data) {
                                                $('#kodegenerate').val(data.output);
                                                swal({
                                                    title: 'Kode Berhasil di muat',
                                                    text: '',
                                                    icon: 'success',
                                                    timer: 1000,
                                                    buttons: false,
                                                })
                                            }
                                        })
                                    }


                                    $('#kd_tipe').change(function () {
                                        var value = $(this).val();
                                        var kodeprefix = 3;
                                        if (value == 'Ketrampilan') {
                                            kodeprefix = 4;
                                        } else {
                                            kodeprefix = 3;
                                        }
                                        $('#kodeprefix').html('<b>' + kodeprefix + '.</b>');
                                        var kelas_nama = $("input[name=kelas_nama]").val();
                                        var pelajaran_nama = $("input[name=pelajaran_nama]").val();
                                        var tapel_nama = $("input[name=tapel_nama]").val();
                                        // alert(value);
                                        // tipe = $("input[name=tipe]").val();
                                        // console.log(kelas_nama);
                                        var tipe = $(this).val();
                                        fetch_customer_data(tipe, kelas_nama, pelajaran_nama,
                                            tapel_nama);


                                    });

                                });

                            </script>
                            <div class="form-group col-md-6 col-12">
                                <label for="nama">Judul</label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}"
                                    required>
                                @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>
                            {{-- {{dd($generate_kode)}} --}}
                            @if ($generate_kode==null)
                            @php
                            $kode=1;
                            @endphp
                            @else
                            @php
                            $kode=$generate_kode;
                            @endphp
                            @endif
                            {{-- <div class="form-group col-md-12 col-12">
                                <label for="kode">Kode</label>
                                <input type="number" min="1" name="kode" id="kodegenerate"
                                    class="form-control @error('kode') is-invalid @enderror" value="{{$kode}}"
                            required>
                            @error('kode')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div> --}}
                        <div class="form-group col-md-6 col-12">
                            <label>Kode</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="kodeprefix">
                                        <b>3.</b>
                                    </div>
                                </div>
                                <input type="number" min="1" name="kode" id="kodegenerate"
                                    class="form-control @error('kode') is-invalid @enderror" value="{{$kode}}" required>
                                @error('kode')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>


                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>

<!-- add materi -->
<div class="modal fade bd-example-modal-lg" id="add2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}/materi"
            method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Materi</h5>
                </div>
                <div class="modal-body">

                    {{ csrf_field() }}

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12 col-12 mt-0">
                                <label for="nama">Pilih Kompetensi Dasar</label>


                                <select class="form-control form-control-sm" name="kompetensidasar_id">


                                    @foreach ($datas as $data)

                                    @php
                                    $datakd=DB::table('kompetensidasar')->where('kode',$data->kode)
                                    ->where('pelajaran_nama',$p_nama)
                                    ->where('kelas_nama',$k_nama)
                                    ->where('tapel_nama',$t_nama)
                                    ->orderBy('tipe','desc')
                                    ->get();
                                    @endphp
                                    @foreach ($datakd as $dkd)
                                    @php
                                    if($dkd->tipe=='Pengetahuan'){
                                    $kodetampil='3.';
                                    }else{
                                    $kodetampil='4.';
                                    }
                                    $nama= Str::limit($dkd->nama, 30, ' (...)');
                                    @endphp

                                    <option value="{{$dkd->id}}"> {{ $kodetampil.$dkd->kode }} . {{$nama}}</option>
                                    @endforeach


                                    @endforeach
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


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>


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
