@extends('layouts.default')

@section('title')
Pelanggaran
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
            <div class="breadcrumb-item"><a href="{{route('pelanggaran')}}">Pelanggaran</a></div>
            <div class="breadcrumb-item">@yield('title')</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-5 col-lg-5">

            <div class="section-body">
                <div class="card">
                    <div class="card-body" >

                        <div id="babeng-bar" class="text-center mt-2">

                            <div id="babeng-row ">

                                <form action="{{ route('siswa.cari') }}" method="GET" class="d-inline">
                                    <input type="text" class="babeng babeng-select  ml-0" name="cari">

                                    <span>
                                        <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                            value="Cari">
                                    </span>

                                 </form>

                                 <a href="{{route('pelanggaran.detail',$kelas->id)}}" type="submit" value="Import"
                                 class="btn btn-icon btn-primary btn-sm ml-2"><span class="pcoded-micon"> <i
                                         class="fas fa-download"></i> Tambah </span></a> </form>


                            </div>
                        </div>

                            <x-jsmultidel link="{{route('siswa.multidel')}}" />

                        @if($datas->count()>0)
                            <x-jsdatatable/>
                        @endif

                        <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%" >
                            <thead>
                                <tr style="background-color: #F1F1F1">
                                    <th width="8%" class="text-center py-2">
                                        No</th>
                                    <th >Nama Siswa</th>
                                    <th class="text-center" width="18%">Total</th>
                                    <th class="text-center" width="8%">Aksi</th>
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
                                        <td class="text-center">{{$data->pelanggaran!=null ? $data->pelanggaran->count() : '0'}} </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat Pelanggaran Siswa!" id="lihat{{$data->id}}">
                                            <i class="fas fa-id-card-alt"></i>
                                        </button>

                                        </td>
                                    </tr>
                                    @push('before-script')
                                        <script>
                                            $(function () {
                                                $('#lihat{{$data->id}}').click(function (e) {
                                                    e.preventDefault();
                                                    let detailsiswa=`

                        <div class="card-header">
                            <h5>{{$data->nama}}</h5>
                        </div>
                        <div class="row">
                        <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%" >
                            <thead>
                                <tr style="background-color: #F1F1F1">
                                    <th width="8%" class="text-center py-2">
                                        No</th>
                                    <th> Pelanggaran</th>
                                    <th class="text-center" width="18%">Skor</th>
                                    <th class="text-center" width="8%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                              `;

                                        @foreach($data->pelanggaran as $p)
                                            detailsiswa+=`
                                            <tr>
                                                <td class="text-center" >{{$loop->index+1}}</td>
                                                <td>{{$p->nama}}</td>
                                                <td class="text-center" >{{$p->skor}}</td>
                                                <td class="text-center" >
                                                    <x-button-delete link="/admin/{{ $pages }}/{{$data->id}}" />
                                                </td>
                                            </tr>
                                                `;
                                        @endforeach

                                detailsiswa+=`
                            </tbody>
                            </table>
                        </div>

                                                    `;
                                                        $('#contentmain').html(detailsiswa);

                                                });
                                            });
                                        </script>
                                    @endpush
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
        {{ $datas->onEachSide(1)
          ->links() }}
                    </div>
                </div>
            </div>


        </div>
        <div class="col-12 col-md-7 col-lg-7">


            <div class="section-body">
                <div class="card">
                    <div class="card-body" id="contentmain">

                        <div class="card-header">
                            <h5>Tambah Pelanggaran</h5>
                        </div>
                        <form action="{{route('pelanggaran.store',$kelas->id)}}" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-2 col-12 mt-0 ml-5">
                                <label class="form-label">Pilih Siswa</label>
                            </div>
                            <div class="form-group col-md-8 col-12 mt-0 ml-5" >
                                <select class="js-example-basic-single form-control-sm @error('siswa_id')
                                is-invalid
                            @enderror" name="siswa_id"  style="width: 75%" required>
                                <option disabled selected value=""> Pilih Siswa</option>
                                @foreach ($datas as $t)
                                    <option value="{{ $t->id }}"> {{ $t->nama }}</option>
                                @endforeach
                              </select>
                              </div>
                              @push('before-script')
                              @endpush


                            <div class="form-group col-md-2 col-12 mt-0 ml-5">
                                <label class="form-label">Nama Pelanggaran</label>
                            </div>
                            <div class="form-group col-md-8 col-12 mt-0 ml-5" >
                                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama') ? old('nama') : ''}}" required>
                                @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                              </div>


                            <div class="form-group col-md-2 col-12 mt-0 ml-5">
                                <label class="form-label">Skor Pelanggaran</label>
                            </div>
                            <div class="form-group col-md-8 col-12 mt-0 ml-5" >
                                <input type="number" name="skor" id="skor" class="form-control @error('skor') is-invalid @enderror" value="{{old('skor') ? old('skor') : '1'}}" required min="0" max="100">
                                @error('skor')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                              </div>
                            <div class="form-group col-md-2 col-12 mt-0 ml-5">
                                <label class="form-label">Tanggal Pelanggaran</label>
                            </div>
                            <div class="form-group col-md-8 col-12 mt-0 ml-5" >
                                    <input type="date" name="tgl" id="tgl" class="form-control @error('tgl') is-invalid @enderror" value="{{old('tgl')? old('tgl') : date('Y-m-d')}}" required>
                                    @error('tgl')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                              </div>

                        </div>

                    <div class="card-footer text-right mr-5">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
                    </div>
                </div>
            </div>


        </div>
    </div>



</section>
@endsection

