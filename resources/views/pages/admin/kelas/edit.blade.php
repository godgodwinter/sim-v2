@extends('layouts.default')

@section('title')
Kelas
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
            <div class="breadcrumb-item"><a href="{{route('kelas')}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Edit</h5>
            </div>
            <div class="card-body">

                <form action="{{route('kelas.update',$id->id)}}" method="post">
                    @method('put')
                    @csrf

                    <div class="row">

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="nama">Nama Tahun Pelajaran <code>*)</code></label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama') ? old('nama') : $id->nama}}" required>
                            @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="guru_id">Pilih Walikelas <code></code></label>

                            <select class="form-control  @error('guru_id') is-invalid @enderror" name="guru_id" required>
                                @if($id->guru_id!=null AND $id->guru_id!='' AND $id->guru!=null)
                                    <option value="{{$id->guru_id}}">{{$id->guru->nama}}</option>
                                @endif
                                @forelse ($walikelas as $d)
                                    <option value="{{$d->id}}">{{$d->nomerinduk}} -  {{$d->nama}}</option>
                                @empty
                                    <option value=""> Data belum tersedia</option>
                                @endforelse
                            </select>
                            @error('guru_id')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>


                        </div>

                    <div class="card-footer text-right mr-5">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</section>
@endsection
