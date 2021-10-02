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
                            </tr>
                            <tr>
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
                                <td>{{$loop->index+1}}</td>
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
                                            <td class="text-center">
                                            <button class="btn btn-info btn-sm">{{$kodeprefix}}.{{$dkd->kode}}.{{$loop->index+1}}</button>
                                            </td>
                                            @endforeach
                                        @else
                                            <td class="text-center"> - </td>
                                        @endif
                                @endforeach
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
                    <h5 class="modal-title" id="exampleModalLabel">Moodle Generate Soal</h5>
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
