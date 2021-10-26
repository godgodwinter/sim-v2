@extends('layouts.default')

@section('title')
Tahun Pelajaran
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
            <div class="breadcrumb-item"><a href="{{route('siswa')}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Edit</h5>
            </div>
            <div class="card-body">

                <form action="{{route('siswa.update',$id->id)}}" method="post">
                    @method('put')
                    @csrf

                    <div class="row">

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="nomerinduk">Nomer Induk <code>*)</code></label>
                            <input type="text" name="nomerinduk" id="nomerinduk" class="form-control @error('nomerinduk') is-invalid @enderror" value="{{old('nomerinduk') ? old('nomerinduk') : $id->nomerinduk}}" required>
                            @error('nomerinduk')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="nama">Nama Lengkap<code>*)</code></label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama') ? old('nama') : $id->nama}}" required>
                            @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>


                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="tempatlahir">Tempat Lahir<code>*)</code></label>
                            <input type="text" name="tempatlahir" id="tempatlahir" class="form-control @error('tempatlahir') is-invalid @enderror" value="{{old('tempatlahir') ? old('tempatlahir') : $id->tempatlahir}}" required>
                            @error('tempatlahir')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="tgllahir">Tanggal Lahir<code>*)</code></label>
                            <input type="date" name="tgllahir" id="tgllahir" class="form-control @error('tgllahir') is-invalid @enderror" value="{{old('tgllahir') ? old('tempatlahir') : $id->tgllahir}}" required>
                            @error('tgllahir')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>


                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="agama">Pilih Agama <code></code></label>

                            <select class="form-control  @error('agama') is-invalid @enderror" name="agama" required>
                                <option>{{$id->agama}}</option>
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
                            <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{old('alamat') ? old('alamat') : $id->alamat}}" required>
                            @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="jk">Pilih Jenis Kelamin <code></code></label>

                            <select class="form-control  @error('jk') is-invalid @enderror" name="jk" required>
                                <option>{{$id->jk}}</option>
                                <option>Laki-laki</option>
                                <option>Perempuan</option>
                            </select>
                            @error('jk')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>


                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="tapel_id">Pilih Tahun Pelajaran <code></code></label>

                            <select class="form-control  @error('tapel_id') is-invalid @enderror" name="tapel_id" required>
                                @foreach ($t1 as $t)
                                    <option value="{{$id->tapel_id}}">{{$t->nama}}</option>
                                @endforeach

                                @forelse ($tapel as $d)

                                    <option value="{{$d->id}}">{{$d->nama}}</option>
                                @empty
                                    <option value=""> Data belum tersedia</option>
                                @endforelse
                            </select>
                            @error('tapel_id')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>


                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="kelas_id">Pilih Kelas <code></code></label>

                            <select class="form-control  @error('kelas_id') is-invalid @enderror" name="kelas_id" required>
                                @foreach ($k1 as $k)
                                    <option value="{{$id->kelas_id}}">{{$k->tingkatan.' '.$k->jurusan}}</option>
                                @endforeach
                                @forelse ($kelas as $d)
                                    <option value="{{$d->id}}">{{$d->tingkatan.' '.$d->jurusan}}</option>
                                @empty
                                    <option value=""> Data belum tersedia</option>
                                @endforelse
                            </select>
                            @error('kelas_id')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>


                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="email">Email<code></code></label>
                            @foreach ( $u as $us)
                            <input type="text" class="form-control  @error('email') is-invalid @enderror" name="email" required  value="{{old('email') ? old('email') : $us->email}}"/>
                            @endforeach


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


                            <input type="text" class="form-control  @error('moodleuser') is-invalid @enderror" name="moodleuser"  value="{{old('moodleuser') ? old('moodleuser') : $id->moodleuser}}" required>

                            @error('moodleuser')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div> --}}

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="moodlepass">Password Ujian<code></code></label>


                            <input type="text" class="form-control  @error('moodlepass') is-invalid @enderror" name="moodlepass" value="{{old('moodleuser') ? old('moodlepass') : $id->moodlepass}}" required>

                            @error('moodlepass')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>
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

                        @php
                        $siswa=asset('/storage/').'/'.$id->siswafoto;
                        $randomimg='https://ui-avatars.com/api/?name='.$id->nama.'&color=7F9CF5&background=EBF4FF';
                        @endphp
                    <img alt="image" src="{{$id->siswafoto!=null  ? $siswa : $randomimg }}" class="img-thumbnail" data-toggle="tooltip" title="{{$id->nama}}" width="250px" height="300px" style="object-fit:cover;">
                    </div>
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

                    <div class="card-footer text-right mr-5">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</section>
@endsection
