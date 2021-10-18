
@section('title','Absensi')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman')
<div class="breadcrumb-item"> Absensi</div>
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
<x-alert tipe="{{ $tipe }}" message="{{ $message }}" icon="{{ $icon }}"/>

@endif
@endsection


{{-- DATATABLE --}}
@section('headtable')
  <th width="5px" class="text-center" style="vertical-align: middle;">
    No
</th>
  <th  style="vertical-align: middle;"> Nama kelas </th>
    @foreach ($dates as $d)
            <th class="text-center">
                @php
                    $i=$loop->index;
                    $tgl=$dates[$i]->format('d');
                @endphp
                {{$tgl}}
            </th>
    @endforeach
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
<tr id="sid{{ $data->id }}">
    <td class="text-center">
        {{-- <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->id }}">  {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }} --}}

        {{(($loop->index)+1)}}
    </td>
    <td>{{ $data->nama }}</td>

    @foreach ($dates as $d)
            <td class="text-center">
                @php
                    $i=$loop->index;
                    $tgl=$dates[$i]->format('Y-m-d');
                @endphp
                {{-- {{$tgl}} --}}
                @php
                $cek=DB::table('absensi')
                            ->where('siswa_nis',$data->nis)
                            ->where('siswa_nama',$data->nama)
                            ->where('kelas_nama',$kelas->nama)
                            ->where('tanggal_masuk',$tgl)
                            ->count();

                $tampilkan='-';
                            if($cek>0){
                $ambildata=DB::table('absensi')
                            ->where('siswa_nis',$data->nis)
                            ->where('siswa_nama',$data->nama)
                            ->where('kelas_nama',$kelas->nama)
                            ->where('tanggal_masuk',$tgl)
                            ->first();
                if($ambildata->ket=='Tanpa Keterangan'){
                    $tampilkan='T';
                }elseif($ambildata->ket=='Ijin'){
                    $tampilkan='I';
                }elseif($ambildata->ket=='Sakit'){
                    $tampilkan='S';
                }else{
                    $tampilkan='-';
                }

                            }
                @endphp
                <label for=""  data-toggle="modal" data-target="#modal{{$data->nis}}-{{$tgl}}">{{$tampilkan}}</label>

            </td>
    @endforeach


  </tr>
@endforeach


@endsection

@section('foottable')

  {{ $datas->links() }}
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
                    <div class="form-group col-md-12 col-12 text-right mt-2">
                      <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#importExcel"><i class="fas fa-upload"></i>
                        Import
                      </button>
                      <a href="/admin/@yield('linkpages')/export" type="submit" value="Import" class="btn btn-icon btn-primary btn-sm"><span
                            class="pcoded-micon"> <i class="fas fa-download"></i> Export </span></a>
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



              {{-- modal absensi --}}
              @foreach ($datas as $data)


                  @foreach ($dates as $d)

                              @php
                                  $i=$loop->index;
                                  $tgl=$dates[$i]->format('Y-m-d');
                                  $tgl2=$dates[$i]->format('d');
                              @endphp

              <div class="modal fade" id="modal{{$data->nis}}-{{$tgl}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="#" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> {{$data->nama}} - {{Fungsi::tanggalindo($tgl)}}</h5>
                      </div>
                      <div class="modal-body">

                        {{ csrf_field() }}


                        <div class="form-group col-md-12 col-12 mt-0">
                            <label for="nama">Pilih Absensi </label>
                        <input type="hidden" name="siswa_nis" value="{{$data->nis}}">
                        <input type="hidden" name="siswa_nama" value="{{$data->nama}}">
                        <input type="hidden" name="tanggal_masuk" value="{{$tgl}}">
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
