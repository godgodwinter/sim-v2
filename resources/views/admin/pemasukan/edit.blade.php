@extends('layouts.layoutadmin1')

@section('title','Pemasukan')
@section('halaman','pemasukan')

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
  <th>Nama</th>
  <th>Nominal</th>
  <th width="100px" class="text-center">Aksi</th>
@endsection

@section('bodytable')
@foreach ($datas as $data)
  <tr>
    <td>{{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
    <td>{{ $data->nama }}</td>
    <td>@currency($data->nominal)</td>
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
       </div>  --}}
      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
          <form action="/admin/{{  $pages }}/{{ $pemasukan->id}}" method="post">
              @method('put')
              @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                 
                  <div class="form-group col-md-6 col-6">
                    <label for="nama">Nama <code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{$pemasukan->nama}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                 

                  <div class="form-group col-md-6 col-6">
                    <label for="nominal">Nominal <code>*)</code> </label>
                    <input type="text" name="labelrupiah" min="0" id="labelrupiah" class="form-control-plaintext" readonly="" value="@currency($pemasukan->nominal)" >
                    <input type="number" name="nominal" min="0" id="rupiah" class="form-control @error('nominal') is-invalid @enderror" value="{{ $pemasukan->nominal }}" required>
                    @error('nominal')<div class="invalid-feedback"> {{$pemasukan->nominal}}</div>
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



                  <div class="form-group col-md-6 col-6">
                    <label>Kategori <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="kategori_nama">  
                          @if ($pemasukan->kategori_nama)
                          <option>{{$pemasukan->kategori_nama}}</option>                        
                          @endif
                      @foreach ($kategori as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  @if(!empty($pemasukan->tglbayar))
                    @php
                      $tglbayar=$pemasukan->tglbayar;
                    @endphp
                  @else
                    @php                      
                      $tglbayar=date("Y-m-d")."T".date("H:i"); //2020-04-02T22:55
                    @endphp
                  @endif
                  <div class="form-group col-md-6 col-6">
                    <label for="tglbayar">Tanggal <code>*)</code></label>
                    <input type="datetime-local" name="tglbayar" id="tglbayar" class="form-control @error('tglbayar') is-invalid @enderror" value="{{ $tglbayar }}">
                    @error('tglbayar')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                  <div class="form-group col-md-6 col-6">
                    <label for="catatan">Catatan <code>*)</code></label>
                    <input type="text" name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" value="{{$pemasukan->catatan}}">
                    @error('catatan')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
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
