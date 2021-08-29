@extends('layouts.layoutadmin1')

@section('title','Pengaturan')
@section('halaman','settings')

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

@php
$tipeuser=(Auth::user()->tipeuser);
@endphp

@if(($tipeuser)==='kepsek')
  @php
      $hakakses='Kepala Sekolah';
  @endphp
@elseif(($tipeuser)==='admin')
@php
    $hakakses='Administrator';
@endphp
@elseif(($tipeuser)==='siswa')
@php
    $hakakses='Siswa';
@endphp
@endif



{{-- DATALAPORAN --}}
@php
$sumpemasukan = DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])
  ->sum('nominal');

$countpemasukan = DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])
  ->count();

$sumpemasukanbos = DB::table('pemasukan')->where('kategori_nama','Dana Bos')
  ->sum('nominal');

$countpemasukanbos = DB::table('pemasukan')->where('kategori_nama','Dana Bos')
  ->count();

$countpengeluaran = DB::table('pengeluaran')
  ->count();


$sumpengeluaran = DB::table('pengeluaran')
  ->sum('nominal');

$sumtagihansiswa = DB::table('tagihansiswadetail')
  ->sum('nominal');

$counttagihansiswa = DB::table('tagihansiswadetail')
  ->count();

$totalpemasukan=$sumpemasukan+$sumtagihansiswa+$sumpemasukanbos;
$sisasaldo=$totalpemasukan-$sumpengeluaran;


$ambilkepsek = DB::table('users')
->where('tipeuser','kepsek')
  ->get();
  foreach ($ambilkepsek as $kepsek) {
      # code...
  }
@endphp
{{-- DATALAPORAN-END --}}
@section('container')


{{-- <div class="section-header">
    <h1>Typography</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>
      <div class="breadcrumb-item">Typography</div>
    </div>
  </div> --}}


  <div class="section-body">
    <h2 class="section-title">Hi, {{ Auth::user()->name }}  ! </h2>
    <p class="section-lead">
     Berikut beberapa pengaturan yang dapat di ubah di Sistem Ini. Pastikan tahun pelajaran aktif di pilih dengan benar!
    </p>

    <div class="row mt-sm-4">


      <div class="col-12 col-md-12 col-lg-12">

        @if($tipeuser!=='siswa')

        <div class="card profile-widget">
          <div class="profile-widget-header">
            <img alt="image" src="../assets/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <h3 class="ml-5 mt-4">Pengaturan Web</h3>
            </div>

            <div class="card">
              <form action="/admin/settings/1" method="post">
                  @csrf

                  <div class="row">
                    <div class="form-group col-md-12 col-12 mt-5 ml-5">
                     <h5>Pengaturan Aplikasi</h5>
                    </div>

                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                      <label for="aplikasijudul">Nama Aplikasi <code>*)</code></label>
                      <input type="text" name="aplikasijudul" id="aplikasijudul" class="form-control @error('aplikasijudul') is-invalid @enderror" value="{{$aplikasijudul}}" required>
                      @error('aplikasijudul')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>

                    <div class="form-group col-md-5 col-5 mt-3 ml-5">
                      <label for="aplikasijudulsingkat">Nama Aplikasi (Singkat) <code>*) 2/3 Huruf</code></label>
                      <input type="text" name="aplikasijudulsingkat" id="aplikasijudulsingkat" class="form-control @error('aplikasijudulsingkat') is-invalid @enderror" value="{{$aplikasijudulsingkat}}" required>
                      @error('aplikasijudulsingkat')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>

                  <div class="form-group col-md-5 col-5 mt-3 ml-5">
                    <label for="paginationjml">Pagination <code>*)</code></label>
                    <input type="number" name="paginationjml" id="paginationjml" class="form-control @error('paginationjml') is-invalid @enderror" value="{{$paginationjml}}" required>
                    @error('paginationjml')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                    <div class="form-group col-md-12 col-12 mt-5 ml-5">
                      <h5>Tentang Sekolah</h5>
                     </div>
                    <div class="form-group col-md-5 col-5 mt-3 ml-5">
                      <label for="sekolahnama">Nama Sekolah <code>*)</code></label>
                      <input type="text" name="sekolahnama" id="sekolahnama" class="form-control @error('sekolahnama') is-invalid @enderror" value="{{$sekolahnama}}" required>
                      @error('sekolahnama')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
                    <div class="form-group col-md-5 col-5 mt-3 ml-5">
                      <label for="sekolahalamat">Alamat Sekolah <code>*)</code></label>
                      <input type="text" name="sekolahalamat" id="sekolahalamat" class="form-control @error('sekolahalamat') is-invalid @enderror" value="{{$sekolahalamat}}" required>
                      @error('sekolahalamat')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
                    <div class="form-group col-md-5 col-5 mt-3 ml-5">
                      <label for="sekolahtelp">Telp Sekolah <code>*)</code></label>
                      <input type="text" name="sekolahtelp" id="sekolahtelp" class="form-control @error('sekolahtelp') is-invalid @enderror" value="{{$sekolahtelp}}" required>
                      @error('sekolahtelp')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>


                    <div class="form-group col-md-12 col-12 mt-5 ml-5">
                      <h5>Pengaturan Password dan data Default</h5>
                     </div>

            <div class="form-group col-md-5 col-5  mt-3 ml-5">
              <label>Tahun Pelajaran Aktif<code>*)</code></label>
              <select class="form-control form-control-lg @error('tapelaktif') is-invalid @enderror" required name="tapelaktif">  
                    @if ($tapelaktif)
                    <option>{{$tapelaktif}}</option>                        
                    @endif
                @foreach ($tapel as $t)
                    <option>{{ $t->nama }}</option>
                @endforeach
              </select>
              @error('tapelaktif')<div class="invalid-feedback"> {{$message}}</div>
              @enderror
            </div>


            @if ($nominaltagihandefault)
            @php                    
              $nominaltagihandefault=$nominaltagihandefault;
            @endphp
        @else
            @php
            $nominaltagihandefault=1;
            @endphp                    
        @endif
        <div class="form-group col-md-5 col-5  mt-3 ml-5">
          <label for="nominaltagihandefault">Nominal Default Tagihan Atur <code>*)</code> </label>
          <input type="text" name="labelrupiah" min="0" id="labelrupiah" class="form-control-plaintext" readonly="" value="@currency($nominaltagihandefault)" >
          <input type="number" name="nominaltagihandefault" min="1" id="rupiah" class="form-control @error('nominaltagihandefault') is-invalid @enderror" value="{{ $nominaltagihandefault }}" required >
          @error('nominaltagihandefault')<div class="invalid-feedback"> {{$message}}</div>
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
      

                  <div class="form-group col-md-5 col-5 mt-3 ml-5">
                    <label for="passdefaultsiswa">Pass Siswa Default <code>*)</code></label>
                    <input type="text" name="passdefaultsiswa" id="passdefaultsiswa" class="form-control @error('passdefaultsiswa') is-invalid @enderror" value="{{$passdefaultsiswa}}" required>
                    @error('passdefaultsiswa')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-5 col-5 mt-3 ml-5">
                    <label for="passdefaultortu">Pass Orang Tua Siswa Default <code>*)</code></label>
                    <input type="text" name="passdefaultortu" id="passdefaultortu" class="form-control @error('passdefaultortu') is-invalid @enderror" value="{{$passdefaultortu}}" required>
                    @error('passdefaultortu')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-5 col-5 mt-3 ml-5">
                    <label for="passdefaultpegawai">Pass Pegawai Default <code>*)</code></label>
                    <input type="text" name="passdefaultpegawai" id="passdefaultpegawai" class="form-control @error('passdefaultpegawai') is-invalid @enderror" value="{{$passdefaultpegawai}}" required>
                    @error('passdefaultpegawai')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary">Simpan</button>
            </div>
          
          
            </form>
          </div>
             
              
              
          </div>

       
      
        </div>
        @endif

        @if($tipeuser==='siswa') 
        <div class="card profile-widget mt-5">
          <div class="profile-widget-header">
            <img alt="image" src="../assets/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <h3 class="ml-5 mt-4">Menu Siswa</h3>
            </div>
             
              
              <div class="card-body">
                <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                  <a  href="{{ url('user/profile') }}" type="button" class="btn btn-warning"><i class="fab fa-korvue"></i> Profile</a>
                </div>
                <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                  <a  href="{{ route('siswa.tagihansiswa') }}" type="button" class="btn btn-primary"><i class="fas fa-calendar-alt"></i> Tagihanku</a>
                </div>
              
          </div>
  
       
      
        </div>
          
        @endif
        



    </div>

    <div class="col-12 col-md-12 col-lg-6">

  </div>


  </div>
  
@endsection

@section('container-modals')

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