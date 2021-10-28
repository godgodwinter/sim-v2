@extends('layouts.default')

@section('title')
Generate Data Ujian Siswa
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

                        <form action="{{ route('settings.passwordujian.generate') }}" method="POST">
                            @csrf
                            <label for="">Jumlah Karakter</label>
                            <input type="text" class="babeng babeng-select  ml-0" name="jml" value="6" class="form-control " max="25" min="2" placeholder="Jumlah Karakter">

                            <span>
                                <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                    value="Generate" >
                            </span>

                            <a href="{{route('settings.passwordujian.export')}}" type="submit" value="Import"
                                class="btn btn-icon btn-primary btn-sm ml-2"><span class="pcoded-micon"> <i
                                        class="fas fa-download"></i> Export Data Ujian Siswa </span></a> </form>

                    </div>
                </div>


            </div>
        </div>
    </div>
</section>
@endsection
