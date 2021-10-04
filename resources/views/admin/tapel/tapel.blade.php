@section('title','Tahun Pelajaran')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','Tapel')

@section('csshere')
@endsection

@section('jshere')
@endsection
{{--
@section('headernav')
@endsection--}}

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
  <th>Tahun Pelajaran </th>
  <th width="100px" class="text-center">Aksi</th>
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
          url:"{{ route('tapel.multidel') }}",
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
    <td class="text-center">  <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->id }}"> {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
    <td>{{ $data->nama }}</td>

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

<div class="row ">
<div class="col-12 col-md-12 col-lg-12">

  <div class="row">
      <div class="col-12 col-md-12 col-lg-7">
        <x-layout-table2 pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>
      </div>
      <div class="col-12 col-md-12 col-lg-5">
        <x-table-tapel-add pages="{{ $pages }}" />
      </div>
{{--
      <div class="col-12 col-md-12 col-lg-7">
        <x-layout-table2 pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>
      </div>
      <div class="col-12 col-md-12 col-lg-5">
        <x-table-tapel-add pages="{{ $pages }}" />
      </div>

      <div class="col-12 col-md-12 col-lg-7">
        <x-layout-table2 pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>
      </div>
      <div class="col-12 col-md-12 col-lg-5">
        <x-table-tapel-add pages="{{ $pages }}" />
      </div> --}}
    </div>
    </div>
  </div>
@endsection

@section('container-modals')

              <!-- Import Excel -->
              <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route('tapel.import') }}" enctype="multipart/form-data">
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
