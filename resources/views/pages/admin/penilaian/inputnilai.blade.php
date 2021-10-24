@extends('layouts.default')

@section('title')
Input Nilai
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

                <div id="babeng-bar" class="text-center mt-2">

                    <div id="babeng-row ">

                        <form action="{{ route('penilaian.cari') }}" method="GET">
                            <input type="text" class="babeng babeng-select  ml-0" name="cari">

                            <span>
                                <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                    value="Cari">
                            </span>
</form>

                    </div>
                </div>

                <x-jsmultidel link="{{route('mapel.multidel')}}" />

                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th width="8%" class="text-center py-2" rowspan="2"  style="vertical-align: middle;"> No</th>
                            <th rowspan="2"  style="vertical-align: middle;">Nama</th>
                            @forelse ($datakd as $dk)
                                @php
                                    if($dk->tipe==1){
                                        $preffix='3.';
                                    }else{
                                        $preffix='4.';
                                    }
                                @endphp
                            <th colspan="{{$dk->materipokok!=null?$dk->materipokok->count():1}}"  class="text-center">{{$dk->kode!=null? $preffix.$dk->kode : ' - '}}</th>
                            @empty
                            <th>-</th>
                            @endforelse
                        </tr>
                        <tr style="background-color: #F1F1F1">
                            @forelse ($datakd as $dk)
                                @php
                                    if($dk->tipe==1){
                                        $preffix='3.';
                                    }else{
                                        $preffix='4.';
                                    }
                                @endphp

                               @forelse ($dk->materipokok as $dm)
                                    <td class="text-center">{{$dm->nama!=null? $preffix.$dk->kode.".".$loop->index+1 : ' - '}}</td>
                                @empty
                                    <td class="text-center"> - </td>
                                @endforelse

                            @empty

                            @endforelse
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">
                                    {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
                                <td>
                                    {{$data->nama!=null ? $data->nomerinduk.' - '.$data->nama : 'Data tidak ditemukan' }}
                                </td>
                                @forelse ($datakd as $dk)
                                    @php
                                        if($dk->tipe==1){
                                            $preffix='3.';
                                        }else{
                                            $preffix='4.';
                                        }
                                    @endphp

                                   @forelse ($dk->materipokok as $dm)
                                        <td class="text-center">{{$dm->nama!=null? $preffix.$dk->kode.".".$loop->index+1 : ' - '}}</td>
                                    @empty
                                        <td class="text-center"> - </td>
                                    @endforelse

                                @empty

                                @endforelse
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

@php
$cari=$request->cari;
@endphp
{{ $datas->onEachSide(1)
  ->links() }}

            </div>
        </div>
    </div>
</section>
@endsection
