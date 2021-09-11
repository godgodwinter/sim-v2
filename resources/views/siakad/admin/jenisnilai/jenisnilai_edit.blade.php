
@section('title','Jenis Nilai')
@section('halaman','jenisnilai')

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
  <th width="5%" class="text-center">#</th>
  <th>Tahun Pelajaran </th>
  <th width="100px" class="text-center">Aksi</th>
@endsection

@section('bodytable')
@foreach ($datas as $data)
  <tr>
    <td>{{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
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
  <div class="section-body">
    <div class="row mt-sm-4">

      {{-- <div class="col-12 col-md-12 col-lg-5">
        <x-layout-table pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>
      </div>     --}}
      <div class="col-12 col-md-6 col-lgid-7">
        <div class="card">
          <form action="/admin/{{ $pages }}/{{$jenisnilai->id}}" method="post">
              @method('put')
              @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-12 col-12">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="X IPA 1" value="{{ $jenisnilai->nama }}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-12 col-12">
                    <label for="kode">Kode</label>
                    <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="X IPA 1" value="{{ $jenisnilai->kode }}" required>
                    @error('kode')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-12 col-12">
                    <label>Tipe <code>*)</code></label>
                    <select class="form-control form-control-lg @error('tipe') is-invalid @enderror" required name="tipe">  
                      
                      @if ($jenisnilai->tipe)
                      <option>{{ $jenisnilai->tipe }}</option>                        
                      @endif
                    
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
              <a href="{{ route($pages) }}" class="btn btn-icon btn-dark ml-3"> <i class="fas fa-backward"></i> Batal</a>
              <button class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>

        

        

      </div>
    </div>
  </div>
@endsection
