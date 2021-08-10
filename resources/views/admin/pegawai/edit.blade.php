@extends('layouts.layoutadmin1')

@section('title','Pegawai')
@section('halaman','pegawai')

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

@section('container')
@foreach ($datausers as $du)
  
@endforeach

  <div class="section-body">


    <div class="row ">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('pegawai.cari') }}" method="GET">
              <div class="row">
                  <div class="form-group col-md-2 col-2 mt-1 text-right">
                    <input type="text" name="cari" id="cari" class="form-control form-control-sm @error('cari') is-invalid @enderror" value="{{$request->cari}}"  placeholder="Cari...">
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
         
              <button type="submit" value="CARI" class="btn btn-icon btn-info btn-sm mt-1" ><span
              class="pcoded-micon"> <i class="fas fa-search"></i> Pecarian</span></button>

                  </div>
               
             
            </form>
            <div class="form-group col-md-4 col-4 mt-1 text-right">
              <a href="/admin/{{  $pages }}/#add" type="submit" value="CARI" class="btn btn-icon btn-primary btn-sm"><span
                class="pcoded-micon"> <i class="far fa-plus-square"></i> Tambah @yield('title')</span></a href="$add">




              </div>
          </div>
        </div>
      </div>
    </div>
    </div>
            

    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
          <form action="/admin/{{  $pages }}/{{ $pegawai->id}}" method="post">
              @method('put')
              @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-6 col-6">
                    <label for="nig">Nomor Induk <code>*)</code></label>
                    <input type="number" name="nig" id="nig" class="form-control @error('nig') is-invalid @enderror" value="{{$pegawai->nig}}" required>
                    @error('nig')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                 
                  <div class="form-group col-md-6 col-6">
                    <label for="nama">Nama <code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{$pegawai->nama}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                 

                  <div class="form-group col-md-6 col-6">
                    <label for="alamat">Alamat <code>*)</code></label>
                    <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{$pegawai->alamat}}" required>
                    @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                  <div class="form-group col-md-6 col-6">
                    <label for="telp">No HP <code>*)</code></label>
                    <input type="text" name="telp" id="telp" class="form-control @error('telp') is-invalid @enderror" value="{{$pegawai->telp}}" required>
                    @error('telp')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                  <div class="form-group col-md-6 col-6">
                    <label>Kategori <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="kategori_nama">  
                          @if ($pegawai->kategori_nama)
                          <option>{{$pegawai->kategori_nama}}</option>                        
                          @endif
                      @foreach ($kategori as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                    </select>
                  </div>


                 
                  <div class="form-group col-md-6 col-6">
                    <label for="email">Email <code>*)</code></label>
                    <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $du->email }}" onblur="duplicateEmail(this)"  required>
                    @error('email')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password">Password <code>*) Kosongkan Password jika tidak ingin mengubah</code></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="">
                    @error('password')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password2">Konfirmasi Password <code>*)</code></label>
                    <input type="password" name="password2" id="password2" class="form-control @error('password2') is-invalid @enderror" value="">
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
