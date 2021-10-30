@extends('layouts.default')

@section('title')
Kompetensi Dasar {{$dataajar->mapel->nama}} - {{$dataajar->kelas->tingkatan}} {{$dataajar->kelas->jurusan}} {{$dataajar->kelas->suffix}}
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
            <div class="breadcrumb-item"><a href="{{route('silabus')}}">Silabus</a></div>
            <div class="breadcrumb-item"><a href="{{route('dataajar.kompetensidasar',$dataajar->id)}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Tambah</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Tambah</h5>
            </div>
            <div class="card-body">

                <form action="{{route('dataajar.kompetensidasar.store',$dataajar->id)}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-6 col-6 mt-0 ml-5">
                            <label class="form-label">Tipe</label>
                            <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="tipe" value="1" class="selectgroup-input tipekd" checked="" id="tipekd">
                                <span class="selectgroup-button">Pengetahuan</span>
                            </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="tipe" value="2" class="selectgroup-input tipekd" id="tipekd">
                                <span class="selectgroup-button">Ketrampilan</span>
                              </label>

                            </div>
                          </div>
                          @push('before-script')
                          <script>
                    $(document).ready(function() {
                            let tipeisi=1;
                            // fungsi kirim data periksa
                            function kirimtipe(tipeisi = '') {
                            // console.log(datapertanyaan);
                                $.ajax({
                                    url: "{{ route('api.banksoal.kompetensidasargeneratekode',$dataajar->id) }}",
                                    method: 'GET',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        tipe:tipeisi,
                                    },
                                    dataType: 'json',
                                    success: function (data) {
                                        // console.log(data.output);
                                        $('#kodegenerate').val(data.output);
                                    }
                                })
                            }

                        let tipe_isi=1;
                        let tipe=$('input[name=tipe]:checked');
                                $('.tipekd').click(function () {
                                    tipe=$('input[name=tipe]:checked');
                                    //  alert(tipe.val());
                                        let isiprefix='<b>3.</b>';
                                    if(tipe.val()=='2'){
                                         isiprefix='<b>4.</b>';
                                        $('#kodeprefix').html(isiprefix)
                                    }else{
                                         isiprefix='<b>3.</b>';
                                        $('#kodeprefix').html(isiprefix)
                                    }
                                    kirimtipe(tipe.val());
                                });


                            });


                          </script>

                          @endpush


                        <div class="form-group col-md-2 col-2 mt-0 ml-5">
                            <label class="form-label">Kode</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="kodeprefix">
                                        <b>3.</b>
                                    </div>
                                </div>
                                <input type="number" min="1" name="kode" id="kodegenerate"
                                    class="form-control @error('kode') is-invalid @enderror" value="{{ $generatekode }}" required>
                                @error('kode')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>
                          </div>
@push('after-style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="{{ asset("assets/") }}/stisla/summernote-bs4.js"></script>
@endpush
                        <div class="form-group col-md-6 col-12 ml-5">
                        <label for="nama">Judul</label> :
                        <textarea class="form-control " style="min-width: 100%;height:100%;" name="nama"
                            id="nama"  ></textarea>
                        </div>
                        @push('after-script')
                        <script>

                            $(document).ready(function() {
                                // $('#pertanyaan').summernote({focus: true});
                            });
                        </script>

                @endpush



                    </div>
                    <div class="row" id="formjawaban">
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
