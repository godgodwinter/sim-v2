@section('title')
Input Nilai {{$pelajaran_nama}} - Kelas {{$kelas_nama}}
@endsection
@section('halaman')
<div class="breadcrumb-item"><a href="{{route('siakaddataajar')}}"> Data ajar</a></div>
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


    {{-- <a href="" id="scroll" >
        <div class="rounded-circle" id="scrollTop" data-toggle="tooltip" data-placement="top"    title="Simpan Terpilih!">
            <i class="fas fa-share-square" id="arrow" ></i>
        </div>
   </a> --}}
<i class="fa fa-arrow-up" aria-hidden="true" style="color: black;" id="arrow" ></i>

{{-- <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-home"></i><span>Beranda</span></a> --}}
   <script>
   $( "#scroll" ).click(function(e) {
    // alert( "Handler for .click() called." );
          e.preventDefault();
          var allids=[];
          var nilaimulti=$("#nilaimulti").val();
              $("input:checkbox[name=ids]:checked").each(function(){
                  allids.push($(this).val());


              });
              if(allids==''){
                  alert('Pilih data dahulu!');

              }else{
            fetch_customer_data(allids);


              alert('berhasil diubah!');
              }



              function fetch_customer_data(query = '') {
                                    $.ajax({
                                        url: "{{ route('api.inputnilai.multiinput') }}",
                                        method: 'GET',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            ids:allids,
                                            nilaimulti:nilaimulti
                                        },
                                        dataType: 'json',
                                        success: function (data) {
                                            $("#datasiswa").html(data.output);
                                            // console.log(data.output);
                                            // console.log(data.datas);
                                        }
                                    })
                                }


    return false;
  });

</script>

    <div class="row mt-sm-4">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card ">
                        <div class="form-group offset-md-8 col-md-4 col-12 mt-1  ">
                                <div class="row">
                                    {{-- <div class="col-md-4 col-12 mt-2 text-right">
                                        <label for="nilaimulti">Nilai :</label>

                                    </div>

                                    <div class="col-md-8 col-12">
                                        <input type="number" name="nilaimulti" id="nilaimulti" value="75" min="1" max="100" class="form-control btn btn-outline-primary">
                                    </div> --}}
                                </div>

                            {{-- <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal"
                                data-target="#importExcel"><i class="fas fa-upload"></i>
                                Import
                            </button>
                            <a href="/admin/@yield('linkpages')/export" type="submit" value="Import"
                                class="btn btn-icon btn-primary btn-sm"><span class="pcoded-micon"> <i
                                        class="fas fa-download"></i> Export </span></a> --}}

                                        {{-- <a href="{{route('moodle.generate.xmlget')}}" type="submit" value="Import"
                                            class="btn btn-icon btn-primary btn-sm"><span class="pcoded-micon"> <i
                                                    class="fas fa-download"></i> XML Example</span></a> --}}



                </div>
                <div class="card-body -mt-5">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" >

                            <tr style="background-color: #f9f9f9">
                                <th width="10px" class="text-center" rowspan="2" style="vertical-align: middle;"> No  </th>
                                <th  class="text-center" rowspan="2" style="vertical-align: middle;"> Nama </th>
                                @foreach ($datakd as $dkd)
                                @php

                                $jmldatamateri=DB::table('materipokok')
                                ->where('kelas_nama',$kelas_nama)
                                ->where('tapel_nama',$tapel_nama)
                                ->where('pelajaran_nama',$pelajaran_nama)
                                            ->where('kompetensidasar_kode',$dkd->kode)
                                            ->where('kompetensidasar_nama',$dkd->nama)
                                            ->where('kompetensidasar_tipe',$dkd->tipe)
                                ->orderBy('created_at','asc')
                                // ->orderBy('tipe','desc')
                                ->count();

                                if($dkd->tipe=='Pengetahuan'){
                                    $kodeprefix=3;
                                }else{
                                    $kodeprefix=4;
                                }
                                @endphp
                                <th class="text-center" colspan="{{$jmldatamateri}}">
                                    {{$kodeprefix}}.{{$dkd->kode}}
                                </th>

                                @endforeach

                                <th width="10px" class="text-center" rowspan="2" style="vertical-align: middle;"> Avg P (3.)</th>
                                <th width="10px" class="text-center" rowspan="2" style="vertical-align: middle;"> Avg K (4.)</th>
                            </tr>
                            <tr >
                                @foreach ($datakd as $dkd)
                                        @php
                                         $jmldatamateri=DB::table('materipokok')
                                            ->where('kelas_nama',$kelas_nama)
                                            ->where('tapel_nama',$tapel_nama)
                                            ->where('pelajaran_nama',$pelajaran_nama)
                                            ->where('kompetensidasar_kode',$dkd->kode)
                                            ->where('kompetensidasar_nama',$dkd->nama)
                                            ->where('kompetensidasar_tipe',$dkd->tipe)

                                            ->orderBy('created_at','asc')
                                            // ->orderBy('tipe','desc')
                                            ->count();

                                            $datamateri=DB::table('materipokok')
                                            ->where('kelas_nama',$kelas_nama)
                                            ->where('tapel_nama',$tapel_nama)
                                            ->where('pelajaran_nama',$pelajaran_nama)
                                            ->where('kompetensidasar_kode',$dkd->kode)
                                            ->where('kompetensidasar_nama',$dkd->nama)
                                            ->where('kompetensidasar_tipe',$dkd->tipe)

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
                                            <td class="text-center" width="10%" style="background-color: #f9f9f9">

                                    {{-- <input type="checkbox" id="chkCheckAllmateri{{$dm->id}}"> <label for="chkCheckAllmateri{{$dm->id}}">  {{$kodeprefix}}.{{$dkd->kode}}.{{$loop->index+1}} </label> --}}
                                    {{$kodeprefix}}.{{$dkd->kode}}.{{$loop->index+1}}
                                    <script>

                                            $("#chkCheckAllmateri{{$dm->id}}").click(function(){
                                                $(".materi{{$dm->id}}").prop('checked',$(this).prop('checked'));
                                            })
                                    </script>

                                             </td>
                                            @endforeach
                                        @else
                                            <td class="text-center" width="10%" style="background-color: #f9f9f9"> - </td>
                                        @endif
                                @endforeach
                            </tr>
                            <tbody id="datasiswa">
                            @foreach ($datasiswa as $data)
                                 <tr>
                                <td  style="vertical-align: middle;" class="text-center">{{$loop->index+1}}</td>
                                <td class="text-capitalize" >
                                    {{-- <input type="checkbox" id="chkCheckAll{{$data->nis}}"> <label for="chkCheckAll{{$data->nis}}">  {{$data->nama}}</label> --}}
                                    {{$data->nama}}
                                </td>

                                <script>

                                    $("#chkCheckAll{{$data->nis}}").click(function(){
                                        $(".siswa{{$data->nis}}").prop('checked',$(this).prop('checked'));
                                    })
                                </script>

                                @foreach ($datakd as $dkd)
                                        @php

                                            $jmldatamateri=DB::table('materipokok')
                                            ->where('kelas_nama',$kelas_nama)
                                            ->where('tapel_nama',$tapel_nama)
                                            ->where('pelajaran_nama',$pelajaran_nama)
                                            ->where('pelajaran_nama',$pelajaran_nama)
                                            ->where('kompetensidasar_kode',$dkd->kode)
                                            ->where('kompetensidasar_nama',$dkd->nama)
                                            ->where('kompetensidasar_tipe',$dkd->tipe)
                                            ->orderBy('created_at','asc')
                                            // ->orderBy('tipe','desc')
                                            ->count();

                                            $datamateri=DB::table('materipokok')
                                            ->where('kelas_nama',$kelas_nama)
                                            ->where('tapel_nama',$tapel_nama)
                                            ->where('pelajaran_nama',$pelajaran_nama)
                                            ->where('kompetensidasar_kode',$dkd->kode)
                                            ->where('kompetensidasar_nama',$dkd->nama)
                                            ->where('kompetensidasar_tipe',$dkd->tipe)
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
                                                    ->where('pelajaran_nama',$pelajaran_nama)
                                                    ->where('kelas_nama',$kelas_nama)
                                                    ->where('tapel_nama',$tapel_nama)
                                                    ->where('kompetensidasar_kode',$dkd->kode)
                                                    ->where('kompetensidasar_tipe',$dkd->tipe)
                                                    ->where('materipokok_nama',$dm->nama)
                                                    ->count();

                                                $tampilkan='0';
                                                if($cek>0){

                                                    $ambil=DB::table('nilaipelajaran')
                                                            ->where('siswa_nis',$data->nis)
                                                            ->where('pelajaran_nama',$pelajaran_nama)
                                                            ->where('kelas_nama',$kelas_nama)
                                                            ->where('tapel_nama',$tapel_nama)
                                                            ->where('kompetensidasar_kode',$dkd->kode)
                                                            ->where('kompetensidasar_tipe',$dkd->tipe)
                                                            ->where('materipokok_nama',$dm->nama)
                                                            ->first();
                                                    $tampilkan=$ambil->nilai;
                                                }
                                            @endphp
                                            <script>
                                                $(document).ready(function () {

                                                        function changeHandler(val)
                                                        {
                                                            if (Number(val) > 100)
                                                            {
                                                            val = 100
                                                            }

                                                            if (Number(val) < 0){
                                                                val = 0
                                                            }
                                                            return val;
                                                        }

                                                        var nilai=0;
                                                        var nis=0;
                                                        var dm=0;
                                                    var inputnilai{{$data->nis}}{{ $dm->id }}=$("#inputnilai{{$data->nis}}-{{$dm->id}}");
                                                    var nis{{$data->nis}}{{$dm->id}}=$("#nis{{$data->nis}}-{{$dm->id}}");
                                                    var dm{{$data->nis}}{{$dm->id}}=$("#dm{{$data->nis}}-{{$dm->id}}");

                                                    inputnilai{{$data->nis}}{{ $dm->id }}.click(function (e) {
                                                        e.preventDefault(e);

                                                        inputnilai{{$data->nis}}{{ $dm->id }}.prop('readonly',false);
                                                        // alert(inputnilai{{$data->nis}}{{ $dm->id }}.val());
                                                        console.log('klik inputan');

                                                    });

                                                    inputnilai{{$data->nis}}{{ $dm->id }}.focusout(function (e) {
                                                        // e.preventDefault(e);
                                                        // inputnilai{{$data->nis}}{{ $dm->id }}.prop('readonly',true);
                                                        let nilai=0;
                                                        nilai=changeHandler(inputnilai{{$data->nis}}{{ $dm->id }}.val());
                                                             fetch_customer_data(inputnilai{{$data->nis}}{{ $dm->id }}.val(),nis{{$data->nis}}{{ $dm->id }}.val(),dm{{$data->nis}}{{ $dm->id }}.val());
                                                            console.log(inputnilai{{$data->nis}}{{ $dm->id }}.val());
                                                        console.log('kirim update');
                                                        inputnilai{{$data->nis}}{{ $dm->id }}.val(nilai);
                                                        inputnilai{{$data->nis}}{{ $dm->id }}.prop('readonly',true);
                                                    });


                                                    inputnilai{{$data->nis}}{{ $dm->id }}.keypress(function (e) {
                                                        // e.preventDefault(e);
                                                        if (e.which == 13) {
                                                             fetch_customer_data(inputnilai{{$data->nis}}{{ $dm->id }}.val(),nis{{$data->nis}}{{ $dm->id }}.val(),dm{{$data->nis}}{{ $dm->id }}.val());
                                                            // console.log(inputnilai{{$data->nis}}{{ $dm->id }}.val());
                                                            // console.log(nis{{$data->nis}}{{ $dm->id }}.val());
                                                            // console.log(dm{{$data->nis}}{{ $dm->id }}.val());
                                                            console.log('kirim update');
                                                        inputnilai{{$data->nis}}{{ $dm->id }}.prop('readonly',true);
                                                            return false;    //<---- Add this line
                                                        }
                                                        // inputnilai{{$data->nis}}{{ $dm->id }}.prop('readonly',true);
                                                    });

                                                        //reqex untuk number only
                                                    inputnilai{{$data->nis}}{{ $dm->id }}.inputFilter(function(value) {
                                                        return /^\d*$/.test(value);    // Allow digits only, using a RegExp
                                                    });
                                                        //fungsi kirim data
                                                    function fetch_customer_data(query = '',nis='',dm='') {
                                                        console.log(query);
                                                            $.ajax({
                                                                url: "{{ route('api.inputnilai.singleinput') }}",
                                                                method: 'GET',
                                                                data: {
                                                                    "_token": "{{ csrf_token() }}",
                                                                nilai:query,
                                                                nis:nis,
                                                                dm:dm,
                                                                },
                                                                dataType: 'json',
                                                                success: function (data) {
                                                                    console.log(query);
                                                                    // console.log(data.output);
                                                                    // $("#datasiswa").html(data.output);
                                                                    // console.log(data.output);
                                                                    // console.log(data.datas);
                                                                }
                                                            })
                                                        }




                                                        //Documen Ready
                                                });


                                            </script>
                                            <td class="text-center"  style="vertical-align: middle;" >
                                                <input  class="babeng text-center text-info mb-2" id="inputnilai{{$data->nis}}-{{$dm->id}}" value="{{$tampilkan}}" readonly type="number">

                                                <input  class="babeng text-center text-info mb-2" id="nis{{$data->nis}}-{{$dm->id}}" value="{{$data->nis}}" readonly type="hidden">

                                                <input  class="babeng text-center text-info mb-2" id="dm{{$data->nis}}-{{$dm->id}}" value="{{$dm->id}}" readonly type="hidden">
                                            </td>
                                            @endforeach

                                        @else
                                            <td class="text-center"> -
                                                {{-- asda --}}
                                             </td>
                                        @endif
                                @endforeach


                                <td  style="vertical-align: middle;" class="text-center">
                                    @php

                                        $ambiljmlnilai=DB::table('nilaipelajaran')
                                                            ->where('siswa_nis',$data->nis)
                                                            ->where('kompetensidasar_tipe','Pengetahuan')
                                                            ->where('pelajaran_nama',$pelajaran_nama)
                                                            ->where('kelas_nama',$kelas_nama)
                                                            ->where('tapel_nama',$tapel_nama)
                                                            ->sum('nilai');

                                        $ambiljmldatanilai=DB::table('nilaipelajaran')
                                                            ->where('siswa_nis',$data->nis)
                                                            ->where('kompetensidasar_tipe','Pengetahuan')
                                                            ->where('pelajaran_nama',$pelajaran_nama)
                                                            ->where('kelas_nama',$kelas_nama)
                                                            ->where('tapel_nama',$tapel_nama)
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
                                                            ->where('pelajaran_nama',$pelajaran_nama)
                                                            ->where('kelas_nama',$kelas_nama)
                                                            ->where('tapel_nama',$tapel_nama)
                                                            ->sum('nilai');

                                        $ambiljmldatanilai=DB::table('nilaipelajaran')
                                                            ->where('siswa_nis',$data->nis)
                                                            ->where('kompetensidasar_tipe','Ketrampilan')
                                                            ->where('pelajaran_nama',$pelajaran_nama)
                                                            ->where('kelas_nama',$kelas_nama)
                                                            ->where('tapel_nama',$tapel_nama)
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
                            </tbody>



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
           ->where('kelas_nama',$kelas_nama)
           ->where('tapel_nama',$tapel_nama)
           ->where('pelajaran_nama',$pelajaran_nama)
           ->where('kompetensidasar_nama',$dkd->nama)
           ->where('kompetensidasar_kode',$dkd->kode)
           ->orderBy('created_at','asc')
           // ->orderBy('tipe','desc')
           ->count();

           $datamateri=DB::table('materipokok')
           ->where('kelas_nama',$kelas_nama)
           ->where('tapel_nama',$tapel_nama)
           ->where('pelajaran_nama',$pelajaran_nama)
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
                                    ->where('pelajaran_nama',$pelajaran_nama)
                                    ->where('kelas_nama',$kelas_nama)
                                    ->where('tapel_nama',$tapel_nama)
                                    ->count();

                                $tampilkan='-';
                                $nilaiawal=75;
                                if($cek>0){

                                    $ambil=DB::table('nilaipelajaran')
                                            ->where('siswa_nis',$data->nis)
                                            ->where('pelajaran_nama',$pelajaran_nama)
                                            ->where('kelas_nama',$kelas_nama)
                                            ->where('tapel_nama',$tapel_nama)
                                            ->first();
                                    $tampilkan=$ambil->nilai;
                                    $nilaiawal=$ambil->nilai;
                                }
                            @endphp


                    <div class="modal fade" id="modalinput{{$kodeprefix}}_{{$dkd->kode}}_{{$loop->index+1}}_{{$data->nis}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form method="post" action="/admin/datainputnilai/{{$data->id}}" >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Data {{$kodeprefix}}_{{$dkd->kode}}_{{$loop->index+1}}</h5>
                                </div>
                                <div class="modal-body">

                                    {{ csrf_field() }}

                                    <label>Nilai</label>
                                    <div class="form-group">
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
