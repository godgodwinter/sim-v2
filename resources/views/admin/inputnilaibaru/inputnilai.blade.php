@section('title')
Input Nilai {{$p_nama}} - Kelas {{$k_nama}}
@endsection
@section('halaman')
<div class="breadcrumb-item"><a href="{{route('siakaddataajar')}}"> Data ajar</a></div>
<div class="breadcrumb-item"><a href="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}">
        Kompetensi dasar</a></div>
<div class="breadcrumb-item">Input nilai</div>
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

                                        {{-- <a href="{{route('moodle.generate.xmlget')}}" type="submit" value="Import"
                                            class="btn btn-icon btn-primary btn-sm"><span class="pcoded-micon"> <i
                                                    class="fas fa-download"></i> XML Example</span></a> --}}


                        </div>
                    </div>
                </div>
                <div class="card-body -mt-5">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md" >

                            <tr>
                                <th width="10px" class="text-center" rowspan="2" style="vertical-align: middle;"> No  </th>
                                <th width="10px" class="text-center" rowspan="2" style="vertical-align: middle;"> Nama </th>
                                @foreach ($datakd as $dkd)
                                @php

                                $jmldatamateri=DB::table('materipokok')
                                ->where('kelas_nama',$k_nama)
                                ->where('tapel_nama',$t_nama)
                                ->where('pelajaran_nama',$p_nama)
                                ->where('kompetensidasar_nama',$dkd->nama)
                                ->where('kompetensidasar_kode',$dkd->kode)
                                ->orderBy('created_at','asc')
                                // ->orderBy('tipe','desc')
                                ->count();

                                if($dkd->tipe=='Pengetahuan'){
                                    $kodeprefix=3;
                                }else{
                                    $kodeprefix=4;
                                }
                                @endphp
                                <th class="text-center" colspan="{{$jmldatamateri}}">{{$kodeprefix}}.{{$dkd->kode}} </th>

                                @endforeach

                                <th width="10px" class="text-center" rowspan="2" style="vertical-align: middle;"> Avg P (3.)</th>
                                <th width="10px" class="text-center" rowspan="2" style="vertical-align: middle;"> Avg K (4.)</th>
                            </tr>
                            <tr >
                                @foreach ($datakd as $dkd)
                                        @php

                                            $jmldatamateri=DB::table('materipokok')
                                            ->where('kelas_nama',$k_nama)
                                            ->where('tapel_nama',$t_nama)
                                            ->where('pelajaran_nama',$p_nama)
                                            ->where('kompetensidasar_nama',$dkd->nama)
                                            ->where('kompetensidasar_kode',$dkd->kode)
                                            ->orderBy('created_at','asc')
                                            // ->orderBy('tipe','desc')
                                            ->count();

                                            $datamateri=DB::table('materipokok')
                                            ->where('kelas_nama',$k_nama)
                                            ->where('tapel_nama',$t_nama)
                                            ->where('pelajaran_nama',$p_nama)
                                            ->where('kompetensidasar_nama',$dkd->nama)
                                            ->where('kompetensidasar_kode',$dkd->kode)
                                            ->orderBy('created_at','asc')
                                            // ->orderBy('tipe','desc')
                                            ->get();

                                if($dkd->tipe=='Pengetahuan'){
                                    $kodeprefix=3;
                                }else{
                                    $kodeprefix=4;
                                }

                                        @endphp
                                        @if ($jmldatamateri>0)
                                            @foreach ($datamateri as $dm)
                                            <td class="text-center"> {{$kodeprefix}}.{{$dkd->kode}}.{{$loop->index+1}} </td>
                                            @endforeach
                                        @else
                                            <td class="text-center"> - </td>
                                        @endif
                                @endforeach
                            </tr>

                                @foreach ($datasiswa as $data)
                                 <tr>
                                <td  style="vertical-align: middle;" class="text-center">{{$loop->index+1}}</td>
                                <td class="text-capitalize">{{$data->nama}}</td>

                                @foreach ($datakd as $dkd)
                                        @php

                                            $jmldatamateri=DB::table('materipokok')
                                            ->where('kelas_nama',$k_nama)
                                            ->where('tapel_nama',$t_nama)
                                            ->where('pelajaran_nama',$p_nama)
                                            ->where('kompetensidasar_nama',$dkd->nama)
                                            ->where('kompetensidasar_kode',$dkd->kode)
                                            ->orderBy('created_at','asc')
                                            // ->orderBy('tipe','desc')
                                            ->count();

                                            $datamateri=DB::table('materipokok')
                                            ->where('kelas_nama',$k_nama)
                                            ->where('tapel_nama',$t_nama)
                                            ->where('pelajaran_nama',$p_nama)
                                            ->where('kompetensidasar_nama',$dkd->nama)
                                            ->where('kompetensidasar_kode',$dkd->kode)
                                            ->orderBy('created_at','asc')
                                            // ->orderBy('tipe','desc')
                                            ->get();

                                if($dkd->tipe=='Pengetahuan'){
                                    $kodeprefix=3;
                                }else{
                                    $kodeprefix=4;
                                }

                                        @endphp
                                        @if ($jmldatamateri>0)
                                            @foreach ($datamateri as $dm)

                                            @php
                                            $cek=DB::table('nilaipelajaran')
                                                    ->where('siswa_nis',$data->nis)
                                                    ->where('materipokok_nama',$dm->nama)
                                                    ->where('kompetensidasar_kode',$dkd->kode)
                                                    ->where('kompetensidasar_tipe',$dkd->tipe)
                                                    ->where('pelajaran_nama',$p_nama)
                                                    ->where('kelas_nama',$k_nama)
                                                    ->where('tapel_nama',$t_nama)
                                                    ->count();

                                                $tampilkan='belum diisi';
                                                if($cek>0){

                                                    $ambil=DB::table('nilaipelajaran')
                                                            ->where('siswa_nis',$data->nis)
                                                            ->where('materipokok_nama',$dm->nama)
                                                            ->where('kompetensidasar_kode',$dkd->kode)
                                                            ->where('kompetensidasar_tipe',$dkd->tipe)
                                                            ->where('pelajaran_nama',$p_nama)
                                                            ->where('kelas_nama',$k_nama)
                                                            ->where('tapel_nama',$t_nama)
                                                            ->first();
                                                    $tampilkan=$ambil->nilai;
                                                }
                                            @endphp
                                            <td class="text-center"  style="vertical-align: middle;">

                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modalinput{{$kodeprefix}}_{{$dkd->kode}}_{{$loop->index+1}}_{{$data->nis}}">
                                                {{-- {{$kodeprefix}}.{{$dkd->kode}}.{{$loop->index+1}} --}}
                                                {{$tampilkan}}
                                            </button>
                                            </td>
                                            @endforeach
                                        @else
                                            <td class="text-center"> - </td>
                                        @endif
                                @endforeach
                                <td  style="vertical-align: middle;" class="text-center">
                                    @php

                                        $ambiljmlnilai=DB::table('nilaipelajaran')
                                                            ->where('siswa_nis',$data->nis)
                                                            ->where('kompetensidasar_tipe','Pengetahuan')
                                                            ->where('pelajaran_nama',$p_nama)
                                                            ->where('kelas_nama',$k_nama)
                                                            ->where('tapel_nama',$t_nama)
                                                            ->sum('nilai');

                                        $ambiljmldatanilai=DB::table('nilaipelajaran')
                                                            ->where('siswa_nis',$data->nis)
                                                            ->where('kompetensidasar_tipe','Pengetahuan')
                                                            ->where('pelajaran_nama',$p_nama)
                                                            ->where('kelas_nama',$k_nama)
                                                            ->where('tapel_nama',$t_nama)
                                                            ->count();

                                        $hasil=0;
                                        if($ambiljmldatanilai>0){
                                            $hasil=number_format(($ambiljmlnilai/$ambiljmldatanilai),2);
                                        }
                                    @endphp
                                    {{$hasil}}

                                </td>
                                <td  style="vertical-align: middle;" class="text-center">
                                    @php

                                        $ambiljmlnilai=DB::table('nilaipelajaran')
                                                            ->where('siswa_nis',$data->nis)
                                                            ->where('kompetensidasar_tipe','Ketrampilan')
                                                            ->where('pelajaran_nama',$p_nama)
                                                            ->where('kelas_nama',$k_nama)
                                                            ->where('tapel_nama',$t_nama)
                                                            ->sum('nilai');

                                        $ambiljmldatanilai=DB::table('nilaipelajaran')
                                                            ->where('siswa_nis',$data->nis)
                                                            ->where('kompetensidasar_tipe','Ketrampilan')
                                                            ->where('pelajaran_nama',$p_nama)
                                                            ->where('kelas_nama',$k_nama)
                                                            ->where('tapel_nama',$t_nama)
                                                            ->count();
                                        $hasil=0;
                                        if($ambiljmldatanilai>0){
                                            $hasil=number_format(($ambiljmlnilai/$ambiljmldatanilai),2);
                                        }
                                    @endphp
                                    {{$hasil}}
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
</div>
@endsection

@section('container-modals')


@foreach ($datasiswa as $data)
@foreach ($datakd as $dkd)
       @php

           $jmldatamateri=DB::table('materipokok')
           ->where('kelas_nama',$k_nama)
           ->where('tapel_nama',$t_nama)
           ->where('pelajaran_nama',$p_nama)
           ->where('kompetensidasar_nama',$dkd->nama)
           ->where('kompetensidasar_kode',$dkd->kode)
           ->orderBy('created_at','asc')
           // ->orderBy('tipe','desc')
           ->count();

           $datamateri=DB::table('materipokok')
           ->where('kelas_nama',$k_nama)
           ->where('tapel_nama',$t_nama)
           ->where('pelajaran_nama',$p_nama)
           ->where('kompetensidasar_nama',$dkd->nama)
           ->where('kompetensidasar_kode',$dkd->kode)
           ->orderBy('created_at','asc')
           // ->orderBy('tipe','desc')
           ->get();

if($dkd->tipe=='Pengetahuan'){
   $kodeprefix=3;
}else{
   $kodeprefix=4;
}

       @endphp
       @if ($jmldatamateri>0)
           @foreach ($datamateri as $dm)

                            @php
                            $cek=DB::table('nilaipelajaran')
                                    ->where('siswa_nis',$data->nis)
                                    ->where('materipokok_nama',$dm->nama)
                                    ->where('kompetensidasar_kode',$dkd->kode)
                                    ->where('kompetensidasar_tipe',$dkd->tipe)
                                    ->where('pelajaran_nama',$p_nama)
                                    ->where('kelas_nama',$k_nama)
                                    ->where('tapel_nama',$t_nama)
                                    ->count();

                                $tampilkan='belum diisi';
                                $nilaiawal=75;
                                if($cek>0){

                                    $ambil=DB::table('nilaipelajaran')
                                            ->where('siswa_nis',$data->nis)
                                            ->where('materipokok_nama',$dm->nama)
                                            ->where('kompetensidasar_kode',$dkd->kode)
                                            ->where('kompetensidasar_tipe',$dkd->tipe)
                                            ->where('pelajaran_nama',$p_nama)
                                            ->where('kelas_nama',$k_nama)
                                            ->where('tapel_nama',$t_nama)
                                            ->first();
                                    $tampilkan=$ambil->nilai;
                                    $nilaiawal=$ambil->nilai;
                                }
                            @endphp


                    <div class="modal fade" id="modalinput{{$kodeprefix}}_{{$dkd->kode}}_{{$loop->index+1}}_{{$data->nis}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form method="post" action="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}/materipokok/inputnilai/{{$materipokok_nama}}/{{$kompetensidasar_kode}}/{{$kompetensidasar_tipe}}" >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Data {{$kodeprefix}}_{{$dkd->kode}}_{{$loop->index+1}}</h5>
                                </div>
                                <div class="modal-body">

                                    {{ csrf_field() }}

                                    <label>Nilai</label>
                                    <div class="form-group">
                                        <input type="hidden" name="materipokok_nama" id="materipokok_nama" value="{{$dm->nama}}">
                                        <input type="hidden" name="kompetensidasar_kode" id="kompetensidasar_kode" value="{{$dkd->kode}}">
                                        <input type="hidden" name="kompetensidasar_tipe" id="kompetensidasar_tipe" value="{{$dkd->tipe}}">
                                        <input type="hidden" name="siswa_nama" id="siswa_nama" value="{{$data->nama}}">
                                        <input type="hidden" name="siswa_nis" id="siswa_nis" value="{{$data->nis}}">
                                        <input type="number" name="nilai" required="required" max="100" min="1" class="form-control" value="{{$nilaiawal}}">
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



           @endforeach
       @else

       @endif
@endforeach
@endforeach

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
