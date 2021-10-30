@extends('layouts.default')

@section('title')
Bank Soal {{$dataajar->mapel->nama}} - {{$dataajar->kelas->tingkatan}} {{$dataajar->kelas->jurusan}} {{$dataajar->kelas->suffix}}
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
            <div class="breadcrumb-item"><a href="{{route('dataajar.banksoal',$dataajar->id)}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Edit</h5>
            </div>
            <div class="card-body">

                <form action="{{route('dataajar.banksoal.update',[$dataajar->id,$id->id])}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-6 col-6 mt-0 ml-5">
                            <label class="form-label">Jenis Soal</label>
                            <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="kategorisoal_nama" value="1" class="selectgroup-input" {{$id->kategorisoal_nama =='1' ? 'checked=""' : 'disabled'}}  >
                                <span class="selectgroup-button">Pilihan Ganda</span>
                            </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="kategorisoal_nama" value="2" class="selectgroup-input" {{$id->kategorisoal_nama =='2' ? 'checked=""' : 'disabled'}}  >
                                <span class="selectgroup-button">Pilihan Ganda Kompleks</span>
                              </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="kategorisoal_nama" value="3" class="selectgroup-input"  {{$id->kategorisoal_nama =='3' ? 'checked=""' : 'disabled'}} >
                                <span class="selectgroup-button">True/False</span>
                              </label>

                            </div>
                          </div>
                          @push('before-script')
                          <script>
                    $(document).ready(function() {
                    let formtipe1=`
                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="jawaban1">Pilihan A <code>*)</code></label>
                            <input type="text" name="jawaban1" id="jawaban1" class="form-control @error('jawaban1') is-invalid @enderror" value="{{old('jawaban1')}}" required>
                            @error('jawaban1')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-2 col-2 mt-0 ml-5">
                            <label class="form-label">Hasil Jawaban A</label>
                            <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="jawaban_hasil1" value="Benar" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Benar</span>
                            </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="jawaban_hasil1" value="Salah" class="selectgroup-input" >
                                <span class="selectgroup-button">Salah</span>
                              </label>

                            </div>
                          </div>
                          <div class="form-group col-md-5 col-5 mt-0 ml-5">
                              <label for="jawaban2">Pilihan B <code>*)</code></label>
                              <input type="text" name="jawaban2" id="jawaban2" class="form-control @error('jawaban2') is-invalid @enderror" value="{{old('jawaban2')}}" >
                              @error('jawaban2')<div class="invalid-feedback"> {{$message}}</div>
                              @enderror
                          </div>
                          <div class="form-group col-md-2 col-2 mt-0 ml-5">
                              <label class="form-label">Hasil Jawaban B</label>
                              <div class="selectgroup w-100">
                              <label class="selectgroup-item">
                                  <input type="radio" name="jawaban_hasil2" value="Benar" class="selectgroup-input" >
                                  <span class="selectgroup-button">Benar</span>
                              </label>
                                <label class="selectgroup-item">
                                  <input type="radio" name="jawaban_hasil2" value="Salah" class="selectgroup-input" checked="">
                                  <span class="selectgroup-button">Salah</span>
                                </label>

                              </div>
                            </div>
                            <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                <label for="jawaban3">Pilihan C <code>*)</code></label>
                                <input type="text" name="jawaban3" id="jawaban3" class="form-control @error('jawaban1') is-invalid @enderror" value="{{old('jawaban3')}}" >
                                @error('jawaban3')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-2 col-2 mt-0 ml-5">
                                <label class="form-label">Hasil Jawaban C</label>
                                <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="jawaban_hasil3" value="Benar" class="selectgroup-input" >
                                    <span class="selectgroup-button">Benar</span>
                                </label>
                                  <label class="selectgroup-item">
                                    <input type="radio" name="jawaban_hasil3" value="Salah" class="selectgroup-input" checked="">
                                    <span class="selectgroup-button">Salah</span>
                                  </label>

                                </div>
                              </div>
                              <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                  <label for="jawaban4">Pilihan D <code>*)</code></label>
                                  <input type="text" name="jawaban4" id="jawaban4" class="form-control @error('jawaban4') is-invalid @enderror" value="{{old('jawaban4')}}" >
                                  @error('jawaban4')<div class="invalid-feedback"> {{$message}}</div>
                                  @enderror
                              </div>
                              <div class="form-group col-md-2 col-2 mt-0 ml-5">
                                  <label class="form-label">Hasil Jawaban D</label>
                                  <div class="selectgroup w-100">
                                  <label class="selectgroup-item">
                                      <input type="radio" name="jawaban_hasil4" value="Benar" class="selectgroup-input" >
                                      <span class="selectgroup-button">Benar</span>
                                  </label>
                                    <label class="selectgroup-item">
                                      <input type="radio" name="jawaban_hasil4" value="Salah" class="selectgroup-input" checked="">
                                      <span class="selectgroup-button">Salah</span>
                                    </label>

                                  </div>
                                </div>
                                <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                    <label for="jawaban5">Pilihan E <code>*)</code></label>
                                    <input type="text" name="jawaban5" id="jawaban5" class="form-control @error('jawaban5') is-invalid @enderror" value="{{old('jawaban5')}}" >
                                    @error('jawaban5')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2 col-2 mt-0 ml-5">
                                    <label class="form-label">Hasil Jawaban E</label>
                                    <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="jawaban_hasil5" value="Benar" class="selectgroup-input" >
                                        <span class="selectgroup-button">Benar</span>
                                    </label>
                                      <label class="selectgroup-item">
                                        <input type="radio" name="jawaban_hasil5" value="Salah" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Salah</span>
                                      </label>

                                    </div>
                                  </div>`;




                    let formtipe3=`

                        <div class="form-group col-md-2 col-2 mt-0 ml-5">
                            <label class="form-label"> Jawaban 1</label>
                            <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="jawaban_hasil1" value="Benar" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Benar</span>
                            </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="jawaban_hasil1" value="Salah" class="selectgroup-input" >
                                <span class="selectgroup-button">Salah</span>
                              </label>

                            </div>
                          </div>

                          <div class="form-group col-md-2 col-2 mt-0 ml-5">
                              <label class="form-label"> Jawaban 2</label>
                              <div class="selectgroup w-100">
                              <label class="selectgroup-item">
                                  <input type="radio" name="jawaban_hasil2" value="Benar" class="selectgroup-input" >
                                  <span class="selectgroup-button">Benar</span>
                              </label>
                                <label class="selectgroup-item">
                                  <input type="radio" name="jawaban_hasil2" value="Salah" class="selectgroup-input" checked="">
                                  <span class="selectgroup-button">Salah</span>
                                </label>

                              </div>
                            </div>
                           `;


                                let kategorisoal_nama=$('input[name="kategorisoal_nama"]');
                                $(kategorisoal_nama).click(function () {
                                        const jenissoal = $('input[name=kategorisoal_nama]:checked').val();
                                        periksa(jenissoal);
                                        // alert(jenissoal);
                                });
                                function periksa(jenissoal) {
                                    if(jenissoal==1){
                                        //  $('#formjawaban').html(formtipe1);
                                    }else if(jenissoal==2){
                                        //  $('#formjawaban').html(formtipe1);
                                    }else{
                                        //  $('#formjawaban').html(formtipe3);
                                    }

                                }
                            });


                          </script>

                          @endpush


                        <div class="form-group col-md-3 col-3 mt-0 ml-5">
                            <label class="form-label">Tingkat Kesulitan</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    @php
                                        $warna='info';
                                        if($id->tingkatkesulitan=='sulit'){
                                            $warna='danger';
                                        }elseif($id->tingkatkesulitan=='sedang'){
                                            $warna='warning';
                                        }
                                    @endphp
                                    <input type="text" class="form-control btn-{{ $warna }} text-capitalize" name="tingkatkesulitan" value="{{ $id->tingkatkesulitan }}"  id="tk" >
                                </label>


                            </div>
                          </div>
@push('after-style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="{{ asset("assets/") }}/stisla/summernote-bs4.js"></script>
@endpush
                          <div class="form-group col-md-6 col-12 ml-5 mb-5">
                            <label for="nama">Pertanyaan</label> :
                            <textarea  class="form-control" style="min-width: 100%;height:100%;" name="pertanyaan"
                                id="pertanyaan"  >{{$id->pertanyaan}}</textarea>
                        </div>
                        @push('after-script')
                        <script>

                            $(document).ready(function() {
                                let pertanyaan=$('#pertanyaan');

                            // fungsi kirim data periksa
                            function kirimkatakata(datapertanyaan = '') {
                            // console.log(datapertanyaan);
                                $.ajax({
                                    url: "{{ route('api.banksoal.periksatingkatkesulitan') }}",
                                    method: 'GET',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        pertanyaan:datapertanyaan,
                                    },
                                    dataType: 'json',
                                    success: function (data) {
                                        // console.log(data.output);
                                        // console.log(data.datas);
                                        $('#tk').val(data.output);
                                        $('#tk').prop('class',data.warna);

                                        // switalert('success',data.output);
                                        // console.log(data.output);
                                        // $("#datasiswa").html(data.output);
                                        // console.log(data.output);
                                        // console.log(data.datas);
                                    }
                                })
                            }

                                $('#pertanyaan').keyup(function () {
                                    // console.log(pertanyaan.val());
                                    kirimkatakata(pertanyaan.val());
                                });

                                // $('#pertanyaan').summernote({focus: true});
                            });
                        </script>
                        <script type="text/javascript">
                            $(document).ready(function() {
                              $.uploadPreview({
                                input_field: "#image-upload",   // Default: .image-upload
                                preview_box: "#image-preview",  // Default: .image-preview
                                label_field: "#image-label",    // Default: .image-label
                                label_default: "Gambar Soal",   // Default: Choose File
                                label_selected: "Ganti Gambar",  // Default: Change File
                                no_label: false                 // Default: false
                              });



                            });
                        </script>
                @endpush
                        <div class="form-group col-md-3 col-3 mt-0 ml-5">
                            <div id="image-preview" class="image-preview  @error('file') is-invalid @enderror">
                                <label for="image-upload" id="image-label">Tambah Gambar</label>
                                <input type="file" name="file" id="image-upload" />
                        @error('file')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                            </div>
                  </div>


                    </div>
                    <div class="row" id="formjawaban">
                        @if ($id->kategorisoal_nama==1 OR $id->kategorisoal_nama==2)


                        @forelse ($id->banksoaljawaban as $j)
                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="jawaban{{$loop->index+1}}">Pilihan  {{Fungsi::periksaabc($loop->index+1)}} <code>*)</code></label>
                            <input type="text" name="jawaban{{$loop->index+1}}" id="jawaban1" class="form-control @error('jawaban1') is-invalid @enderror" value="{{$j->jawaban}}" required>
                            @error('jawaban1')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-2 col-2 mt-0 ml-5">
                            <label class="form-label">Hasil Jawaban  {{Fungsi::periksaabc($loop->index+1)}}</label>
                            <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="jawaban_hasil{{$loop->index+1}}" value="Benar" class="selectgroup-input" {{$j->hasil=='Benar' ? 'checked=""' : ''}}>
                                <span class="selectgroup-button">Benar</span>
                            </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="jawaban_hasil{{$loop->index+1}}" value="Salah" class="selectgroup-input" {{$j->hasil=='Salah' ? 'checked=""' : ''}}>
                                <span class="selectgroup-button">Salah</span>
                              </label>

                            </div>
                          </div>

                                  @empty

                                  @endforelse
                                  @if($id->banksoaljawaban->count()<5)
                                        @php
                                            $datalama=$id->banksoaljawaban->count();
                                            $jml=5-($id->banksoaljawaban->count());
                                        @endphp
                                        @for ($i = 0; $i < $jml; $i++)

                                <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                    <label for="jawaban{{$i+1+$datalama}}">Pilihan Jawaban {{$i+1+$datalama}} <code>*)</code></label>
                                    <input type="text" name="jawaban{{$i+1+$datalama}}" id="jawaban{{$i+1+$datalama}}" class="form-control @error('jawaban5') is-invalid @enderror" value="{{old('jawaban5')}}" >
                                    @error('jawaban5')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2 col-2 mt-0 ml-5">
                                    <label class="form-label">Hasil Jawaban {{$i+1+$datalama}}</label>
                                    <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="jawaban_hasil{{$i+1+$datalama}}" value="Benar" class="selectgroup-input" >
                                        <span class="selectgroup-button">Benar</span>
                                    </label>
                                      <label class="selectgroup-item">
                                        <input type="radio" name="jawaban_hasil{{$i+1+$datalama}}" value="Salah" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Salah</span>
                                      </label>

                                    </div>
                                  </div>


                                        @endfor

                                  @endif


                        @else

                        <div class="form-group col-md-2 col-2 mt-0 ml-5">
                            <label class="form-label"> Jawaban </label>
                            <div class="selectgroup w-100">
                            @forelse ($id->banksoaljawaban as $j)
                                <label class="selectgroup-item">
                                    <input type="radio" name="jawaban_hasil" value="{{$j->jawaban}}" class="selectgroup-input" {{$j->hasil=='Benar' ? 'checked=""' : ''}}>
                                    <span class="selectgroup-button">{{$j->jawaban}}</span>
                                </label>



                            @empty

                            @endforelse

                        </div>
                    </div>


                        @endif
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
