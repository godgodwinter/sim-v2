@extends('layouts.layoutadminv3')


@section('title','Siswa')
@section('halaman')
<div class="breadcrumb-item"><a href="{{route('siswa')}}"> Siswa</a></div>
<div class="breadcrumb-item"> Index</div>
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
<th class="text-center" width="100px">
    <input type="checkbox" id="chkCheckAll"> <label for="chkCheckAll"> All</label>
</th>
  <th>Nama</th>
  <th>Kelas</th>
  <th>Email</th>
  <th>Photo</th>
  <th width="150px" class="text-center">Aksi</th>
@endsection

@section('bodytable')

<script>
  // console.log('asdad');
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
          url:"{{ route('siswa.multidel') }}",
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

<tr id="sid{{ $data->nis }}">
  <td class="text-center">
      <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->nis }}"> {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
    <td>{{ $data->nis }} - {{ $data->nama }}</td>
    <td>{{ $data->tapel_nama }} - {{ $data->kelas_nama }}</td>

        @php
        $ambilemail = DB::table('users')
        ->where('nomerinduk', '=', $data->nis)
        ->get();
        @endphp
        @foreach ($ambilemail as $ae)
        @php
          $email=$ae->email;
          $profile_photo_path=$ae->profile_photo_path;
        @endphp
        @endforeach
    <td> {{ $email }} </td>
    <td>
      @if($profile_photo_path!='')
              {{-- <img alt="image" src="{{ $ae->profile_photo_url }}" class="rounded-circle mr-1"> --}}
              <img alt="image" src="{{ asset("storage/") }}/{{ $profile_photo_path }}" class="rounded mx-auto d-block" width="50px" height="50px" style="overflow: auto;">
      @else
            <img alt="image" src="https://ui-avatars.com/api/?name={{ $data->nama }}&color=7F9CF5&background=EBF4FF" class="rounded mx-auto d-block" width="50px" height="50px">

      @endif
    </td>
    <td class="text-center">
        <x-button-reset-pass link="/admin/{{ $pages }}/{{$data->id}}/reset" />
    </td>
  </tr>
@endforeach

@endsection

@section('foottable')
@php
  $cari=$request->cari;
  $tapel_nama=$request->tapel_nama;
  $kelas_nama=$request->kelas_nama;
@endphp
  {{-- {{ $datas->appends(['cari'=>$request->cari,'yearmonth'=>$request->yearmonth,'kategori_nama'=>$request->kategori_nama])->links() }} --}}
  {{ $datas->onEachSide(1)
    ->appends(['cari'=>$cari])
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


    <div class="row ">
      <div class="col-12 col-md-12 col-lg-12">
        {{-- <div class="card"> --}}
          {{-- <div class="card-body"> --}}
            <form action="{{ route('settings.resetsiswa.cari') }}" method="GET">
              <div class="row">
                  <div class="form-group col-md-2 col-2 text-right">
                    <input type="text" name="cari" id="cari" class="form-control form-control-md @error('cari') is-invalid @enderror" value="{{$request->cari}}"  placeholder="Cari...">
                    @error('cari')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-2 col-2 text-right">

                    <select class="form-control form-control-sm" name="tapel_nama" >
                    @if($request->tapel_nama)
                      <option>{{$request->tapel_nama}}</option>
                    @else
                     <option value="" disabled selected>Pilih Tahun Pelajaran</option>
                    @endif
                  @foreach ($tapel as $t)
                      <option>{{ $t->nama }}</option>
                  @endforeach
                </select>
                  </div>
                  <div class="form-group  col-md-2 col-2 text-right">

                  <select class="form-control form-control-sm" name="kelas_nama">
                    @if($request->kelas_nama)
                      <option>{{$request->kelas_nama}}</option>
                    @else
                     <option value="" disabled selected>Pilih Kelas</option>
                    @endif

                @foreach ($kelas as $t)
                    <option>{{ $t->nama }}</option>
                @endforeach
              </select>
                  </div>
              <div class="form-group   text-right">

              <button type="submit" value="CARI" class="btn btn-icon btn-info btn-md mt-1" ><span
              class="pcoded-micon"> <i class="fas fa-search"></i> Pecarian</span></button>

                  </div>


            </form>
            <div class="form-group col-md-4 col-4 mt-1 text-right">








              </div>
          </div>
          <div class="card">

            <div id="babeng-bar" class="text-center mt-2" >

                <div id="babeng-row ">

                    <form action="{{ route('settings.resetsiswa.cari') }}" method="GET">
                    <input type="text" name="cari" id="cari" class="babeng babeng-select  ml-2 @error('cari') is-invalid @enderror" value="{{$request->cari}}"  placeholder="Cari...">
                        @error('cari')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                        <select class="babeng babeng-select  ml-2" name="tapel_nama" >
                            @if($request->tapel_nama)
                              <option>{{$request->tapel_nama}}</option>
                            @else
                             <option value="" disabled selected>Tahun Pelajaran</option>
                            @endif
                            <option value="">--semua--</option>
                          @foreach ($tapel as $t)
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


                    <a href="{{ route('settings.resetsemua') }}" class="btn btn-icon btn-primary btn-sm ml-0 ml-sm-4"
                        onclick="return  confirm('Anda yakin mereset semua password login siswa? Y/N')"  data-toggle="tooltip" data-placement="top" title="Untuk mereset semua password login siswa!"><span
                            class="pcoded-micon"> <i class="fas fa-redo"></i> Reset Semua Siswa</span></a>


                        </form>
                    </div>
            </div>


            <div class="card-body -mt-5">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
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
  </div>


@endsection

@section('container-modals')



@endsection
