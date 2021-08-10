@extends('layouts.layoutadmin1')

@section('title','Kategori')
@section('halaman','kategori')

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

@if (session('status'))

  <div class="alert alert-{{ $tipe }} alert-has-icon alert-dismissible show fade">
    <div class="alert-icon"><i class="{{ $icon }}"></i></div>
                      <div class="alert-body">
                        <div class="alert-title">{{ Str::ucfirst($tipe) }}</div>
                        <button class="close" data-dismiss="alert">
                          <span>&times;</span>
                        </button>
                        {{ session('status') }}
                      </div>
                    </div>
@endif
@endsection 

@section('container')

  <div class="section-body">

    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-5">
        <div class="card profile-widget">
          <div class="profile-widget-header">
            <img alt="image" src="{{ asset("assets/") }}/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Tabel </div>
                <div class="profile-widget-item-value">@yield('title')</div>
                {{-- <h4>Simple Table</h4> --}}
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Jumlah Data</div>
                <div class="profile-widget-item-value">{{ $jmldata }} Data</div>
              </div>
            </div>
          </div>

           
        
                  
                    <div class="card-body -mt-5">
                      <div class="table-responsive">
                        <table class="table table-bordered table-md">
                          <tr>
                            <th width="5%" class="text-center">#</th>
                            <th>Nama</th>
                            <th>Prefix</th>
                            <th width="20%" class="text-center">Aksi</th>
                          </tr>

                        @foreach ($datas as $data)
                          <tr>
                            <td>{{ ($loop->index)+1 }}</td>
                            <td>{{ $data->nama }}</td>
                            <th>{{ ucfirst($data->prefix) }}</th>
                          
                            <td>
                                <a href="/admin/{{ $pages }}/{{$data->id}}" class="btn btn-icon btn-warning"><i class="fas fa-edit"></i></a>
                                {{-- <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a> --}}
                                <form action="/admin/{{ $pages }}/{{$data->id}}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-icon btn-danger"
                                        onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><span
                                            class="pcoded-micon"> <i class="fas fa-trash"></i></span></button>
                                </form>
                            </td>
                          </tr>
                          @endforeach
                        
                        </table>
                      </div>
                    </div>
            
       
      
        </div>


     
      </div>
      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
          <form action="/admin/{{  $pages }}/{{ $kategori->id}}" method="post">
              @method('put')
              @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-6 col-6">
                    <label for="nama">Nama <code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{$kategori->nama}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                 

                  <div class="form-group col-md-6 col-6">
                    <label>Prefix <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="prefix"> 
                      @if ($kategori->prefix)
                      <option value="{{ $kategori->prefix }}">{{ucfirst($kategori->prefix)}}</option>                        
                      @endif
                      <option value="pegawai">Pegawai</option>
                      <option value="pemasukan">Pemasukan</option>
                      <option value="pengeluaran">Pengeluaran</option>
                    </select>
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
