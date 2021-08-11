@extends('layouts.layoutadmin1')

@section('title','Tagihan Atur')
@section('halaman','tagihanatur')

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
  <th>Tahun</th>
  <th>Kelas</th>
  <th>Nominal Tagihan</th>
  <th width="100px" class="text-center">Aksi</th>
@endsection

@section('bodytable')
@foreach ($datas as $data)
  <tr>
    <td>{{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
    <td>{{ $data->tapel_nama }}</td>
    <td>{{ $data->kelas_nama }}</td>
    <td>@currency($data->nominaltagihan)</td>
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
    <div class="card">
      <div class="card-body">
        <form action="{{ route('tagihanatur.cari') }}" method="GET">
          <div class="row">
              <div class="form-group col-md-2 col-2 mt-1 text-right">
               
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
     
          <button type="submit" value="CARI" class="btn btn-icon btn-info btn-sm mt-1" ><span
          class="pcoded-micon"> <i class="fas fa-search"></i> Pecarian</span></button>

              </div>
           
         
        </form>
        <div class="form-group col-md-4 col-4 mt-1 text-right">
          
          <a href="/admin/datatagihan/addall"  class="btn btn-icon btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Tambah semua kelas yang belum di setting."><span
            class="pcoded-micon"> <i class="far fa-plus-square"></i> Tambah Semua </span></a href="$add">
         
          
          <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#importExcel"><i class="fas fa-upload"></i>
            Import 
          </button>



 
          <a href="/admin/data{{  $pages }}/export" type="submit" value="Import" class="btn btn-icon btn-primary btn-sm"><span
                class="pcoded-micon"> <i class="fas fa-download"></i> Export </span></a href="$add">




          </div>
      </div>
    </div>
  </div>
</div>
</div>
         
  <div class="section-body">
    <p class="section-lead">
     Menu untuk mengatur Nominal Tagihan siswa.
    </p>

    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-5">
        <x-layout-table pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>
       </div> 
      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
            <form action="/admin/{{ $pages }}" method="post">
                @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">

                  <div class="form-group col-md-6 col-6">
                    <label>Tahun Pelajaran <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="tapel_nama">  
                          @if (old('tapel_nama'))
                          <option>{{old('tapel_nama')}}</option>                        
                          @endif
                      @foreach ($tapel as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Kelas <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="kelas_nama">
                          @if (old('kelas_nama'))
                          <option>{{old('kelas_nama')}}</option>                        
                          @endif
                      @foreach ($kelas as $k)
                          <option>{{ $k->nama }}</option>
                      @endforeach
                    </select>
                  </div>
                  


                  @if (old('nominaltagihan'))
                      @php                    
                        $nominaltagihan=old('nominaltagihan');
                      @endphp
                  @else
                      @php
                      $nominaltagihan=1;
                      @endphp                    
                  @endif
                  <div class="form-group col-md-6 col-6">
                    <label for="nominaltagihan">Nominal <code>*)</code> </label>
                    <input type="text" name="labelrupiah" min="0" id="labelrupiah" class="form-control-plaintext" readonly="" value="Rp 1,00" >
                    <input type="number" name="nominaltagihan" min="1" id="rupiah" class="form-control @error('nominaltagihan') is-invalid @enderror" value="{{ $nominaltagihan }}" required >
                    @error('nominaltagihan')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <script type="text/javascript">
                    
                    var rupiah = document.getElementById('rupiah');
                    var labelrupiah = document.getElementById('labelrupiah');
                    rupiah.addEventListener('keyup', function(e){
                      // tambahkan 'Rp.' pada saat form di ketik
                      // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                      // rupiah.value = formatRupiah(this.value, 'Rp. ');
                      labelrupiah.value = formatRupiah(this.value, 'Rp. ');
                    });
                
                    /* Fungsi formatRupiah */
                    function formatRupiah(angka, prefix){
                      var number_string = angka.replace(/[^,\d]/g, '').toString(),
                      split   		= number_string.split(','),
                      sisa     		= split[0].length % 3,
                      rupiah     		= split[0].substr(0, sisa),
                      ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
                
                      // tambahkan titik jika yang di input sudah menjadi angka ribuan
                      if(ribuan){
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                      }
                
                      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                    }
                  </script>
                
                </div>
             
            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary">Simpan</button>
            </div>

            <div class="card-body">
                <div class="section-title mt-0">Catatan : </div>
                <blockquote>
                  Jika Tahun Pelajaran dan Kelas sudah ada maka akan edit data tersebut.
                </blockquote>
              </div>
          </form>
        </div>


        

      </div>
    </div>
  </div>
@endsection
