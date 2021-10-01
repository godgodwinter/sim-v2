
@section('title','Fungsi KKO')
@section('halaman','kko')

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
@endsection

@section('bodytable')
@endsection

@section('foottable')
@endsection

{{-- DATATABLE-END --}}
@section('container')
  <div class="section-body">
    <div class="row mt-sm-4">

      <div class="col-12 col-md-6 col-lgid-7">
        <div class="card">
          <form action="/admin/{{ $pages }}/{{$kko->id}}" method="post">
              @method('put')
              @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-12 col-12">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="" value="{{ $kko->nama }}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-12 col-12 mt-0">
                    <label for="nama">Pilih Tipe</label>

                    <select class="form-control form-control-sm" name="tipe">
                      <option>{{$kko->tipe}}</option>
                      <option>mudah</option>
                      <option>sedang</option>
                      <option>sulit</option>
                </select>
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