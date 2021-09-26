@section('title','Kompetensi Dasar')
@section('halaman')
<div class="breadcrumb-item"><a href="{{route('siakaddataajar')}}"   > Data ajar</a></div><div class="breadcrumb-item"> Kompetensi dasar</div>
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
    ->orderBy('tipe','desc')
    ->get();
    $jmlkd=DB::table('kompetensidasar')->where('kode',$data->kode)
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
                <td  rowspan="{{$jmlmateri+1}}">  {{ $kodetampil.$dkd->kode }} {{$dkd->nama}}</td>
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
                <a href="{{$materi->link}}" target="_blank" class="btn btn-info btn-sm"   data-toggle="tooltip" data-placement="top"  title="Materi untuk Siswa!"> Link Materi {{ $kodetampil.$dkd->kode }}.{{$loop->index+1}} </a>

                <a href="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}/materipokok/{{$materipokok}}/{{$kompetensidasar_kode}}/{{$kompetensidasar_tipe}}/inputnilai"  class="btn btn-success btn-sm"  data-toggle="tooltip" data-placement="top"  title="Nilai Siswa!"> <i class="fas fa-user-graduate"></i> </a>

                <a href="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}/materipokok/banksoal/{{$materipokok}}/{{$kompetensidasar_kode}}/{{$kompetensidasar_tipe}}"  class="btn btn-dark btn-sm"  data-toggle="tooltip" data-placement="top"  title="Bank Soal!"> <i class="far fa-file-archive"></i> </a>
                <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
                <x-button-delete link="/admin/kompetensidasar/materipokok/hapus/{{$materi->id}}" />
            </td>


            </td>
            </tr>
            <script>
                $(document).ready(function(){
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
<td  rowspan="1">  {{ $kodetampil.$dkd->kode }} {{$dkd->nama}}</td>
<td  rowspan="1">   Data Belum ada</td>
<td  rowspan="1">   - </td>
</tr>

<script>
    $(document).ready(function(){
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
            <x-layout-table2 pages="{{ $pages }}" pagination="" />
        </div>
        <div class="col-12 col-md-12 col-lg-4">
            <div class="card">
                <form action="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}" method="post">
                    @csrf
                    <div class="card-header">
                        <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH
                            {{ Str::upper($pages) }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12 col-12 mt-0">
                                <label for="nama">Pilih Tipe</label>

                                <select class="form-control form-control-sm" name="tipe">



                                    <option>Pengetahuan</option>
                                    <option>Ketrampilan</option>
                                </select>
                            </div>

                            <div class="form-group col-md-12 col-12">
                                <label for="nama">Nama</label>
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
                            <div class="form-group col-md-12 col-12">
                                <label for="kode">Kode</label>
                                <input type="number" min="1" name="kode" id="kode"
                                    class="form-control @error('kode') is-invalid @enderror" value="{{$kode}}" required>
                                @error('kode')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>


                        </div>


                        <div class="row">
                            <div class="form-group mb-0 col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            </div>

            <div class="col-12 col-md-12 col-lg-8">

            <div class="card">
                <form action="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}/materi" method="post">
                    @csrf
                    <div class="card-header">
                        <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH
                          MATERI</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12 col-12 mt-0">
                                <label for="nama">Pilih Kompetensi Dasar</label>


                                <select class="form-control form-control-sm" name="kompetensidasar_id">


                                    @foreach ($datas as $data)

                                @php
                                $datakd=DB::table('kompetensidasar')->where('kode',$data->kode)
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
                                <label for="nama">Nama</label>
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


                        <div class="row">
                            <div class="form-group mb-0 col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">


                                </div>
                            </div>
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
