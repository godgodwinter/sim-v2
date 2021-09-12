
@section('title')
  {{ $kelas->nama }}- {{ $kelas->guru_nomerinduk }} {{ $kelas->guru_nama }}
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
  <th width="5%" class="text-center">
    <input type="checkbox" id="chkCheckAll"> <label for="chkCheckAll"> All</label></th>
    <th>Nama Siswa</th>
      @foreach ($dataekstrakulikuler as $dj)
        <th class="text-center"> {{ $dj->nama }} </th>
      @endforeach

      @foreach ($datakepribadian as $dj)
        <th class="text-center"> {{ $dj->nama }} </th>
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
@foreach ($datasiswa as $ds)
<tr>
  <td> </td>
  <td> {{ $ds->nis }} - {{ $ds->nama }}</td>
  @foreach ($dataekstrakulikuler as $dj)
  @php
    $nama=$dj->nama;
    $ceknilai = DB::table('nilaiekstrakulikuler')
      ->where('siswa_nis', '=', $ds->nis)
      ->where('kelas_nama', '=', $ds->kelas_nama)
      ->where('ekstrakulikuler_nama', '=', $dj->nama)
      // ->where('jenisnilai_nama', '=', $dj->nama)
      ->count();

      $ambilnilai = DB::table('nilaiekstrakulikuler')
                            ->where('siswa_nis', '=', $ds->nis)
                            ->where('kelas_nama', '=', $ds->kelas_nama)
                          ->where('ekstrakulikuler_nama', '=', $dj->nama)
                          // ->where('jenisnilai_nama', '=', $dj->nama)
                            ->first();

  @endphp
    <td class="text-center">
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

  <input class="form-control-plaintext form-control2 no-border text-center btn btn-{{ $warna }}" data-toggle="modal" data-target="#pilihekstra{{ $ds->id }}_{{ $dj->id }}" id="idpilihekstra{{ $ds->id }}_{{ $dj->id }}" readonly value="{{ $nilai }}">
  {{-- <button class="btn btn-icon btn-{{ $warna }}" data-toggle="modal" data-target="#pilihekstra{{ $ds->id }}_{{ $dj->id }}"> {{ $nilai }} </button> --}}
   
    </td>
  @endforeach

  @foreach ($datakepribadian as $dj)
  @php
    $nama=$dj->nama;
    $ceknilai = DB::table('nilaikepribadian')
      ->where('siswa_nis', '=', $ds->nis)
      ->where('kelas_nama', '=', $ds->kelas_nama)
      ->where('kepribadian_nama', '=', $dj->nama)
      // ->where('jenisnilai_nama', '=', $dj->nama)
      ->count();

      $ambilnilai = DB::table('nilaikepribadian')
                            ->where('siswa_nis', '=', $ds->nis)
                            ->where('kelas_nama', '=', $ds->kelas_nama)
                          ->where('kepribadian_nama', '=', $dj->nama)
                          // ->where('jenisnilai_nama', '=', $dj->nama)
                            ->first();

  @endphp
    <td class="text-center">
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

  <input class="form-control-plaintext form-control2 no-border text-center btn btn-{{ $warna }}" data-toggle="modal" data-target="#pilihkepribadian{{ $ds->id }}_{{ $dj->id }}" id="idpilihkepribadian{{ $ds->id }}_{{ $dj->id }}" readonly value="{{ $nilai }}">
       
  {{-- <button class="btn btn-icon btn-{{ $warna }}" data-toggle="modal" data-target="#pilihkepribadian{{ $ds->id }}_{{ $dj->id }}"> {{ $nilai }} </button> --}}
   
    </td>
  @endforeach
  <td class="text-center">
     <a href="{{ url('/raport') }}/{{ $ds->nis }}"  type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Lihat raport siswa" target="_blank"><i class="fas fa-print"></i></a>
      
  </td>
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
                          <table class="table table-bordered table-md">
                          <tr>
                              @yield('headtable')
                          </tr>
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
                @foreach ($dataekstrakulikuler as $dj)

                  <div class="modal fade" id="pilihekstra{{ $ds->id }}_{{ $dj->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      {{-- <form method="post" action="/admin/inputnilai/ekstra/{{ $dj->id }}/{{ $kelas->id }}/{{ $ds->id }}" enctype="multipart/form-data"> --}}
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Input nilai</h5>
                          </div>
                          <div class="modal-body">
               
                            {{ csrf_field() }}
               
                            {{-- <label>Pilih</label> --}}
                            <div class="form-group">
                              <input type="hidden" name="siswa_nama{{ $ds->id }}_{{ $dj->id }}" value="{{ $ds->nama }}">
                              <input type="hidden" name="siswa_nis{{ $ds->id }}_{{ $dj->id }}" value="{{ $ds->nis }}">
                            
                          @php
                          $ceknilai = DB::table('nilaiekstrakulikuler')
                            ->where('siswa_nis', '=', $ds->nis)
                            ->where('kelas_nama', '=', $ds->kelas_nama)
                          ->where('ekstrakulikuler_nama', '=', $dj->nama)
                            ->count();

                          $ambilnilai = DB::table('nilaiekstrakulikuler')
                            ->where('siswa_nis', '=', $ds->nis)
                            ->where('kelas_nama', '=', $ds->kelas_nama)
                            ->where('ekstrakulikuler_nama', '=', $dj->nama)
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
                              <input type="number" name="nilai{{ $ds->id }}_{{ $dj->id }}" min="1" max="100"  class="form-control @error('nilai') is-invalid @enderror"value="{{ $nilai }}" required autofocus id="kkmekstra{{ $ds->id }}_{{ $dj->id }}">
                              @error('nilai')<div class="invalid-feedback"> {{$message}}</div>
                              @enderror
                            </div>
               
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="#" class="btn btn-icon btn-primary btn-sm tombol-simpanekstra{{ $ds->id }}_{{ $dj->id }}"
                                data-toggle="tooltip" data-placement="top" title="Simpan Data!"><span
                                    class="pcoded-micon" id="tombol-simpanekstra{{ $ds->id }}_{{ $dj->id }}"> Simpan</span></a>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <script type="text/javascript">
                    $(document).ready(function(){

                    $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });


                    var idpilihekstra{{ $ds->id }}_{{ $dj->id }} = document.getElementById('idpilihekstra{{ $ds->id }}_{{ $dj->id }}');
                    var kkmekstra{{ $ds->id }}_{{ $dj->id }} = document.getElementById('kkmekstra{{ $ds->id }}_{{ $dj->id }}');


                    $(".tombol-simpanekstra{{ $ds->id }}_{{ $dj->id }}").click(function(e){
                      e.preventDefault();

                  var siswa_nis = $("input[name=siswa_nis{{ $ds->id }}_{{ $dj->id }}]").val();
                  var siswa_nama = $("input[name=siswa_nama{{ $ds->id }}_{{ $dj->id }}]").val();
                  var nilai = $("input[name=nilai{{ $ds->id }}_{{ $dj->id }}]").val();


                            $.ajax({
                            url: "/admin/inputnilaiajax/ekstra/{{ $dj->id }}/{{ $kelas->id }}/{{ $ds->id }}",
                            method:'POST',
                            data:{
                             "_token": "{{ csrf_token() }}",
                             siswa_nis:siswa_nis, 
                             siswa_nama:siswa_nama,
                              nilai:nilai
                            },
                            success:function(response){
                            if(response.success){
                              // console.log(kkmekstra{{ $ds->id }}_{{ $dj->id }}.value);
                            //  vtdnilaisiswa{{ $ds->id }}_{{ $dj->id }} = vkkm{{ $ds->id }}_{{ $dj->id }}.value;
                            idpilihekstra{{ $ds->id }}_{{ $dj->id }}.value = kkmekstra{{ $ds->id }}_{{ $dj->id }}.value;
                            //  vtdnilaisiswa{{ $ds->id }}_{{ $dj->id }}.class ="btn btn-icon btn-light";
                             
                              // console.log(vtdnilaisiswa{{ $ds->id }}_{{ $dj->id }}.val());
                            // alert(response.message) //Message come from controller
                            $('#pilihekstra{{ $ds->id }}_{{ $dj->id }}').modal('hide');
                            // alert(response.message) //Message come from controller
                            }else{
                            alert("Error")
                            // alert(response.message) //Message come from controller
                            }
                            },
                            error:function(error){

                            alert('Gagal! Angka harus 1-100!') //Message come from controller
                            console.log(error)
                            }
                            });


                          });

                    });
                    </script>
                @endforeach
                
              @endforeach


              @foreach ($datasiswa as $ds)
                @foreach ($datakepribadian as $dj)

                  <div class="modal fade" id="pilihkepribadian{{ $ds->id }}_{{ $dj->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      {{-- <form method="post" action="/admin/inputnilai/kepribadian/{{ $dj->id }}/{{ $kelas->id }}/{{ $ds->id }}" enctype="multipart/form-data"> --}}
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Input nilai</h5>
                          </div>
                          <div class="modal-body">
               
                            {{ csrf_field() }}
               
                            {{-- <label>Pilih</label> --}}
                            <div class="form-group">
                              <input type="hidden" name="siswa_nama{{ $ds->id }}_{{ $dj->id }}" value="{{ $ds->nama }}">
                              <input type="hidden" name="siswa_nis{{ $ds->id }}_{{ $dj->id }}" value="{{ $ds->nis }}">
                            
                          @php
                          $ceknilai = DB::table('nilaikepribadian')
                            ->where('siswa_nis', '=', $ds->nis)
                            ->where('kelas_nama', '=', $ds->kelas_nama)
                          ->where('kepribadian_nama', '=', $dj->nama)
                            ->count();

                          $ambilnilai = DB::table('nilaikepribadian')
                            ->where('siswa_nis', '=', $ds->nis)
                            ->where('kelas_nama', '=', $ds->kelas_nama)
                            ->where('kepribadian_nama', '=', $dj->nama)
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
                              <input type="number" name="nilaikepribadian{{ $ds->id }}_{{ $dj->id }}" min="1" max="100" class="form-control @error('nilai') is-invalid @enderror"value="{{ $nilai }}" required autofocus id="kkmkepribadian{{ $ds->id }}_{{ $dj->id }}">
                              @error('nilai')<div class="invalid-feedback"> {{$message}}</div>
                              @enderror
                            </div>
               
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="#" class="btn btn-icon btn-primary btn-sm tombol-simpankepribadian{{ $ds->id }}_{{ $dj->id }}"
                                data-toggle="tooltip" data-placement="top" title="Simpan Data!"><span
                                    class="pcoded-micon" id="tombol-simpankepribadian{{ $ds->id }}_{{ $dj->id }}"> Simpan</span></a>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <script type="text/javascript">
                    $(document).ready(function(){

                    $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });


                    var idpilihkepribadian{{ $ds->id }}_{{ $dj->id }} = document.getElementById('idpilihkepribadian{{ $ds->id }}_{{ $dj->id }}');
                    var kkmkepribadian{{ $ds->id }}_{{ $dj->id }} = document.getElementById('kkmkepribadian{{ $ds->id }}_{{ $dj->id }}');


                    $(".tombol-simpankepribadian{{ $ds->id }}_{{ $dj->id }}").click(function(e){
                      e.preventDefault();

                  var siswa_nis = $("input[name=siswa_nis{{ $ds->id }}_{{ $dj->id }}]").val();
                  var siswa_nama = $("input[name=siswa_nama{{ $ds->id }}_{{ $dj->id }}]").val();
                  var nilai = $("input[name=nilaikepribadian{{ $ds->id }}_{{ $dj->id }}]").val();


                            $.ajax({
                            url: "/admin/inputnilaiajax/kepribadian/{{ $dj->id }}/{{ $kelas->id }}/{{ $ds->id }}",
                            method:'POST',
                            data:{
                             "_token": "{{ csrf_token() }}",
                             siswa_nis:siswa_nis, 
                             siswa_nama:siswa_nama,
                              nilai:nilai
                            },
                            success:function(response){
                            if(response.success){
                              // console.log(kkmekstra{{ $ds->id }}_{{ $dj->id }}.value);
                            //  vtdnilaisiswa{{ $ds->id }}_{{ $dj->id }} = vkkm{{ $ds->id }}_{{ $dj->id }}.value;
                            idpilihkepribadian{{ $ds->id }}_{{ $dj->id }}.value = kkmkepribadian{{ $ds->id }}_{{ $dj->id }}.value;
                            //  vtdnilaisiswa{{ $ds->id }}_{{ $dj->id }}.class ="btn btn-icon btn-light";
                             
                              // console.log(vtdnilaisiswa{{ $ds->id }}_{{ $dj->id }}.val());
                            // alert(response.message) //Message come from controller
                            $('#pilihkepribadian{{ $ds->id }}_{{ $dj->id }}').modal('hide');
                            // alert(response.message) //Message come from controller
                            }else{
                            alert("Error")
                            // alert(response.message) //Message come from controller
                            }
                            },
                            error:function(error){

                            alert('Gagal! Angka harus 1-100!') //Message come from controller
                            console.log(error)
                            }
                            });


                          });

                    });
                    </script>
                @endforeach
                
              @endforeach
          
          

@endsection
