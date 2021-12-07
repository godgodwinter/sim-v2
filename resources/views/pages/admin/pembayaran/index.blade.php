@extends('layouts.default')

@section('title')
Pembayaran
@endsection

@push('before-script')

@if (session('status'))
<x-sweetalertsession tipe="{{session('tipe')}}" status="{{session('status')}}"/>
@endif
@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>@yield('title')</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">Dashboard</a></div>
            {{-- <div class="breadcrumb-item"><a href="#">Layout</a></div> --}}
            <div class="breadcrumb-item">@yield('title')</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">

                {{-- <div class="d-flex bd-highlight mb-3 align-items-center">

                    <div class="p-2 bd-highlight">
                        <form action="{{ route('tagihan.cari') }}" method="GET">
                            <input type="text" class="babeng babeng-select  ml-0" name="cari">
                        </div>
                        <div class="p-2 bd-highlight">

                            <span>
                                <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                    value="Cari">
                            </span>
                        </div>

                        <div class="ml-auto p-2 bd-highlight">
                            <x-button-create link="{{route('tagihan.create')}}"></x-button-create>

                        </form>

                    </div>
                </div> --}}

                <x-jsmultidel link="{{route('tagihan.multidel')}}" />

                @if($datas->count()>0)
                    {{-- <x-jsdatatable/> --}}
                    @push('after-style')
                        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css"> --}}
                        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
                    @endpush
                    @push('before-script')

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                paging: true,
                info: true,
               "pageLength": 10,
                searching: true,
                 "dom": '<lf<t>ip>',

                // "pagingType": "full_numbers",

                // "dom": '<"top"f>rt<"bottom"pil><"clear">'
            });
    $('#example').removeClass( 'display' ).addClass('table table-striped table-bordered table-sm');

        } );
    </script>
                    @endpush
                @endif

                <div style="clear: both;margin-top: 18px;">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row">
                                No</th>
                            <th >Bayar</th>
                            <th >Nama Tagihan </th>
                            <th >Nominal Tagihan</th>
                            <th >Terbayar</th>
                            <th >Kurang</th>
                            <th >% </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">
                                    {{ ((($loop->index)+1)) }}</td>
                                <td class="babeng-min-row">
                                    <button class="btn btn-sm btn-light"><i class="far fa-money-bill-alt"></i></button>
                                </td>
                                <td>
                                    {{Str::limit($data->nama,25,' ...')}}
                                </td>

                                <td>
                                    {{$data->tingkatan}}
                                </td>
                                <td>
                                    {{$data->jurusan}}
                                </td>
                                <td>
                                    {{Fungsi::rupiah($data->total)}}
                                </td>

                                <td class="text-center babeng-min-row">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>

@php
$cari=$request->cari;
@endphp
<div class="d-flex justify-content-between flex-row-reverse mt-3">
    <div >
{{-- {{ $datas->onEachSide(1)
  ->links() }} --}}
    </div>
    <div>

    </div></div>
            </div>
        </div>
    </div>
</section>
@endsection
