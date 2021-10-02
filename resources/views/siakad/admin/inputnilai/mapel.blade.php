
@section('title')
  {{ $dataajar->kelas_nama }} - {{ $dataajar->pelajaran_nama  }} - {{ $dataajar->guru_nomerinduk }} {{ $dataajar->guru_nama }}
@endsection
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','siakaddataajar')

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
<tr>
  <th width="5%" class="text-center align-middle" rowspan="2">No</th>
    <th rowspan="2" class=" align-middle text-center">Nama Siswa</th>
    <th colspan="{{ $jmlpengetahuan }}" class="text-center">Pengetahuan</th>
    <th colspan="{{ $jmlketrampilan }}" class="text-center">Ketrampilan</th>
</tr>
<tr>
      @foreach ($datajenisnilai as $dj)
        <th class="text-center"  data-toggle="tooltip" data-placement="top" title="{{ $dj->nama }}" > {{ $dj->kode }} </th>
      @endforeach
</tr>
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
@foreach ($datasiswa as $ds)
<tr>
  <td class="text-center">{{ ($loop->index+1) }}</td>
  <td>  {{ $ds->nis }} - {{ $ds->nama }}</td>
  @foreach ($datajenisnilai as $dj)
  @php
    $nama=$dj->nama;
  @endphp
    <td class="text-center"   data-toggle="tooltip" data-placement="top" title="{{ $dj->nama }}">
      @php
    $ceknilai = DB::table('nilaipelajaran')
      ->where('siswa_nis', '=', $ds->nis)
      ->where('kelas_nama', '=', $dataajar->kelas_nama)
      ->where('pelajaran_nama', '=', $dataajar->pelajaran_nama)
      ->where('jenisnilai_nama', '=', $dj->nama)
      ->where('semester_nama', '=', getsettings::semesteraktif())
      ->count();

      $ambilnilai = DB::table('nilaipelajaran')
                            ->where('siswa_nis', '=', $ds->nis)
                            ->where('kelas_nama', '=', $dataajar->kelas_nama)
                          ->where('pelajaran_nama', '=', $dataajar->pelajaran_nama)
                          ->where('jenisnilai_nama', '=', $dj->nama)
                          ->where('semester_nama', '=', getsettings::semesteraktif())
                            ->first();
      @endphp
      @if($ceknilai>0)
          @php
          $nilai=$ambilnilai->nilai;
            $warna='light';
          @endphp
      @else
        @php
        $nilai='Belum diisi';
          $warna='warning';
        @endphp
      @endif

      <button class="btn btn-icon btn-{{ $warna }}" data-toggle="modal" data-target="#pilihguru{{ $ds->id }}_{{ $dj->id }}" > {{ $nilai }} </button>

    </td>
  @endforeach

  <td>
    <a href="{{ url('/raport') }}/{{ $ds->nis }}"  type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Lihat raport siswa" target="_blank"><i class="fas fa-print"></i></a>

  </td>
</tr>
@endforeach

@endsection

@section('foottable')

@endsection

{{-- DATATABLE-END --}}
@section('container')

{{-- {{ dd($datasiswa) }} --}}
  <div class="section-body">
    <div class="row mt-sm-4">

      <div class="col-12 col-md-12 col-lg-12">

                  <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="{{ asset("assets/") }}/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                            <div class="form-group col-md-12 col-12 mt-1 text-right">
                              <a type="button" class="btn btn-icon btn-success btn-sm" href="{{ url('/admin/siakaddataajar') }}"><i class="fas fa-upload"></i>
                                Nilai Pelajaran
                              </a>
                              <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#importExcel"><i class="fas fa-upload"></i>
                                Import
                              </button>
                              <a href="/admin/@yield('linkpages')/export" type="submit" value="Import" class="btn btn-icon btn-primary btn-sm"><span
                                    class="pcoded-micon"> <i class="fas fa-download"></i> Export </span></a>
                              </div>
                        </div>
                    </div>
                {{-- @yield('datatable') --}}
                {{-- {{ dd($datas) }} --}}

                    <div class="card-body -mt-5">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover table-md" border="1">
                                @yield('headtable')

                                @yield('bodytable')

                            </table>
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

              @foreach ($datasiswa as $ds)
                @foreach ($datajenisnilai as $dj)

                  <div class="modal fade" id="pilihguru{{ $ds->id }}_{{ $dj->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <form method="post" action="/admin/inputnilai/mapel/{{ $dataajar->id }}" enctype="multipart/form-data">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Input nilai</h5>
                          </div>
                          <div class="modal-body">

                            {{ csrf_field() }}

                            {{-- <label>Pilih</label> --}}
                            <div class="form-group">
                              <input type="hidden" name="siswa_nama" value="{{ $ds->nama }}">
                              <input type="hidden" name="siswa_nis" value="{{ $ds->nis }}">
                              <input type="hidden" name="jenisnilai_nama" value="{{ $dj->nama }}">
                              <input type="hidden" name="jenisnilai_tipe" value="{{ $dj->tipe }}">

                          @php
                          $ceknilai = DB::table('nilaipelajaran')
                            ->where('siswa_nis', '=', $ds->nis)
                            ->where('kelas_nama', '=', $dataajar->kelas_nama)
                          ->where('pelajaran_nama', '=', $dataajar->pelajaran_nama)
                          ->where('jenisnilai_nama', '=', $dj->nama)
                            ->count();

                          $ambilnilai = DB::table('nilaipelajaran')
                            ->where('siswa_nis', '=', $ds->nis)
                            ->where('kelas_nama', '=', $dataajar->kelas_nama)
                            ->where('pelajaran_nama', '=', $dataajar->pelajaran_nama)
                            ->where('jenisnilai_nama', '=', $dj->nama)
                            ->first();
                            @endphp
                            @if($ceknilai>0)
                                @php
                              $nilai=$ambilnilai->nilai;
                                @endphp
                            @else
                            @php
                            $nilai=75;
                            @endphp
                            @endif
                              <input type="number" name="nilai" min="1" max="100" id="nilai" class="form-control @error('kkm') is-invalid @enderror"value="{{ $nilai }}" required autofocus>
                              @error('kkm')<div class="invalid-feedback"> {{$message}}</div>
                              @enderror
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
