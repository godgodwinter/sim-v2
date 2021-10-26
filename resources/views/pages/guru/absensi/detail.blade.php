@extends('layouts.default')

@section('title')
Absensi {{$kelas->tingkatan}} {{$kelas->jurusan}} {{$kelas->suffix}}
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
            <div class="breadcrumb-item"><a href="{{route('absensi')}}">Absensi</a></div>
            <div class="breadcrumb-item">@yield('title')</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body" >

                <div id="babeng-bar" class="text-center mt-2">

                    <div id="babeng-row ">

                        <form action="{{ route('siswa.cari') }}" method="GET">
                            <input type="text" class="babeng babeng-select  ml-0" name="cari" autocomplete="off">

                            <span>
                                <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                    value="Cari">
                            </span>

                         </form>

                    </div>
                </div>
                <div class="row" id="babengcardDate" >

                    <x-jsmultidel link="{{route('siswa.multidel')}}" />

                @if($datas->count()>0)
                    {{-- <x-jsdatatable/> --}}
                    <script>
                        $(document).ready(function() {
                            $('#example').DataTable({
                                paging: false,
                                info: false,
                                searching: false,
                                columnDefs: [
                                    { orderable: false, targets: [
                                    @foreach ($dates as $d)
                                        {{$loop->index+2}},
                                    @endforeach
                                    ]
                                 }
                                ]
                            });
                        } );
                    </script>

                @endif

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%" >
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th width="8%" class="text-center py-2">
                                No</th>
                            <th >Nama</th>
                            @foreach ($dates as $d)
                        @php
                            $i=$loop->index;
                            $tgl=$dates[$i]->format('d');
                            $tgl2=$dates[$i]->format('Y-m-d');
                            $isWeekend=Fungsi::isWeekend($tgl2);
                            if($isWeekend!==false){
                                $warna='danger';
                            }else{
                                $warna='dark';
                            }
                        @endphp

                                    <th class="text-center text-{{$warna}} px-2" >
                                       {{$tgl}}
                                    </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">
                                    {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
                                <td>
                                    {{Str::limit($data->nama,25,' ...')}}
                                </td>

                    @foreach ($dates as $d)
                            @php
                                $i=$loop->index;
                                  $tgl=$dates[$i]->format('Y-m-d');

                                  $tgl2=$dates[$i]->format('d');
                                  $isWeekend=Fungsi::isWeekend($tgl);
                                //   dd(Fungsi::isWeekend($tgl));
                                  $ket='-';
                                  $ambildata=DB::table('absensi')->where('siswa_id',$data->id)->where('tgl',$tgl)->first();
                                  if($ambildata!=null){
                                      $ket=$ambildata->ket;
                                  }

                            if($isWeekend!==false){
                                $warna='danger';
                                $style="background-color: rgba(210, 77, 87, 0.8)";
                                $target='#';
                            }else{
                                $warna='dark';
                                $target='modal';
                                $style='';
                            }
                            @endphp
                            <td class="text-center text-{{$warna}}" data-toggle="{{$target}}" data-target="#modal{{$data->id}}-{{$tgl}}" style="{{$style}}">
                               @if ($isWeekend==false)
                                    {{Str::limit($ket,1,'')}}
                                    @else

                               @endif
                            </td>
                    @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
            <div class="d-flex justify-content-between mt-3">
                <div>
                    @php
                    $cari=$request->cari;
                    @endphp
                    {{ $datas->onEachSide(1)
                      ->links() }}
                </div>

              <div>
                <p>N.B : <i>Warna merah hari sabtu dan minggu</i>.</p>
              </div>
                                </div>

            </div>



        </div>
    </div>
</section>
@endsection


@section('containermodal')
              {{-- modal absensi --}}
              @foreach ($datas as $data)
                  @foreach ($dates as $d)

                              @php
                                  $i=$loop->index;
                                  $tgl=$dates[$i]->format('Y-m-d');
                                  $tgl2=$dates[$i]->format('d');
                              @endphp

              <div class="modal fade" id="modal{{$data->id}}-{{$tgl}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{route('guru.absensi.store',$kelas->id)}}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> {{$data->nama}} - {{Fungsi::tanggalindo($tgl)}}</h5>
                      </div>
                      <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group col-md-12 col-12 mt-0">
                            <label for="nama">Pilih Absensi </label>
                        <input type="hidden" name="siswa_id" value="{{$data->id}}">
                        <input type="hidden" name="tgl" value="{{$tgl}}">
                        <select class="form-control form-control-sm" name="ket">
                            <option selected>-</option>
                            <option>Ijin</option>
                            <option>Sakit</option>
                            <option>Tanpa Keterangan</option>


                        </select>
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

              @endforeach

@endsection
