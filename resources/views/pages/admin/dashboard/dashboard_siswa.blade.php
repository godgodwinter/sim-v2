@section('content')
<section class="section">
    <div class="section-header">
        <h1>Beranda Siswa</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">Dashboard</a></div>
            {{-- <div class="breadcrumb-item"><a href="#">Layout</a></div> --}}
            {{-- <div class="breadcrumb-item">Default Layout</div> --}}
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Profile</h4>
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-primary btn-icon icon-left btn-lg btn-block mb-4 d-md-none"
                            data-toggle-slide="#ticket-items">
                            <i class="fas fa-list"></i> All Tickets
                        </a>
                        <div class="tickets">
                            <div class="ticket-items" id="ticket-items">
                                <div class="ticket-item active">
                                    <div class="ticket-title">
                                        <h4>Data Siswa</h4>
                                    </div>

                                </div>


                            </div>
                            <div class="ticket-content">
                                <div class="ticket-header">
                                    <div class="ticket-sender-picture img-shadow">
                                        <img src="assets/img/avatar/avatar-5.png" alt="image">
                                    </div>
                                    <div class="ticket-detail">
                                        <div class="ticket-title">
                                            <h4>{{$datasiswa->nama}}</h4>
                                        </div>
                                        <div class="ticket-info">
                                            <div class="font-weight-600">{{$datasiswa->kelas!=null?$datasiswa->kelas->tingkatan.' '.$datasiswa->kelas->jurusan.' '.$datasiswa->kelas->suffix : ' Kelas tidak ditemukan'}}</div>
                                            <div class="bullet"></div>
                                            <div class="text-primary font-weight-600">Walikelas :
                                                @php
                                                    if($datasiswa->kelas!=null){
                                                        if($datasiswa->kelas->guru!=null){
                                                            $namawali=$datasiswa->kelas->guru->nama;
                                                        }else{
                                                            $namawali='';
                                                        }
                                                    }else{
                                                        $namawali='';
                                                    }
                                                @endphp
                                                {{$namawali}}
                                                {{-- {{$datasiswa->kelas!=null?$datasiswa->kelas->guru->nama:' - '}} --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ticket-description">

                                    <form action="{{route('siswa.siswa.update',$datasiswa->id)}}" method="post">
                                        @method('put')
                                        @csrf

                                    <div class="row">

                                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                            <label for="nomerinduk">Nomer Induk <code>*)</code></label>
                                            <input type="text" name="nomerinduk" id="nomerinduk" class="form-control @error('nomerinduk') is-invalid @enderror" value="{{old('nomerinduk')?old('nomerinduk'):$datasiswa->nomerinduk}}"  readonly>
                                            @error('nomerinduk')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                            <label for="nama">Nama Lengkap<code>*)</code></label>
                                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')?old('nama'):$datasiswa->nama}}"  readonly>
                                            @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                            <label for="tempatlahir">Tempat Lahir<code>*)</code></label>
                                            <input type="text" name="tempatlahir" id="tempatlahir" class="form-control @error('tempatlahir') is-invalid @enderror" value="{{old('tempatlahir')?old('tempatlahir'):$datasiswa->tempatlahir}}" required>
                                            @error('tempatlahir')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                            <label for="tgllahir">Tanggal Lahir<code>*)</code></label>
                                            <input type="date" name="tgllahir" id="tgllahir" class="form-control @error('tgllahir') is-invalid @enderror" value="{{old('tgllahir')?old('tgllahir'):$datasiswa->tgllahir}}" required>
                                            @error('tgllahir')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                            <label for="agama">Pilih Agama <code></code></label>

                                            <select class="form-control  @error('agama') is-invalid @enderror" name="agama" required>
                                                @if(old('agama'))
                                                <option>{{old('agama')}}</option>
                                                @else
                                                <option>{{$datasiswa->agama}}</option>
                                                @endif
                                                <option>Islam</option>
                                                <option>Kristen</option>
                                                <option>Katholik</option>
                                                <option>Hindu</option>
                                                <option>Budha</option>
                                                <option>Konghucu</option>
                                                <option>Lain-lain</option>
                                            </select>
                                            @error('agama')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                            <label for="alamat">Alamat<code>*)</code></label>
                                            <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{old('alamat')?old('alamat'):$datasiswa->alamat}}" required>
                                            @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                            <label for="jk">Pilih Jenis Kelamin <code></code></label>

                                            <select class="form-control  @error('jk') is-invalid @enderror" name="jk" required>

                                            @if(old('jk'))
                                            <option>{{old('jk')}}</option>
                                            @else
                                            <option>{{$datasiswa->jk}}</option>
                                            @endif
                                             <option>Laki-laki</option>
                                                <option>Perempuan</option>
                                            </select>
                                            @error('jk')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>






                                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                            <label for="email">Email<code></code></label>

                                            <input type="text" class="form-control  @error('email') is-invalid @enderror" name="email" required  value="{{old('email')?old('email'):$datasiswa->users->email}}">

                                            @error('email')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                            <label for="password">Password<code></code></label>


                                            <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" >

                                            @error('password')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                            <label for="password2">Konfirmasi Password<code></code></label>


                                            <input type="password" class="form-control  @error('password2') is-invalid @enderror" name="password2" >

                                            @error('password2')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>

                                        {{-- <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                            <label for="moodleuser">User Ujian<code></code></label>


                                            <input type="text" class="form-control  @error('moodleuser') is-invalid @enderror" name="moodleuser" required>

                                            @error('moodleuser')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div> --}}

                                        @push('after-script')
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                              $.uploadPreview({
                                                input_field: "#image-upload",   // Default: .image-upload
                                                preview_box: "#image-preview",  // Default: .image-preview
                                                label_field: "#image-label",    // Default: .image-label
                                                label_default: "Logo Sekolah",   // Default: Choose File
                                                label_selected: "Ganti Logo Sekolah",  // Default: Change File
                                                no_label: false                 // Default: false
                                              });



                                            });
                                            </script>
                                        @endpush
                                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                                          <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label2">UPLOAD FOTO</label>
                                            <input type="file" name="siswafoto" id="image-upload" class="@error('siswafoto')
                                            is_invalid
                                        @enderror"  accept="image/png, image/gif, image/jpeg" />

                                        @error('siswafoto')<div class="invalid-feedback"> {{$message}}</div>
                                        @enderror
                                          </div>
                                        </div>


                                        </div>



                                    <div class="ticket-divider"></div>

                                    <div class="ticket-form">

                                            <div class="form-group text-right">
                                                <button class="btn btn-primary btn-lg">
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</section>


@endsection
