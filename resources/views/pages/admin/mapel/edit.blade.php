@extends('layouts.default')

@section('title')
Mata Pelajaran
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
            <div class="breadcrumb-item"><a href="{{route('mapel')}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Edit</h5>
            </div>
            <div class="card-body">

                <form action="{{route('mapel.update',$id->id)}}" method="post">
                    @method('put')
                    @csrf

                    <div class="row">

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="nama">Nama Mata Pelajaran <code>*)</code></label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama') ? old('nama') : $id->nama}}" required>
                            @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label>Tipe <code>*)</code></label>
                            <select class="form-control form-control-lg" required name="tipe">
                                  @if (old('tipe'))
                                  <option>{{old('tipe')}}</option>
                                  @else
                                  <option>{{$id->tipe}}</option>
                                  @endif
                              @foreach ($tipepelajaran as $t)
                                  <option>{{ $t->nama }}</option>
                              @endforeach
                            </select>
                          </div>
                        <div class="form-group col-md-3 col-3 mt-0 ml-5">
                            <label for="kkm">KKM  <code>*)</code></label>
                            <input type="number" name="kkm" min="1" max="100" id="kkm" class="form-control @error('kkm') is-invalid @enderror" value="{{ old('kkm') ? old('kkm') : $id->kkm}}" required>
                            @error('kkm')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-3 col-3 mt-0 ml-5">
                            <label class="form-label">Pilih Tingkatan</label>
                            <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="tingkatan" value="Semua" class="selectgroup-input" {{$id->tingkatan=='Semua' ? 'checked=""' : ''}}>
                                <span class="selectgroup-button">Semua</span>
                            </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="tingkatan" value="X" class="selectgroup-input" {{$id->tingkatan=='X' ? 'checked=""' : ''}}>
                                <span class="selectgroup-button">X</span>
                              </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="tingkatan" value="XI" class="selectgroup-input" {{$id->tingkatan=='XI' ? 'checked=""' : ''}}>
                                <span class="selectgroup-button">XI</span>
                              </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="tingkatan" value="XII" class="selectgroup-input" {{$id->tingkatan=='XII' ? 'checked=""' : ''}}>
                                <span class="selectgroup-button">XII</span>
                              </label>

                            </div>
                          </div>
                          <div class="form-group col-md-3 col-3 mt-0 ml-5">
                            <label class="form-label">Pilih Jurusan</label>
                            <div class="selectgroup w-100">
                              <label class="selectgroup-item">
                                <input type="radio" name="jurusan" value="Semua" class="selectgroup-input"  {{$id->jurusan=='Semua' ? 'checked=""' : ''}}>
                                <span class="selectgroup-button">Semua</span>
                              </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="jurusan" value="OTO" class="selectgroup-input"  {{$id->jurusan=='OTO' ? 'checked=""' : ''}}>
                                <span class="selectgroup-button">OTO</span>
                              </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="jurusan" value="TKJ" class="selectgroup-input" {{$id->jurusan=='TKJ' ? 'checked=""' : ''}}>
                                <span class="selectgroup-button">TKJ</span>
                              </label>

                            </div>
                          </div>
                          <div class="form-group col-md-3 col-3 mt-0 ml-5">
                            <label class="form-label">Pilih Semester</label>
                            <div class="selectgroup w-100">
                              {{-- <label class="selectgroup-item">
                                <input type="radio" name="semester" value="Semua" class="selectgroup-input" >
                                <span class="selectgroup-button">Semua</span>
                              </label> --}}
                              <label class="selectgroup-item">
                                <input type="radio" name="semester" value="1" class="selectgroup-input"  {{$id->semester=='1' ? 'checked=""' : ''}}>
                                <span class="selectgroup-button">1</span>
                              </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="semester" value="2" class="selectgroup-input" {{$id->semester=='2' ? 'checked=""' : ''}}>
                                <span class="selectgroup-button">2</span>
                              </label>

                            </div>
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
