
@section('title','Edit Siswa')
@section('halaman')
<div class="breadcrumb-item"><a href="{{route('siswa')}}"> Siswa</a></div>
<div class="breadcrumb-item"> Edit</div>
@endsection
@section('csshere')
@endsection

@section('jshere')
@endsection


@section('notif')


@if (session('tipe'))
        @php
        $tipe=session('tipe');
        @endphp
@else
        @php
            $tipe='light';
        @endphp
@endif

@if (session('icon'))
        @php
        $icon=session('icon');
        @endphp
@else
        @php
            $icon='far fa-lightbulb';
        @endphp
@endif

@php
  $message=session('status');
@endphp
@if (session('status'))
<x-alert tipe="{{ $tipe }}" message="{{ $message }}" icon="{{ $icon }}"/>

@endif
@endsection


@section('container')
@foreach ($datausers as $du)

@endforeach

  <div class="section-body">


    </div>


    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">

              <div class="row">
            <div class="card-body">

                {{-- <span class="btn btn-icon btn-light ml-4"><i class="fas fa-feather"></i> EDIT {{ Str::upper($pages) }}</span> --}}


                <form method="post" action="/admin/datasiswa/upload/{{ $siswa->id }}" enctype="multipart/form-data">
                  {{ csrf_field() }}


                  <div class="form-group col-md-3 col-3 ml-4">
                    <div class="col-lg-8 d-flex align-items-stretch mb-4">

                @if($du->profile_photo_path!='')
                {{-- <img alt="image" src="{{ asset("storage/") }}/{{ $du->profile_photo_path }}" class="rounded-circle profile-widget-picture" width="100px"> --}}

                <img alt="image" src="{{ asset("storage/") }}/{{ $du->profile_photo_path }}"class="img-thumbnail">

                @else
                {{-- <img alt="image" src="https://ui-avatars.com/api/?name={{ $siswa->nama }}&color=7F9CF5&background=EBF4FF" class="rounded-circle profile-widget-picture" width="200px"> --}}
                <img alt="image" src="https://ui-avatars.com/api/?name={{ $siswa->nama }}&color=7F9CF5&background=EBF4FF" class="img-thumbnail" width="200px">

                @endif

                 </div>
                {{-- <img alt="image" src="{{ asset("assets/") }}/img/products/product-3-50.png" class="rounded-circle profile-widget-picture"> --}}
                    {{-- <label for="file">Pilih Photo <code>*)</code></label> --}}

                    {{-- <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required>
                    @error('file')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror --}}

                    <div class="form-group row mb-4">
                        {{-- <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pilih Photo <code>*)</code></label> --}}
                        <div class="col-sm-12 col-md-7">
                          <div id="image-preview" class="image-preview  @error('file') is-invalid @enderror">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="file" id="image-upload" />
                    @error('file')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                          </div>
                        </div>
                      </div>

                      <script type="text/javascript">
                        $(document).ready(function() {
                          $.uploadPreview({
                            input_field: "#image-upload",   // Default: .image-upload
                            preview_box: "#image-preview",  // Default: .image-preview
                            label_field: "#image-label",    // Default: .image-label
                            label_default: "Choose File",   // Default: Choose File
                            label_selected: "Change File",  // Default: Change File
                            no_label: false                 // Default: false
                          });
                        });
                        </script>
                  <div class="card-footer text-right">

                    <button class="btn btn-success"><i class="fas fa-upload"></i> Simpan</button>
                  </form>

                    <form action="/admin/datasiswa/upload/{{ $siswa->id }}" method="post" class="d-inline">
                      @method('delete')
                      @csrf
                      <input type="hidden" name="namaphoto" value="{{ $du->profile_photo_path }}" required>
                      <button class="btn btn-icon btn-danger btn-md"
                          onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><span
                              class="pcoded-micon"> <i class="fas fa-trash"></i> Hapus</span></button>
                  </form>

                  <a href="{{ route($pages) }}" class="btn btn-icon btn-dark ml-3 mt-2"> <i class="fas fa-backward"></i> Batal</a>
                  </div>
                  </div>


                </div>

            </div>



            <div class="card-body">

          <form action="/admin/{{  $pages }}/{{ $siswa->id}}" method="post">
            @method('put')
            @csrf
                <div class="row">

                  <div class="form-group col-md-6 col-6">
                    <label for="nis">NIS <code>*)</code></label>
                    <input type="number" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ $siswa->nis }}" required>
                    @error('nis')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="nama">Nama <code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $siswa->nama }}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="tempatlahir">Tempat Lahir <code>*)</code></label>
                    <input type="text" name="tempatlahir" id="tempatlahir" class="form-control @error('tempatlahir') is-invalid @enderror" value="{{ $siswa->tempatlahir }}" required>
                    @error('tempatlahir')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgllahir" @error('tgllahir') is-invalid @enderror" value="{{ $siswa->tgllahir }}" required>
                    @error('tgllahir')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Agama <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="agama">
                      @if ($siswa->agama)
                      <option>{{ $siswa->agama }}</option>
                      @endif
                      <option>Islam</option>
                      <option>Kristen</option>
                      <option>Katholik</option>
                      <option>Hindu</option>
                      <option>Budha</option>
                      <option>Konghucu</option>
                      <option>Lain-lain</option>
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="alamat">Alamat <code>*)</code></label>
                    <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ $siswa->alamat }}" required>
                    @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                  <div class="form-group col-md-6 col-6">
                    <label>Tahun Pelajaran <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="tapel_nama">
                          @if ($siswa->tapel_nama)
                          <option>{{ $siswa->tapel_nama }}</option>
                          @endif
                      @foreach ($tapel as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Kelas <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="kelas_nama">
                          @if ($siswa->kelas_nama)
                          <option>{{ $siswa->kelas_nama }}</option>
                          @endif
                      @foreach ($kelas as $k)
                          <option>{{ $k->nama }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-6 col-6">
                    <label>Jenis Kelamin <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="jk">
                          @if ($siswa->jk)
                          <option>{{ $siswa->jk }}</option>
                          @endif

                          <option>Laki-laki</option>
                          <option>Perempuan</option>
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="email">Email <code>*)</code></label>
                    <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $du->email }}" onblur="duplicateEmail(this)"  required>
                    @error('email')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password">Password <code>*) Kosongkan Password jika tidak ingin mengubah</code></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="">
                    @error('password')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password2">Konfirmasi Password <code>*)</code></label>
                    <input type="password" name="password2" id="password2" class="form-control @error('password2') is-invalid @enderror" value="">
                    @error('password2')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="moodleuser">User Ujian <code>*)</code></label>
                    <input type="text" name="moodleuser" id="moodleuser" class="form-control @error('moodleuser') is-invalid @enderror" value="{{$siswa->moodleuser}}" required>
                    @error('moodleuser')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="moodlepass">Password Ujian <code>*)</code></label>
                    <input type="text" name="moodlepass" id="moodlepass" class="form-control @error('moodlepass') is-invalid @enderror" value="{{$siswa->moodlepass}}" required>
                    @error('moodlepass')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                </div>

            </div>
            <div class="card-footer text-right">
              <a href="{{ route($pages) }}" class="btn btn-icon btn-dark ml-3"> <i class="fas fa-backward"></i> Batal</a>
              <button class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>


      </div>
    </div>
  </div>
@endsection
