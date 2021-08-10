@extends('layouts.layoutadmin1')

@section('title')
{{ ucfirst($pages) }}
@endsection
@section('halaman')
{{ $pages }}
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

{{-- DATALAPORAN --}}
@php
$sumpemasukan = DB::table('pemasukan')
  ->sum('nominal');

$countpemasukan = DB::table('pemasukan')
  ->count();


$sumpengeluaran = DB::table('pengeluaran')
  ->sum('nominal');

$countpengeluaran = DB::table('pengeluaran')
  ->count();


$sumtagihansiswa = DB::table('tagihansiswadetail')
  ->sum('nominal');

$counttagihansiswa = DB::table('tagihansiswadetail')
  ->count();

$sisasaldo=$sumpemasukan+$sumtagihansiswa-$sumpengeluaran;
@endphp
{{-- DATALAPORAN-END --}}

{{-- DATATABLE --}}
@section('headtable')
  <th width="5%" class="text-center">#</th>
  <th>Judul </th>
  <th>Jumlah Transaksi </th>
  <th>Jumlah </th>
  <th width="100px" class="text-center"></th>
@endsection

@section('bodytable')
<tr>
  <td class="text-center">1</td>
  <td>Pemasukan</td>
  <td>{{ $countpemasukan }}</td>
  <td>@currency($sumpemasukan)</td>
  <td class="text-center">
    <a  href="{{ route('pemasukan') }}"  class="btn btn-icon icon-left btn-info btn-sm"><i class="fas fa-search"></i>Detail</a>
  </td>
</tr>
<tr>
  <td class="text-center">2</td>
  <td>Pembayaran Siswa</td>
  <td>{{ $counttagihansiswa }}</td>
  <td>@currency($sumtagihansiswa)</td>
  <td class="text-center">
    <a href="{{ route('tagihansiswa') }}"  class="btn btn-icon icon-left btn-info btn-sm"><i class="fas fa-search"></i>Detail</a>
  </td>
</tr>
<tr>
  <td class="text-center">3</td>
  <td>Pengeluaran</td>
  <td>{{ $countpengeluaran }}</td>
  <td>@currency($sumpengeluaran)</td>
  <td class="text-center">
    <a href="{{ route('pengeluaran') }}"  class="btn btn-icon icon-left btn-info btn-sm"><i class="fas fa-search"></i>Detail</a>
  </td>
</tr>
<tr>
  <td class="text-center">4</td>
  <td>Sisa Saldo</td>
  <td></td>
  <td>@currency($sisasaldo)</td>
  <td class="text-center">
    <a href="{{ route('laporan.cetak') }}" class="btn btn-icon icon-left btn-info btn-sm"><i class="fas fa-print"></i>Cetak</a>
  
  </td>
</tr>


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

      <div class="col-12 col-md-12 col-lg-12">
        <x-layout-table pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>
      </div>    
     
    </div>
  </div>
@endsection
