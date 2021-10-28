@extends('layouts.default')

@section('title')
Beranda
@endsection

@push('before-script')

@if (session('status'))
<x-sweetalertsession tipe="{{session('tipe')}}" status="{{session('status')}}"/>
@endif
@endpush

@if((Auth::user()->tipeuser)=='admin')

@include('pages.admin.dashboard.dashboard_admin')

@elseif((Auth::user()->tipeuser)=='guru')

@include('pages.admin.dashboard.dashboard_guru')

@elseif((Auth::user()->tipeuser)=='siswa')
@include('pages.admin.dashboard.dashboard_siswa')

@else
@endif
