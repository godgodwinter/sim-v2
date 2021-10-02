{{-- @extends('layouts.layoutadminv3') --}}

@section('title','Pegawai')
@section('halaman')
<div class="breadcrumb-item"><a href="{{route('pegawai')}}"> Pegawai</a></div>
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
<th class="text-center" width="5%">
    <input type="checkbox" id="chkCheckAll"> <label for="chkCheckAll"> All</label>
</th>
  <th>Nama</th>
  <th>Jabatan</th>
  <th>Email</th>
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
          url:"{{ route('pegawai.multidel') }}",
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
<tr id="sid{{ $data->nig }}">
  <td class="text-center">
      <input type="checkbox" name="ids" class="checkBoxClass" value="{{ $data->nig }}"> {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>

    <td>{{ $data->nama }}</td>
    <td>{{ $data->kategori_nama }}</td>
        @php
        $ambilemail = DB::table('users')
          ->where('nomerinduk', '=', $data->nig)
          ->get();
        @endphp
        @foreach ($ambilemail as $ae)
          @php
            $email=$ae->email;
          @endphp
        @endforeach
    <td> {{ $email }} </td>
    <td class="text-center">
      <x-button-reset-pass link="/admin/{{ $pages }}/{{$data->id}}/reset" />
        <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
        <x-button-delete link="/admin/{{ $pages }}/{{$data->id}}" />
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
@php
  $cari=$request->cari;
  $kategori_nama=$request->kategori_nama;
@endphp
  {{-- {{ $datas->appends(['cari'=>$request->cari,'yearmonth'=>$request->yearmonth,'kategori_nama'=>$request->kategori_nama])->links() }} --}}
  {{ $datas->onEachSide(1)
    ->appends(['cari'=>$cari])
    ->appends(['kategori_nama'=>$kategori_nama])
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
            <form action="{{ route('pegawai.cari') }}" method="GET">
              <div class="row">
                  <div class="form-group col-md-2 col-2 mt-1 text-right">
                    <input type="text" name="cari" id="cari" class="form-control form-control-md @error('cari') is-invalid @enderror" value="{{$request->cari}}"  placeholder="Cari...">
                    @error('cari')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-2 col-2 mt-1 text-right">

                    <select class="form-control form-control-sm" name="kategori_nama">
                      @if($request->kategori_nama)
                        <option>{{$request->kategori_nama}}</option>
                      @else
                       <option value="" disabled selected>Pilih Jabatan</option>
                      @endif

                  @foreach ($kategori as $t)
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
              <a href="/admin/{{  $pages }}/#add" type="submit" value="CARI" class="btn btn-icon btn-primary btn-sm"><span
                class="pcoded-micon"> <i class="far fa-plus-square"></i> Tambah @yield('title')</span></a href="$add">

              <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#importExcel"><i class="fas fa-upload"></i>
                Import
              </button>

              <a href="/admin/data{{  $pages }}/export" type="submit" value="Import" class="btn btn-icon btn-primary btn-sm"><span
                    class="pcoded-micon"> <i class="fas fa-download"></i> Export </span></a href="$add">





              </div>
          </div>


        <x-layout-table pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>
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
                    <label for="nig">Nomor Induk <code>*)</code></label>
                    <input type="number" name="nig" id="nig" class="form-control @error('nig') is-invalid @enderror" value="{{old('nig')}}" required>
                    @error('nig')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="nama">Nama <code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                  <div class="form-group col-md-6 col-6">
                    <label for="alamat">Alamat <code>*)</code></label>
                    <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{old('alamat')}}" required>
                    @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                  <div class="form-group col-md-6 col-6">
                    <label for="telp">No HP <code>*)</code></label>
                    <input type="text" name="telp" id="telp" class="form-control @error('telp') is-invalid @enderror" value="{{old('telp')}}" required>
                    @error('telp')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                  <div class="form-group col-md-6 col-6">
                    <label>Kategori <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="kategori_nama">
                          @if (old('kategori_nama'))
                          <option>{{old('kategori_nama')}}</option>
                          @endif
                      @foreach ($kategori as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                    </select>
                  </div>


                  <div class="form-group col-md-6 col-6">
                    <label for="email">Email <code>*)</code></label>
                    <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" onblur="duplicateEmail(this)"  required>
                    @error('email')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password">Password <code>*)</code></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password2">Konfirmasi Password <code>*)</code></label>
                    <input type="password" name="password2" id="password2" class="form-control @error('password2') is-invalid @enderror"  required>
                    @error('password2')<div class="invalid-feedback"> {{$message}}</div>
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
                  <form method="post" action="{{ route('pegawai.import') }}" enctype="multipart/form-data">
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

