
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
    <input type="checkbox" id="chkCheckAll"> <label for="chkCheckAll"> All</label></th>
    <th>Mapel</th>
      @foreach ($datakelas as $dk)
        <th class="text-center"> {{ $dk->nama }} </th>
      @endforeach
  <th width="200px" class="text-center">Aksi</th>
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
@foreach ($datapelajaran as $dp)
<tr>
  <td> </td>
  <td> {{ $dp->nama }}
  @if($dp->jurusan!=='semua')
  - {{ $dp->jurusan }}
  @endif
  </td>
  @foreach ($datakelas as $dk)
  @php
    $nama=$dk->nama;
  @endphp
    <td class="text-center">
      @php
        $tombol='';
        $guru='Belum diisi';
        $warna='warning';
      @endphp
      @if($dp->tipepelajaran!='C2. Dasar Program Keahlian')
          @php
            $tombol=$dp->tipepelajaran;
          @endphp
      @else
      {{-- {{ dd('tes') }} --}}
          {{-- {{ dd(Fungsi::periksajurusankode($dk->nama)) }} --}}
          @if($dp->jurusan==Fungsi::periksajurusankode($dk->nama))
          {{-- {{ dd(Fungsi::periksajurusankode($dk->nama)) }} --}}
          @php

            $tombol=Fungsi::periksajurusankode($dk->nama);
          @endphp
          @else
            -
          @endif
      @endif
      @if($tombol!=='')
      @php
    $cekdatagurupengampu = DB::table('dataajar')
      ->where('kelas_nama', '=', $dk->nama)
      ->where('pelajaran_nama', '=', $dp->nama)
      ->count();
    $dataajar=DB::table('dataajar')
      ->where('kelas_nama', '=', $dk->nama)
      ->where('pelajaran_nama', '=', $dp->nama)
      ->first();
      @endphp
      @if($cekdatagurupengampu>0)
      @php
        $guru=$dataajar->guru_nama;
        // $guru=$dataajar->guru_nomerinduk." - ".$dataajar->guru_nama;
        $warna='light';
      @endphp
            {{-- {{ $dataajar->guru_nomerinduk }} -
            {{ $dataajar->guru_nama }} --}}
        @else
        -
      @endif
      <br>
        <button class="btn btn-icon btn-{{ $warna }}" data-toggle="modal" data-target="#pilihguru{{ $dp->id }}_{{ $dk->id }}" id="btnpilihguru{{ $dp->id }}_{{ $dk->id }}">{{ substr($guru, 0, 7) }}</button>

        <br>
        @if($cekdatagurupengampu>0)
        <a href="{{ url('/admin/inputnilai/mapel') }}/{{ $dataajar->id }}" type="button" class="btn btn-outline-primary"  data-toggle="tooltip" data-placement="top" title="Input nilai Mapel" ><i class="fas fa-user-graduate"></i></a>
        {{-- <a href="{{ url('/admin/inputnilai/kepribadian') }}/{{ $dp->id }}/{{ $dk->id }}"  type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Input nilai Kepribadian"><i class="fas fa-ribbon"></i></a>
        <a href="{{ url('/admin/inputnilai/ekstrakulikuler') }}/{{ $dp->id }}/{{ $dk->id }}" type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Input nilai Ekstrakulikuler"><i class="fas fa-dungeon"></i></a> --}}
        @endif
      @endif
    </td>
  @endforeach
</tr>
@endforeach

<tr>
  <td class="text-left" colspan="2">
    <a href="#" class="btn btn-sm  btn-danger" id="deleteAllSelectedRecord"
    onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><i class="fas fa-trash"></i> Hapus Terpilih</a></td>
</tr>
@endsection

@section('foottable')

@endsection

{{-- DATATABLE-END --}}
@section('container')


  <div class="section-body">
    <div class="row mt-sm-4">

      <div class="col-12 col-md-12 col-lg-12">
        <x-layout-table2 pages="{{ $pages }}" pagination=""/>
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

              @foreach ($datapelajaran as $dp)
                @foreach ($datakelas as $dk)

                    @php
                    $tombol='';
                  @endphp
                  @if($dp->tipepelajaran!='C2. Dasar Program Keahlian')
                      @php
                        $tombol=$dp->tipepelajaran;
                      @endphp
                  @else
                      @if($dp->jurusan==Fungsi::periksajurusankode($dk->nama))
                      @php
                        $tombol=Fungsi::periksajurusankode($dk->nama);
                      @endphp
                      @else
                        -
                      @endif
                  @endif
                  @if($tombol!=='')
                  <div class="modal fade" id="pilihguru{{ $dp->id }}_{{ $dk->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <form method="post" action="/admin/{{ $pages }}" enctype="multipart/form-data">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pilih Guru Pengampu</h5>
                          </div>
                          <div class="modal-body">

                            {{ csrf_field() }}
                              <div class="form-group">
                                <label>Pilih : <code>Hanya pilihan Terakhir akan disimpan!</code></label>
                                <select class="form-control form-control-lg" id="tags{{ $dp->id }}_{{ $dk->id }}" select2 select2-hidden-accessible multiple="multiple"  name="guru_nomerinduk" required>
                                  @php
                                  $cekdatagurupengampu = DB::table('dataajar')
                                    ->where('kelas_nama', '=', $dk->nama)
                                    ->where('pelajaran_nama', '=', $dp->nama)
                                    ->count();
                                  $dataajar=DB::table('dataajar')
                                    ->where('kelas_nama', '=', $dk->nama)
                                    ->where('pelajaran_nama', '=', $dp->nama)
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
                              </div>

                              <script type="text/javascript">
                                $(document).ready(function(){
                                          var input{{ $dp->id }}_{{ $dk->id }} = $("#btnpilihguru{{ $dp->id }}_{{ $dk->id }}");
                                          var tags{{ $dp->id }}_{{ $dk->id }} = $("#tags{{ $dp->id }}_{{ $dk->id }}");
                                          // var op{{ $dp->id }}_{{ $dk->id }} = $("#op{{ $dp->id }}_{{ $dk->id }}");
                                          $('#pilihguru{{ $dp->id }}_{{ $dk->id }}').on('shown.bs.modal', function() {
                                              setTimeout(function (){
                                                console.log(tags{{ $dp->id }}_{{ $dk->id }});

                                                tags{{ $dp->id }}_{{ $dk->id }}.focus().select();

                                              }, 100);

                                          });

                                          // tags{{ $dp->id }}_{{ $dk->id }}.click(function(e){
                                          //   $('#tags{{ $dp->id }}_{{ $dk->id }} option[selected="true"]').removeAttr('selected');

                                          // });

                                });
                                </script>

                            <script type="text/javascript">
                            var values = $('#tags option[selected="true"]').map(function() { return $(this).val(); }).get();

                              // you have no need of .trigger("change") if you dont want to trigger an event
                              $('#tags{{ $dp->id }}_{{ $dk->id }}').select2({ placeholder: "Pilih Guru Pengampu" });
                          </script>

                            {{-- <label>Pilih</label> --}}
                            {{-- <div class="form-group"> --}}
                              <input type="hidden" name="pelajaran_nama" value="{{ $dp->nama }}">
                              <input type="hidden" name="pelajaran_tipepelajaran" value="{{ $dp->tipepelajaran }}">
                              <input type="hidden" name="pelajaran_jurusan" value="{{ $dp->jurusan }}">
                              {{-- <input type="hidden" name="pelajaran_kelas_nama" value="{{ $dp->kelas_nama }}"> --}}
                              <input type="hidden" name="kelas_nama" value="{{ $dk->nama }}">
                              {{-- <select class="form-control form-control-lg" required name="guru_nomerinduk">
                                @php
                                $cekdatagurupengampu = DB::table('dataajar')
                                  ->where('kelas_nama', '=', $dk->nama)
                                  ->where('pelajaran_nama', '=', $dp->nama)
                                  ->count();
                                $dataajar=DB::table('dataajar')
                                  ->where('kelas_nama', '=', $dk->nama)
                                  ->where('pelajaran_nama', '=', $dp->nama)
                                  ->first();
                                  @endphp
                                  @if($cekdatagurupengampu>0)
                                  <option value="{{ $dataajar->guru_nomerinduk }}">{{ $dataajar->guru_nomerinduk }} - {{ $dataajar->guru_nama }}</option>

                                    @else

                                  @endif
                                @foreach ($dataguru as $t)
                                    <option value="{{ $t->nomerinduk }}">{{ $t->nomerinduk }} - {{ $t->nama }}</option>
                                @endforeach
                              </select> --}}
                            {{-- </div> --}}

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  @endif

                @endforeach

              @endforeach


@endsection