@extends('layouts.layoutadminv3')

@section('title','Pelanggaran')
@section('halaman')
<div class="breadcrumb-item"><a href="{{route('pelanggaran')}}"> Master Pelanggaran</a></div>
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

<tr id="sid{{ $data->id }}">
  <td class="text-center">
      <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->id }}"> {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
    <td>{{ $data->nama }}</td>
    <td>{{ $data->point }} </td>

    <td class="text-center">
        <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
        <x-button-delete link="/admin/{{ $pages }}/{{$data->id}}" />
    </td>
  </tr>
@endforeach

@endsection

@section('foottable')
@php
  $cari=$request->cari;
@endphp
  {{-- {{ $datas->appends(['cari'=>$request->cari,'yearmonth'=>$request->yearmonth,'kategori_nama'=>$request->kategori_nama])->links() }} --}}
  {{ $datas->onEachSide(1)
    ->appends(['cari'=>$cari])
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
            <form action="{{ route($pages.'.cari') }}" method="GET">
              <div class="row">
                  <div class="form-group col-md-2 col-2 text-right">
                    <input type="text" name="cari" id="cari" class="form-control form-control-md @error('cari') is-invalid @enderror" value="{{$request->cari}}"  placeholder="Cari...">
                    @error('cari')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


              <div class="form-group   text-right">

              <button type="submit" value="CARI" class="btn btn-icon btn-info btn-md mt-1" ><span
              class="pcoded-micon"> <i class="fas fa-search"></i> Pecarian</span></button>

                  </div>


            </form>
            <div class="form-group col-md-4 col-4 mt-1 text-right">
              <a href="/admin/{{  $pages }}/#add"  class="btn btn-icon btn-primary btn-sm"><span
                class="pcoded-micon"> <i class="far fa-plus-square"></i> Tambah </span></a href="$add">


              <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#importExcel"><i class="fas fa-upload"></i>
                Import
              </button>




              <a href="/admin/data{{  $pages }}/export" type="submit" value="Import" class="btn btn-icon btn-primary btn-sm"><span
                    class="pcoded-micon"> <i class="fas fa-download"></i> Export </span></a href="$add">


              <button type="button" class="btn btn-icon btn-danger btn-sm" data-toggle="modal" data-target="#cleartemp"><i class="fas fa-trash"></i>
                      Clear Temp
                    </button>




              </div>
          </div>

        <x-layout-table pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>

       </div>
       </div>

      <div class="col-12 col-md-12 col-lg-12" id="add">
        <div class="card">
            <form action="/admin/{{ $pages }}" method="post">
                @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">

                  <div class="form-group col-md-6 col-6">
                    <label for="nama">Nama <code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6 col-6">
                    <label for="point">Point <code>*)</code></label>
                    <input type="number" name="point" id="point" class="form-control @error('point') is-invalid @enderror" value="{{old('point')}}" required>
                    @error('point')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                </div>

            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>




      </div>
    </div>
  </div>


@endsection

@section('container-modals')

              <!-- Import Excel -->
              <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route('siswa.import') }}" enctype="multipart/form-data">
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


              <!-- Import Excel -->
              <div class="modal fade" id="cleartemp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route('cleartemp') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Temporari</h5>
                      </div>
                      <div class="modal-body">

                        {{ csrf_field() }}

                        <label></label>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus!</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

@endsection

