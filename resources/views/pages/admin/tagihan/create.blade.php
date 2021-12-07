@extends('layouts.default')

@section('title')
Tagihan
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
            <div class="breadcrumb-item"><a href="{{route('tagihan')}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Tambah</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Tambah</h5>
            </div>
            <div class="card-body">

                <form action="{{route('tagihan.store')}}" method="post">
                    @csrf

                    <div class="row">

                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="nama">Nama Tagihan  <code>*)</code></label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}" required>
                        @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label for="total">Total Tagihan  <code>*)</code></label>
                        <input type="text" name="total" id="total" class="form-control @error('total') is-invalid @enderror" value="{{old('total')}}" required>
                        @error('total')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>
                    @push('before-script')
                        <script>

                                /* Dengan Rupiah */
                                var dengan_rupiah = document.getElementById('total');
                                dengan_rupiah.addEventListener('keyup', function(e)
                                {
                                    dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
                                });

                                /* Fungsi */
                                function formatRupiah(angka, prefix)
                                {
                                    var number_string = angka.replace(/[^,\d]/g, '').toString(),
                                        split    = number_string.split(','),
                                        sisa     = split[0].length % 3,
                                        rupiah     = split[0].substr(0, sisa),
                                        ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

                                    if (ribuan) {
                                        separator = sisa ? '.' : '';
                                        rupiah += separator + ribuan.join('.');
                                    }

                                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                                    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                                }
                        </script>
                    @endpush

                    {{-- <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <label>Tipe <code>*)</code></label>
                        <select class="form-control form-control-lg" required name="tipe">
                              @if (old('tipe'))
                              <option>{{old('tipe')}}</option>
                              @endif
                          @foreach ($tipe as $t)
                              <option>{{ $t->nama }}</option>
                          @endforeach
                        </select>
                      </div> --}}
                    <div class="form-group col-md-3 col-3 mt-0 ml-5">
                        <label class="form-label">Pilih Tingkatan</label>
                        <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="tingkatan" value="Semua" class="selectgroup-input" checked="">
                            <span class="selectgroup-button">Semua</span>
                        </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="tingkatan" value="X" class="selectgroup-input" >
                            <span class="selectgroup-button">X</span>
                          </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="tingkatan" value="XI" class="selectgroup-input">
                            <span class="selectgroup-button">XI</span>
                          </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="tingkatan" value="XII" class="selectgroup-input">
                            <span class="selectgroup-button">XII</span>
                          </label>

                        </div>
                      </div>
                      <div class="form-group col-md-3 col-3 mt-0 ml-5">
                        <label class="form-label">Pilih Jurusan</label>
                        <div class="selectgroup w-100">
                          <label class="selectgroup-item">
                            <input type="radio" name="jurusan" value="Semua" class="selectgroup-input" checked="">
                            <span class="selectgroup-button">Semua</span>
                          </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="jurusan" value="OTO" class="selectgroup-input" >
                            <span class="selectgroup-button">OTO</span>
                          </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="jurusan" value="TKJ" class="selectgroup-input">
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
                            <input type="radio" name="semester" value="1" class="selectgroup-input" {{Fungsi::semesteraktif()==1 ? 'checked=""' : ''}}>
                            <span class="selectgroup-button">1</span>
                          </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="semester" value="2" class="selectgroup-input" {{Fungsi::semesteraktif()==2 ? 'checked=""' : ''}}>
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
