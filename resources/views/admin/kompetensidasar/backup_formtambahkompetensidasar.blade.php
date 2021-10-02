
        <div class="col-12 col-md-12 col-lg-4">
            <div class="card">
                <form action="/admin/kompetensidasar/{{$pelajaran_nama}}/{{$kelas_nama}}/{{$tapel_nama}}" method="post">
                    @csrf
                    <div class="card-header">
                        <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH
                            {{ Str::upper($pages) }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12 col-12 mt-0">
                                <label for="nama">Pilih Tipe</label>

                                <select class="form-control form-control-sm" name="tipe" id="kd_tipe" required>


                                    <option disabled selected value="">Pilih</option>

                                    <option value="Pengetahuan">Pengetahuan </option>
                                    <option value="Ketrampilan">Ketrampilan</option>
                                </select>
                                <input type="hidden" name="tapel_nama" value="{{base64_decode($tapel_nama)}}">
                                <input type="hidden" name="kelas_nama" value="{{base64_decode($kelas_nama)}}">
                                <input type="hidden" name="pelajaran_nama" value="{{base64_decode($pelajaran_nama)}}">
                            </div>

                            <script>
                                $(document).ready(function () {
                                    function fetch_customer_data(tipe = '', kelas_nama = '', pelajaran_nama =
                                        '', tapel_nama = '') {
                                        $.ajax({
                                            url: "{{ route('api.fungsi.generate.kompetensidasar') }}",
                                            method: 'GET',
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                tipe: tipe,
                                                kelas_nama: kelas_nama,
                                                pelajaran_nama: pelajaran_nama,
                                                tapel_nama: tapel_nama,
                                            },
                                            dataType: 'json',
                                            success: function (data) {
                                                $('#kodegenerate').val(data.output);
                                                swal({
                                                    title: 'Kode Berhasil di muat',
                                                    text: '',
                                                    icon: 'success',
                                                    timer: 1000,
                                                    buttons: false,
                                                })
                                            }
                                        })
                                    }


                                    $('#kd_tipe').change(function () {
                                        var value = $(this).val();
                                        var kodeprefix = 3;
                                        if (value == 'Ketrampilan') {
                                            kodeprefix = 4;
                                        } else {
                                            kodeprefix = 3;
                                        }
                                        $('#kodeprefix').html('<b>' + kodeprefix + '.</b>');
                                        var kelas_nama = $("input[name=kelas_nama]").val();
                                        var pelajaran_nama = $("input[name=pelajaran_nama]").val();
                                        var tapel_nama = $("input[name=tapel_nama]").val();
                                        // alert(value);
                                        // tipe = $("input[name=tipe]").val();
                                        // console.log(kelas_nama);
                                        var tipe = $(this).val();
                                        fetch_customer_data(tipe, kelas_nama, pelajaran_nama,
                                            tapel_nama);


                                    });

                                });

                            </script>
                            <div class="form-group col-md-12 col-12">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}"
                                    required>
                                @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>
                            {{-- {{dd($generate_kode)}} --}}
                            @if ($generate_kode==null)
                            @php
                            $kode=1;
                            @endphp
                            @else
                            @php
                            $kode=$generate_kode;
                            @endphp
                            @endif
                            {{-- <div class="form-group col-md-12 col-12">
                                <label for="kode">Kode</label>
                                <input type="number" min="1" name="kode" id="kodegenerate"
                                    class="form-control @error('kode') is-invalid @enderror" value="{{$kode}}"
                            required>
                            @error('kode')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div> --}}
                        <div class="form-group col-md-12 col-12">
                            <label>Kode</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="kodeprefix">
                                        <b>3.</b>
                                    </div>
                                </div>
                                <input type="number" min="1" name="kode" id="kodegenerate"
                                    class="form-control @error('kode') is-invalid @enderror" value="{{$kode}}" required>
                                @error('kode')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>


                    </div>


                    <div class="row">
                        <div class="form-group mb-0 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">


                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
