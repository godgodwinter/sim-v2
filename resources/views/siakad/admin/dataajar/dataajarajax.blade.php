
@section('title','Data Ajar')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','siakaddataajar')

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
    <th  > Nama Mapel</th>
      @foreach ($datakelas as $dk)
        <th   > {{ $dk->nama }} </th>
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
@foreach ($datapelajaran as $dp)
<tr>
  <td class="text-center"> {{(($loop->index)+1)}}</td>
  <td> {{ $dp->nama }}
  @if($dp->jurusan!=='semua')
  - {{ $dp->jurusan }}
  @endif
  </td>
  @foreach ($datakelas as $dk)
  @php
    $nama=$dk->nama;
  @endphp
    <td class="text-center"  data-toggle="tooltip" data-placement="top" title="{{ $dp->nama }} - {{ $dk->nama }} " >
      <div class="row">

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
        $warna='primary';
      @endphp
            {{-- {{ $dataajar->guru_nomerinduk }} -
            {{ $dataajar->guru_nama }} --}}
        @else

      @endif
        <input  class="form-control w-50 text-center text-{{ $warna }}" data-toggle="modal" data-target="#pilihguru{{ $dp->id }}_{{ $dk->id }}" id="btnpilihguru{{ $dp->id }}_{{ $dk->id }}" value="{{ substr($guru, 0, 7) }}" readonly> &nbsp;
        @php
          $href="";
          $disabled="";
        @endphp
        @if($cekdatagurupengampu>0)
        @php
          $disabled="";
        //   $link2=url('/admin/inputnilai/mapel/'.$dataajar->id);
        $mapel_nama=base64_encode($dp->nama);
        $kelas_nama=base64_encode($dk->nama);
        $tapel_nama=base64_encode(Fungsi::tapelaktif());
          $link2=url('/admin/kompetensidasar/'.$mapel_nama.'/'.$kelas_nama.'/'.$tapel_nama);
          $href='href='.$link2;
        @endphp
        {{-- <a href="{{ url('/admin/inputnilai/kepribadian') }}/{{ $dp->id }}/{{ $dk->id }}"  type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Input nilai Kepribadian"><i class="fas fa-ribbon"></i></a>
        <a href="{{ url('/admin/inputnilai/ekstrakulikuler') }}/{{ $dp->id }}/{{ $dk->id }}" type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Input nilai Ekstrakulikuler"><i class="fas fa-dungeon"></i></a> --}}
        @else
        @php
        //   $disabled="disabled";
        //   $href='href=#';

        $mapel_nama=base64_encode($dp->nama);
        $kelas_nama=base64_encode($dk->nama);
        $tapel_nama=base64_encode(Fungsi::tapelaktif());
          $link2=url('/admin/kompetensidasar/'.$mapel_nama.'/'.$kelas_nama.'/'.$tapel_nama);
          $href='href='.$link2;
        @endphp

        @endif

        <a {{ $href }} type="button" class="btn btn-outline-{{ $warna }}" id="link{{ $dp->id }}_{{ $dk->id }}" ><i class="fas fa-user-graduate" {{ $disabled }}></i></a>
      @endif
    </div>
    </td>
  @endforeach
</tr>
@endforeach

{{-- <tr>
  <td class="text-left" colspan="2">
    <a href="#" class="btn btn-sm  btn-danger" id="deleteAllSelectedRecord"
    onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><i class="fas fa-trash"></i> Hapus Terpilih</a></td>
</tr> --}}
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
                      {{-- <form method="post" action="/admin/{{ $pages }}" enctype="multipart/form-data"> --}}
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pilih Guru Pengampu</h5>
                          </div>
                          <div class="modal-body">

                            {{ csrf_field() }}
                              <div class="form-group">
                                <label>Pilih : </label>
                                <select class="form-control form-control-lg" id="tags{{ $dp->id }}_{{ $dk->id }}" select2 select2-hidden-accessible   name="guru_nomerinduk{{ $dp->id }}_{{ $dk->id }}" required>
                                {{-- <select class="form-control form-control-lg" id="tags{{ $dp->id }}_{{ $dk->id }}" select2 select2-hidden-accessible multiple="multiple"  name="guru_nomerinduk{{ $dp->id }}_{{ $dk->id }}" required> --}}
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

                                                // tags{{ $dp->id }}_{{ $dk->id }}.focus().select();

                                              }, 100);

                                          });

                                          // tags{{ $dp->id }}_{{ $dk->id }}.click(function(e){
                                          //   $('#tags{{ $dp->id }}_{{ $dk->id }} option[selected="true"]').removeAttr('selected');

                                          // });

                                });
                                </script>

                            <script type="text/javascript">
                            // $('#tags{{ $dp->id }}_{{ $dk->id }}').on('change', function (e) {

                            // $('#tags{{ $dp->id }}_{{ $dk->id }} option:cl').on('change', function (e) {
                                // var optionSelected = $("option:selected", this);
                                // var valueSelected = this.value;
                                // console.log(valueSelected);
                                // console.log('halo');

                            // });

                            var values = $('#tags option[selected="true"]').map(function() { return $(this).val(); }).get();

                              // you have no need of .trigger("change") if you dont want to trigger an event
                              $('#tags{{ $dp->id }}_{{ $dk->id }}').select2({
                                placeholder: "Pilih Guru Pengampu",
                                dropdownParent: $('#pilihguru{{ $dp->id }}_{{ $dk->id }}')
                               });
                          </script>

                            {{-- <label>Pilih</label> --}}
                            {{-- <div class="form-group"> --}}
                              <input type="hidden" name="pelajaran_nama{{ $dp->id }}_{{ $dk->id }}" value="{{ $dp->nama }}">
                              <input type="hidden" name="pelajaran_tipepelajaran{{ $dp->id }}_{{ $dk->id }}" value="{{ $dp->tipepelajaran }}">
                              <input type="hidden" name="pelajaran_jurusan{{ $dp->id }}_{{ $dk->id }}" value="{{ $dp->jurusan }}">
                              {{-- <input type="hidden" name="pelajaran_kelas_nama" value="{{ $dp->kelas_nama }}"> --}}
                              <input type="hidden" name="kelas_nama{{ $dp->id }}_{{ $dk->id }}" value="{{ $dk->nama }}">
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
                            <a href="#" class="btn btn-icon btn-primary btn-sm tombol-simpan{{ $dp->id }}_{{ $dk->id }}"
                                data-toggle="tooltip" data-placement="top" title="Simpan Data!"><span
                                    class="pcoded-micon" id="tombol-simpan{{ $dp->id }}_{{ $dk->id }}"> Simpan</span></a>
                            {{-- <button type="submit" class="btn btn-primary">Simpan</button> --}}
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  @endif


                  <script type="text/javascript">
                    $(document).ready(function(){

                    $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });


                    var btnpilihguru{{ $dp->id }}_{{ $dk->id }} = document.getElementById('btnpilihguru{{ $dp->id }}_{{ $dk->id }}');
                    var link{{ $dp->id }}_{{ $dk->id }} = document.getElementById('link{{ $dp->id }}_{{ $dk->id }}');
                    var tags{{ $dp->id }}_{{ $dk->id }} = document.getElementById('tags{{ $dp->id }}_{{ $dk->id }}');


                    $(".tombol-simpan{{ $dp->id }}_{{ $dk->id }}").click(function(e){
                      e.preventDefault();

                  var pelajaran_nama = $("input[name=pelajaran_nama{{ $dp->id }}_{{ $dk->id }}]").val();
                  var pelajaran_tipepelajaran = $("input[name=pelajaran_tipepelajaran{{ $dp->id }}_{{ $dk->id }}]").val();
                  var pelajaran_jurusan = $("input[name=pelajaran_jurusan{{ $dp->id }}_{{ $dk->id }}]").val();
                  var kelas_nama = $("input[name=kelas_nama{{ $dp->id }}_{{ $dk->id }}]").val();
                  var guru_nama = $( "#tags{{ $dp->id }}_{{ $dk->id }} option:selected" ).text();
                  var guru_nomerinduk = $( "#tags{{ $dp->id }}_{{ $dk->id }} option:selected" ).val();


                            $.ajax({
                            url: "/admin/siakaddataajarajax",
                            method:'POST',
                            data:{
                             "_token": "{{ csrf_token() }}",
                             pelajaran_nama:pelajaran_nama,
                              pelajaran_tipepelajaran:pelajaran_tipepelajaran,
                              pelajaran_jurusan:pelajaran_jurusan,
                              guru_nomerinduk:guru_nomerinduk,
                              kelas_nama:kelas_nama
                            },
                            success:function(response){
                            if(response.success){
                              // $("a#changeme").attr('href',
                              // 'http://maps.google.com/');



                              console.log(response.message);
                              if(response.message>0){

                                // $("a#link{{ $dp->id }}_{{ $dk->id }}").attr('href',
                                // '{{ url('/admin/inputnilai/mapel/') }}/'+response.message);

                                $("a#link{{ $dp->id }}_{{ $dk->id }}").attr('class',
                                'btn btn-outline-primary');
                              }

                              // $("a#link{{ $dp->id }}_{{ $dk->id }}").attr('href',
                              // 'http://maps.google.com/');



                              btnpilihguru{{ $dp->id }}_{{ $dk->id }}.value = guru_nama;
                            $('#pilihguru{{ $dp->id }}_{{ $dk->id }}').modal('hide');
                            console.log(link{{ $dp->id }}_{{ $dk->id }});
                            // console.log(guru_nomerinduk);
                            }else{
                            alert("Error")
                            }
                            },
                            error:function(error){

                            alert('Gagal!') //Message come from controller
                            // console.log(guru_nomerinduk)
                            }
                            });


                          });

                    });
                    </script>
                @endforeach

              @endforeach


@endsection
