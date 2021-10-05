
@section('title','Silabus')
@section('halaman')
<div class="breadcrumb-item"><a href="{{route('siakaddataajar')}}"> Data Ajar</a></div>
<div class="breadcrumb-item"> Index</div>
@endsection

@section('csshere')
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
  .container {
      max-width: 500px;
  }
  h2 {
      color: white;
  }
  .form-control2 {
    border: 0;
}
input[readonly]{
  background-color:transparent;
  border: 0;
  font-size: 1em;
}
.babeng-select{
  position: relative;
  width: 200px;

}
.babeng{
  width:150px;
  border-radius: 5px;
  background: #fff;
  border: 1px solid #ccc;
  outline:none;
  padding: 6px;
}

.babeng:focus{
  border:1px solid #56b4ef;
  box-shadow: 0px 0px 3px 1px #c8def0;
}

#babeng-bar {
    width: 100%;
    /* height: 45px; */
    overflow: hidden;
    padding-bottom: 0px;
}

#babeng-bar span {
    height: 100%;
    display: inline;
    overflow: hidden;
    padding-left: 0px
}

#babeng-row {
    height: 100%;
    width: 100%;
    text-align: center;
display: inline;
}

#babeng-submit {
    height: 35px;
}
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
<x-alert tipe="{{ $tipe }}" message="{{ $message }}" icon="{{ $icon }}"/>

@endif
@endsection


{{-- DATATABLE --}}
@section('headtable')
  <th width="5%" class="text-center">
   No</th>
    <th   width="25%"> Nama Mapel</th>
    <th   width="5%"> Kelas</th>
    <th   width="25%" class="text-center"> Guru Pengajar</th>
    <th  class="text-center" width="5%"> Detail</th>

@endsection

@section('bodytable')

<script>
  console.log('asdad');
  $().jquery;
  $.fn.jquery;
  $(function(e){
      $("#chkCheckAll").click(function(){
          $(".checkBoxClass").prop('checked',$(this).prop('checked'));
      })

      $("#deleteAllSelectedRecord").click(function(e){
          e.preventDefault();
          var allids=[];
              $("input:checkbox[name=ids]:checked").each(function(){
                  allids.push($(this).val());
              });

      $.ajax({
          url:"{{ route('kelas.multidel') }}",
          type:"DELETE",
          data:{
              _token:$("input[name=_token]").val(),
              ids:allids
          },
          success:function(response){
              $.each(allids,function($key,val){
                      $("#sid"+val).remove();
              })
          }
      });

      })

  });
</script>
@foreach ($datas as $data)
<tr>
  <td class="text-center"> {{(($loop->index)+1)}}</td>
  <td> {{ $data->pelajaran_nama }} </td>
  <td> {{ $data->kelas_nama }} </td>
  <td class="text-center">
      {{-- {{ $data->guru_nomerinduk }}  {{ $data->guru_nama }} --}}
    <input  class="babeng text-center text-info mb-2" data-toggle="modal" data-target="#pilihguru{{ $data->id }}" id="btnpilihguru{{ $data->id }}" value="
    {{-- {{ substr($data->guru_nama, 0, 7) }} --}}
    {{ $data->guru_nama }}
    " readonly> &nbsp;

</td>
  <td class="text-center">

    @php
    $mapel_nama=base64_encode($data->pelajaran_nama);
    $kelas_nama=base64_encode($data->kelas_nama);
    $tapel_nama=base64_encode(Fungsi::tapelaktif());
      $link2=url('/admin/kompetensidasar/'.$mapel_nama.'/'.$kelas_nama.'/'.$tapel_nama);
      $href='href='.$link2;
      $warna='info';
    @endphp
    <a {{ $href }} type="button" class="btn btn-outline-{{ $warna }}" data-toggle="tooltip" data-placement="top" title="Detail Silabus!" >
        <i class="fas fa-inbox"></i>
        {{-- <i class="fas fa-user-graduate" {{ $disabled }}></i> --}}
    </a>

  </td>
@endforeach
@endsection

@section('foottable')
@php
//   $cari=$request->cari;
  $tapel_nama=$request->tapel_nama;
  $kelas_nama=$request->kelas_nama;
@endphp
{{ $datas->onEachSide(1)
//   ->appends(['cari'=>$cari])
  ->appends(['tapel_nama'=>$tapel_nama])
  ->appends(['kelas_nama'=>$kelas_nama])
  ->links() }}
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><i class="far fa-file"></i> Halaman ke-{{ $datas->currentPage() }}</li>
    <li class="breadcrumb-item"><i class="fas fa-paste"></i> {{ $datas->total() }} Total Data</li>
    <li class="breadcrumb-item active" aria-current="page"><i class="far fa-copy"></i> {{ $datas->perPage() }} Data Perhalaman</li>

</ol>
</nav>

@endsection

{{-- DATATABLE-END --}}
@section('container')


  <div class="section-body">
    <div class="row mt-sm-4">

      <div class="col-12 col-md-12 col-lg-12">


                <div class="card ">
                    <div class="row">



                    <div id="babeng-bar" class="text-center mt-2" >

                        <div id="babeng-row ">

                            <form action="{{ route('dataajar.cari') }}" method="GET">
                            <select class="babeng babeng-select  ml-2"  name="pelajaran_nama">
                                @if($request->pelajaran_nama)
                                  <option>{{$request->pelajaran_nama}}</option>
                                @else
                                 <option value=""  selected>Pilih Mapel</option>
                                @endif
                                <option value="">--semua--</option>
                              @foreach ($pelajaran as $t)
                                  <option>{{ $t->nama }}</option>
                              @endforeach
                            </select>

                            <select class="babeng babeng-select  ml-2"  name="kelas_nama">
                                @if($request->kelas_nama)
                                  <option>{{$request->kelas_nama}}</option>
                                @else
                                 <option value=""  selected>Pilih Kelas</option>
                                @endif
                                <option value="">--semua--</option>
                              @foreach ($kelas as $t)
                                  <option>{{ $t->nama }}</option>
                              @endforeach
                            </select>



                    <span>
                        <input class="btn btn-info ml-2 mt-2 mt-sm-0" type="submit" id="babeng-submit" value="Cari">
                        </span>

                        <button type="button" class="btn btn-icon btn-primary btn-sm ml-0 ml-sm-4" data-toggle="modal" data-target="#importExcel"><i class="fas fa-upload"></i>
                            Import
                        </button>
                        <a href="/admin/@yield('linkpages')/export" type="submit" value="Import" class="btn btn-icon btn-primary btn-sm mr-2"><span
                                class="pcoded-micon"> <i class="fas fa-download"></i> Export </span></a>
                            </form>

                            </div>
                    </div>


                    </div>
                {{-- @yield('datatable') --}}
                {{-- {{ dd($datas) }} --}}

                <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-striped  table-sm">
                    <tr>
                        @yield('headtable')
                    </tr>
                        @yield('bodytable')

                    </table>
                    <a href="#" class="btn btn-sm  btn-danger mb-2" id="deleteAllSelectedRecord"
                    onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"  data-toggle="tooltip" data-placement="top" title="Hapus Terpilih">
                    <i class="fas fa-trash-alt mr-2"></i> Hapus Terpilih</i>
                </a>
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
              <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

              @foreach ($datas as $data)

              <div class="modal fade" id="pilihguru{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                      </div>
                      <div class="modal-body">

                        <label>Pilih : </label>
                        <input type="hidden" name="id{{ $data->id }}" value="{{ $data->id }}">
                        <select class="babeng babeng-select" id="tags{{ $data->id }}" select2 select2-hidden-accessible   name="guru_nomerinduk{{ $data->id }}" required>

                          @php
                          $cekdatagurupengampu = DB::table('dataajar')
                            ->where('kelas_nama', '=', $data->kelas_nama)
                            ->where('pelajaran_nama', '=', $data->pelajaran_nama)
                            ->count();
                          $dataajar=DB::table('dataajar')
                            ->where('kelas_nama', '=', $data->kelas_nama)
                            ->where('pelajaran_nama', '=', $data->pelajaran_nama)
                            ->first();
                            @endphp
                            @if($cekdatagurupengampu>0)
                            <option value="{{ $dataajar->guru_nomerinduk }}" selected >{{ $dataajar->guru_nama }}</option>

                              @else

                            @endif
                          @foreach ($dataguru as $t)
                              <option value="{{ $t->nomerinduk }}" > {{ $t->nama }}</option>
                          @endforeach
                        </select>

                        <script type="text/javascript">

                            var values = $('#tags option[selected="true"]').map(function() { return $(this).val(); }).get();

                              // you have no need of .trigger("change") if you dont want to trigger an event
                              $('#tags{{ $data->id }}').select2({
                                    theme: "classic",
                                placeholder: "Pilih Guru ",
                                dropdownParent: $('#pilihguru{{ $data->id }}')
                               });


                    $(document).ready(function(){

                                        $.ajaxSetup({
                                        headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                        });


                                        var btnpilihguru{{ $data->id }} = document.getElementById('btnpilihguru{{ $data->id }}');
                                        var link{{ $data->id }} = document.getElementById('link{{ $data->id }}');
                                        var tags{{ $data->id }} = document.getElementById('tags{{ $data->id }}');


                                        $(".tombol-simpan{{ $data->id }}").click(function(e){
                                        e.preventDefault();

                                        var id = $("input[name=id{{ $data->id }}]").val();
                                        var guru_nomerinduk = $( "#tags{{ $data->id }} option:selected" ).val();
                                        var guru_nama = $( "#tags{{ $data->id }} option:selected" ).text();


                                                $.ajax({
                                                url: "/admin/siakaddataajarajax_new",
                                                method:'POST',
                                                data:{
                                                "_token": "{{ csrf_token() }}",
                                                id:id,
                                                guru_nomerinduk:guru_nomerinduk,
                                                },
                                                success:function(response){
                                                if(response.success){
                                                // $("a#changeme").attr('href',
                                                // 'http://maps.google.com/');



                                                console.log(response.message);
                                                if(response.message>0){

                                                    $("a#link{{ $data->id }}").attr('class',
                                                    'btn btn-outline-primary');
                                                }


                                                btnpilihguru{{ $data->id }}.value = guru_nama;
                                                $('#pilihguru{{ $data->id }}').modal('hide');
                                                console.log(link{{ $data->id }});
                                                }else{
                                                alert("Error")
                                                }
                                                },
                                                error:function(error){

                                                alert('Gagal!') //Message come from controller
                                                }
                                                });


                                            });

                                        });

                          </script>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="#" class="btn btn-icon btn-primary btn-sm tombol-simpan{{ $data->id }}"
                            data-toggle="tooltip" data-placement="top" title="Simpan Data!"><span
                                class="pcoded-micon" id="tombol-simpan{{ $data->id }}"> Simpan</span></a>
                      </div>
                    </div>
                </div>
              </div>


              @endforeach

@endsection
