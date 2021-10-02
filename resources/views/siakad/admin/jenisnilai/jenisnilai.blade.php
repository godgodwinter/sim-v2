{{-- @extends('layouts.layoutadminv3') --}}
@section('title','Jenis Nilai')

@section('halaman')
<div class="breadcrumb-item"><a href="{{route('siakadjenisnilai')}}"> Jenis Nilai</a></div>
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
  <th width="10%" class="text-center">
    <input type="checkbox" id="chkCheckAll"> <label for="chkCheckAll"> All</label></th>
  <th> Nama </th>
  <th> Kode </th>
  <th> Tipe </th>
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
@foreach ($datas as $data)
<tr id="sid{{ $data->id }}">
    <td class="text-center">  <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->id }}">  {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
    <td>{{ $data->nama }}</td>
    <td>{{ $data->kode }}</td>
    <td>{{ $data->tipe }}</td>

    <td class="text-center">
        <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
        <x-button-delete link="/admin/{{ $pages }}/{{$data->id}}" />
    </td>
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

      <div class="col-12 col-md-12 col-lg-8">
        <x-layout-table2 pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>
      </div>
      <div class="col-12 col-md-12 col-lg-4">
        <div class="card">
            <form action="/admin/{{ $pages }}" method="post">
                @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-12 col-12">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="X IPA 1" value="{{old('nama')}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-12 col-12">
                    <label for="kode">Kode</label>
                    <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="X IPA 1" value="{{old('kode')}}" required>
                    @error('kode')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                <div class="form-group col-md-12 col-12">
                  <label>Tipe <code>*)</code></label>
                  <select class="form-control form-control-lg @error('tipe') is-invalid @enderror" required name="tipe">


                        <option >Pengetahuan</option>
                        <option >Ketrampilan</option>
                  </select>
                  @error('tipe')<div class="invalid-feedback"> {{$message}}</div>
                  @enderror
                </div>



                </div>


                <div class="row">
                  <div class="form-group mb-0 col-12">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">


                    </div>
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
