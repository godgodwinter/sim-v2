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
            {{-- <div class="breadcrumb-item"><a href="#">Layout</a></div> --}}
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
                                 <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="tambah"
                                 value="Tambah">
                                 @push('after-style')
                                 <script>

                                     $(function () {
                                        $('#tambah').click(function (e) {
                                            e.preventDefault();
                                                // alert('tambah');
                                                let form2=`
                                                        <div class="form-group col-md-8 col-12 mt-0 ml-5" >
                                                            <select class="js-example-basic-single form-control-sm @error('walikelas_id')
                                                            is-invalid
                                                        @enderror" name="walikelas_id"  style="width: 75%" required>
                                                            <option disabled selected value=""> Pilih Siswa</option>
                                                                <option value="tes">tes</option>
                                                        </select>
                                                        </div>`;
                                                let formtambah=`<x-form-pelanggaran-tambah/>`;
                                                $('#contentmain').html(formtambah);
                                                selectRefresh();
                                        });

                                        function selectRefresh() {
                                            $('#contentmain .js-example-basic-single').select2({
                                                //-^^^^^^^^--- update here
                                                tags: true,
                                                placeholder: "Pilih Siswa",
                                                allowClear: true,
                                                width: '100%'
                                            });
                                            }

                                     });
                                 </script>

                                 @endpush

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
                                        <button  type="button" class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat Pelanggaran Siswa!" id="btnpelanggaran{{$data->id}}">
                                            <i class="fas fa-id-card-alt"></i>
                                        </button>

                                 @push('after-style')
                                 <script>

                                     $(function () {
                                        $('#btnpelanggaran{{$data->id}}').click(function (e) {
                                            e.preventDefault();
                                                // alert('tambah');
                                                let form2=`
                                                        <div class="form-group col-md-8 col-12 mt-0 ml-5" >
                                                            <select class="js-example-basic-single form-control-sm @error('walikelas_id')
                                                            is-invalid
                                                        @enderror" name="walikelas_id"  style="width: 75%" required>
                                                            <option disabled selected value=""> Pilih Siswa</option>
                                                                <option value="{{$data->id}}" selected>{{$data->nama}}</option>
                                                        </select>
                                                        </div>`;
                                                $('#contentmain').html(form2);
                                                selectRefresh();
                                        });

                                        function selectRefresh() {
                                            $('#contentmain .js-example-basic-single').select2({
                                                //-^^^^^^^^--- update here
                                                tags: true,
                                                placeholder: "Pilih Siswa",
                                                allowClear: true,
                                                width: '100%'
                                            });
                                            }

                                     });
                                 </script>

                                 @endpush

                                        </td>
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

                        <x-form-pelanggaran-tambah/>



                    </div>
                </div>
            </div>


        </div>
    </div>



</section>
@endsection

