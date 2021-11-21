@extends('layouts.default')

@section('title')
Input Nilai {{$dataajar->mapel->nama}} - {{$dataajar->kelas->tingkatan}} {{$dataajar->kelas->jurusan}} {{$dataajar->kelas->suffix}}
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
            <div class="breadcrumb-item"><a href="{{route('penilaian')}}">Penilaian</a></div>
            <div class="breadcrumb-item">@yield('title')</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">

                <div class="d-flex bd-highlight mb-0 align-items-center">

                    <div class="ml-auto p-2 bd-highlight">
                        {{-- <div class="dropdown d-inline">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Import
                            </button>
                            <div class="dropdown-menu">
                                @forelse ($datakd as $dk)
                                    @php
                                        if($dk->tipe==1){
                                            $preffix='3.';
                                        }else{
                                            $preffix='4.';
                                        }
                                    @endphp
                                       @forelse ($dk->materipokok as $dm)
                                            <button class="dropdown-item has-icon"
                                            data-toggle="modal" data-target="#importExcel{{$dk->id}}_{{$dm->id}}"><i class="far fa-heart"></i> {{$dm->nama!=null? $preffix.$dk->kode.".".$loop->index+1 : ' - '}}</button>
                                        @empty
                                        @endforelse

                                @empty
                                @endforelse
                            </div>
                          </div> --}}
                          {{-- <div class="dropdown d-inline ">
                              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Export
                              </button>
                              <div class="dropdown-menu">
                            @forelse ($datakd as $dk)
                                @php
                                    if($dk->tipe==1){
                                        $preffix='3.';
                                    }else{
                                        $preffix='4.';
                                    }
                                    // dd($dataajar->kelas_id);
                                @endphp
                                   @forelse ($dk->materipokok as $dm)
                                        <a class="dropdown-item has-icon" href="{{route('penilaian.inputnilai.exportmateripokok',[$dataajar->id,$dm->id])}}"><i class="far fa-heart"></i> {{$dm->nama!=null? $preffix.$dk->kode.".".$loop->index+1 : ' - '}}</a>
                                    @empty
                                    @endforelse

                                    <a class="dropdown-item has-icon" href="{{route('penilaian.inputnilai.exportkd',[$dataajar->id,$dk->id])}}"><i class="far fa-heart"></i> KD {{$dk->kode!=null? $preffix.$dk->kode : ' - '}}</a>

                            @empty
                            @endforelse

                              </div>
                            </div> --}}

                    </div>


                </div>

                <x-jsmultidel link="{{route('mapel.multidel')}}" />

                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th width="8%" class="text-center py-2" rowspan="2"  style="vertical-align: middle;"> No</th>
                            <th rowspan="2"  style="vertical-align: middle;">Nama</th>
                            @forelse ($datakd as $dk)
                                @php
                                    if($dk->tipe==1){
                                        $preffix='3.';
                                    }else{
                                        $preffix='4.';
                                    }
                                @endphp
                            <th colspan="{{$dk->materipokok!=null?$dk->materipokok->count()+1:1}}"  class="text-center">KD {{$dk->kode!=null? $preffix.$dk->kode : ' - '}}</th>
                            @empty
                            <th>-</th>
                            @endforelse
                        </tr>
                        <tr style="background-color: #F1F1F1">
                            @forelse ($datakd as $dk)
                                @php
                                    if($dk->tipe==1){
                                        $preffix='3.';
                                    }else{
                                        $preffix='4.';
                                    }
                                @endphp
                               @forelse ($dk->materipokok as $dm)
                               {{-- {{dd($dk->materipokok->count())}} --}}
                                    <td class="text-center">{{$dm->nama!=null? $preffix.$dk->kode.".".$loop->index+1 : ' - '}}</td>
                                    @if($loop->index+1==$dk->materipokok->count())
                                    <td  class="text-center text-warning"><b>Avg {{$preffix.$dk->kode}}</b></td>
                                    @endif

                                @empty
                                    <td class="text-center"> - </td>
                                @endforelse

                            @empty
                                    <td> - </td>
                            @endforelse
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">
                                    {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
                                <td>
                                    {{$data->nama!=null ? $data->nomerinduk.' - '.$data->nama : 'Data tidak ditemukan' }}
                                </td>
                                @forelse ($datakd as $dk)
                                    @php
                                    // dd($mapel->kkm);
                                    $jmlnilai=0;
                                    $jml=0;
                                    $avg=0;
                                    // dd($dk->materipokok->avg('nilai'));
                                    // $avg=$dk->materipokok->avg('nilai');
                                        if($dk->tipe==1){
                                            $preffix='3.';
                                        }else{
                                            $preffix='4.';
                                        }
                                    @endphp
                                       @forelse ($dk->materipokok as $dm)
                                       @php
                                            $datasnilai=DB::table('inputnilai')->whereNull('deleted_at')->where('siswa_id',$data->id)->where('materipokok_id',$dm->id)->first();
                                            // dd($datasnilai->nilai);
                                            if($datasnilai!=null){
                                                $jml+=1;
                                                $jmlnilai+=$datasnilai->nilai;
                                                $avg=number_format(($jmlnilai/$jml),2);
                                            }
                                        @endphp

                                            <td class="text-center" id="td_{{$data->id}}_{{$dm->id}}">
                                                @php
                                                    if($datasnilai!=null){
                                                            if($datasnilai->nilai >= $mapel->kkm){
                                                                $warna='success';
                                                                $hasil=$datasnilai->nilai;
                                                                $icon='<i class="far fa-check-circle"></i>';
                                                            }else{
                                                                $warna='danger';
                                                                $hasil=$datasnilai->nilai;
                                                                $icon='<i class="far fa-times-circle"></i>';
                                                            }
                                                    }else{
                                                        $hasil='Belum diisi ';
                                                        $warna='dark';
                                                        $icon='';

                                                    }
                                                @endphp
                                                <div class="text-{{$warna}}">
                                                        {{$hasil}} {!!$icon!!}
                                                </div>
                                                {{-- {{$datasnilai!=null? $datasnilai->nilai : ' Belum diisi '}} --}}
                                            </td>
                                            @if($loop->index+1==$dk->materipokok->count())
                                            <td class="text-center">
                                                {{-- 0 --}}
                                            {{-- {{$dk->id}} --}}
                                            @php
                                                    if($avg >= $mapel->kkm){
                                                        $warna='success';
                                                        $icon='<i class="far fa-check-circle"></i> Tuntas';
                                                    }else{
                                                        $warna='danger';
                                                        $icon='<i class="far fa-times-circle"></i> Belum Tuntas';
                                                    }

                                        @endphp
                                        <div class="text-{{$warna}}">
                                                {{$avg}} {!!$icon!!}
                                        </div>
                                            {{-- {{$avg}} --}}
                                            </td>
                                            @endif

                                        @empty
                                            <td class="text-center"> - </td>
                                        @endforelse
                                @empty
                                        <td> - </td>
                                @endforelse
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
<div class="d-flex justify-content-between flex-row-reverse mt-3">
    <div >
{{ $datas->onEachSide(1)
  ->links() }}
    </div>
    <div>

    </div>

            </div>
        </div>
    </div>
</section>
@endsection


@section('containermodal')

@forelse ($datakd as $dk)
@php
    if($dk->tipe==1){
        $preffix='3.';
    }else{
        $preffix='4.';
    }
@endphp
   @forelse ($dk->materipokok as $dm)

    <!-- Import Excel -->
    <div class="modal fade" id="importExcel{{$dk->id}}_{{$dm->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form method="post" action="{{ route('penilaian.inpunilai.importnilaipermateri',[$dataajar->id,$dm->id]) }}" enctype="multipart/form-data">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Nilai Siswa {{Fungsi::ambilkdmateripokok($dm->id,$dataajar->id)}}</h5>
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


    @empty
    @endforelse

@empty
@endforelse

@endsection
