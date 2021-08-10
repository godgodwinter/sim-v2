@php
    if(empty($pages)){
        $pages='kosong';
    }

    $ambilsettings = DB::table('settings')
      ->where('id', '=', '1')
      ->get();
      foreach ($ambilsettings as $settings) {
      }
@endphp



{{-- DATALAPORAN --}}
@php
$sumpemasukan = DB::table('pemasukan')
  ->sum('nominal');

$countpemasukan = DB::table('pemasukan')
  ->count();

$countpengeluaran = DB::table('pengeluaran')
  ->count();


$sumpengeluaran = DB::table('pengeluaran')
  ->sum('nominal');

$sumtagihansiswa = DB::table('tagihansiswadetail')
  ->sum('nominal');

$counttagihansiswa = DB::table('tagihansiswadetail')
  ->count();

$sisasaldo=$sumpemasukan+$sumtagihansiswa-$sumpengeluaran;


$ambilkepsek = DB::table('users')
->where('tipeuser','kepsek')
  ->get();
  foreach ($ambilkepsek as $kepsek) {
      # code...
  }
@endphp
{{-- DATALAPORAN-END --}}


@section('title')
Laporan Pemasukan dan Pengeluaran di {{ $settings->sekolahnama }}
@endsection

@section('kepsek')
{{ $kepsek->name }}
@endsection

@section('alamat')
{{ $settings->sekolahalamat }}
@endsection

@section('telp')
{{ $settings->sekolahtelp }}
@endsection

@section('namasekolah')
{{ $settings->sekolahnama }}
@endsection

@section('logo','logotutwuri.png')

{{-- DATATABLE --}}
@section('headtable')
  <th width="5%" class="text-center">#</th>
  <th>Judul </th>
  <th>Jumlah Transaksi </th>
  <th>Jumlah </th>
@endsection


@section('bodytable')
<tr>
    <td align="center">1</td>
    <td align="left">Pemasukan</td>
    <td align="center">{{ $countpemasukan }}</td>
    <td align="center">@currency($sumpemasukan)</td>
    
  </tr>
  <tr>
    <td  align="center">2</td>
    <td>Pembayaran Siswa</td>
    <td align="center">{{ $counttagihansiswa }}</td>
    <td align="center">@currency($sumtagihansiswa)</td>
  
  </tr>
  <tr>
    <td  align="center">3</td>
    <td>Pengeluaran</td>
    <td align="center">{{ $countpengeluaran }}</td>
    <td align="center">@currency($sumpengeluaran)</td>
   
  </tr>
  <tr>
    <td  align="center">4</td>
    <td colspan="2">Sisa Saldo</td>
    <td align="center">@currency($sisasaldo)</td>
    
  </tr>


@endsection
{{-- DATATABLE-END --}}

    
<x-layout-cetak-satu />