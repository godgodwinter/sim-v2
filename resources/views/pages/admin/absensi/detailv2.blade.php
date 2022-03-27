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

                <div class="d-flex bd-highlight mb-0 align-items-center">


                    <div class="p-2 bd-highlight px-2">
                        <form action="{{ route('absensi.storev2',$kelas->id) }}" method="post" class="d-inline">
                            @csrf
                                <select class="js-example-basic-single form-control-sm @error('siswa_id')
                                is-invalid
                            @enderror" name="siswa_id"  style="width: 75%" required>
                                <option disabled selected value=""> Pilih Siswa</option>
                                @foreach ($siswas as $t)
                                    <option value="{{ $t->id }}"> {{ $t->nama }}</option>
                                @endforeach
                              </select>
                            </div>
                              <div class="p-2 bd-highlight">
                                  <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="tgl">
                            </div>
                              <div class="p-2 bd-highlight">
                                <div class="selectgroup w-100">
                                    {{-- <label class="selectgroup-item">
                                      <input type="radio" name="semester" value="Semua" class="selectgroup-input" >
                                      <span class="selectgroup-button">Semua</span>
                                    </label> --}}
                                    <label class="selectgroup-item">
                                      <input type="radio" name="nilai" value="Sakit" class="selectgroup-input" checked="">
                                      <span class="selectgroup-button">S</span>
                                    </label>
                                    <label class="selectgroup-item">
                                      <input type="radio" name="nilai" value="Ijin" class="selectgroup-input">
                                      <span class="selectgroup-button">I</span>
                                    </label>
                                    <label class="selectgroup-item">
                                      <input type="radio" name="nilai" value="Alpha" class="selectgroup-input">
                                      <span class="selectgroup-button">A</span>
                                    </label>

                                  </div>

                            </div>
                            <div class="p-2 bd-highlight">
                                <input type="text" class="form-control" value="{{old('ket')}}" placeholder="Keterangan" name="ket">
                          </div>
                              <div class="p-2 bd-highlight">

                                <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                    value="Simpan">

                        </div>
                         </form>

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
                            <th>Kelas</th>
                            <th>Tanggal tinggal masuk</th>
                            <th>S/I/A</th>
                            <th>Ket</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">
                                    {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
                                <td>
                                    {{$data->siswa!=null?Str::limit($data->siswa->nama,25,' ...'):'Data tidak ditemukan'}}
                                </td>
                                <td>
                                    {{ $data->siswa->kelas != null ? $data->siswa->kelas->tingkatan.' '.$data->siswa->kelas->jurusan.' '.$data->siswa->kelas->suffix : 'Data tidak ditemukan' }}
                                </td>
                                <td>
                                    {{Fungsi::tanggalindo($data->tgl)}}
                                </td>
                                <td>
                                    {{$data->nilai}}
                                </td>
                                <td>
                                    {{$data->ket ? Str::limit($data->ket,20) : '-'}}
                                </td>
                                <td class="babeng-min-row">
                                        <x-button-delete link="{{route('absensi.delete',[$kelas->id,$data->id])}}"></x-button-delete>
                                </td>
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
                {{-- <p>N.B : <i>Warna merah hari sabtu dan minggu</i>.</p> --}}
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
                  <form method="post" action="{{route('absensi.store',$kelas->id)}}" enctype="multipart/form-data">
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
