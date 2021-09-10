
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

  <button class="btn btn-icon btn-{{ $warna }}" data-toggle="modal" data-target="#pilihekstra{{ $ds->id }}_{{ $dj->id }}"> {{ $nilai }} </button>
   
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

  <button class="btn btn-icon btn-{{ $warna }}" data-toggle="modal" data-target="#pilihkepribadian{{ $ds->id }}_{{ $dj->id }}"> {{ $nilai }} </button>
   
    </td>
  @endforeach
  <td class="text-center">
     <a href="{{ url('/raport') }}/{{ $ds->nis }}"  type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Lihat raport siswa"><i class="fas fa-print"></i></a>
      
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

              @foreach ($datasiswa as $ds)
                @foreach ($dataekstrakulikuler as $dj)

                  <div class="modal fade" id="pilihekstra{{ $ds->id }}_{{ $dj->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <form method="post" action="/admin/inputnilai/ekstra/{{ $dj->id }}/{{ $kelas->id }}/{{ $ds->id }}" enctype="multipart/form-data">
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
                              <input type="number" name="nilai" min="1" max="100" id="nilai" class="form-control @error('nilai') is-invalid @enderror"value="{{ $nilai }}" required autofocus>
                              @error('nilai')<div class="invalid-feedback"> {{$message}}</div>
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


              @foreach ($datasiswa as $ds)
                @foreach ($datakepribadian as $dj)

                  <div class="modal fade" id="pilihkepribadian{{ $ds->id }}_{{ $dj->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <form method="post" action="/admin/inputnilai/kepribadian/{{ $dj->id }}/{{ $kelas->id }}/{{ $ds->id }}" enctype="multipart/form-data">
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
                              <input type="number" name="nilai" min="1" max="100" id="nilai" class="form-control @error('nilai') is-invalid @enderror"value="{{ $nilai }}" required autofocus>
                              @error('nilai')<div class="invalid-feedback"> {{$message}}</div>
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
