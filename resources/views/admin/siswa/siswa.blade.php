
@section('title','Siswa')
@section('halaman','siswa')

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


{{-- DATATABLE --}}
@section('headtable')
<th class="text-center" width="100px">
    <input type="checkbox" id="chkCheckAll"> <label for="chkCheckAll"> All</label>
</th>
  <th>Nama</th>
  <th>Kelas</th>
  <th>Email</th>
  <th>Photo</th>
  <th width="150px" class="text-center">Aksi</th>
@endsection

@section('bodytable')

<script>
  // console.log('asdad');
  $().jquery;
  $.fn.jquery;
  $(function(e){
      $("#chkCheckAll").click(function(){
          $(".checkBoxClass").prop('checked',$(this).prop('checked'));
      })

      $("#deleteAllSelectedRecord").click(function(e){
          e.preventDefault();
          var allids=[];
              $("input:checkbox[name=ids]:checked").each(function(){
                  allids.push($(this).val());
              });

      $.ajax({
          url:"{{ route('siswa.multidel') }}",
          type:"DELETE",
          data:{
              _token:$("input[name=_token]").val(),
              ids:allids
          },
          success:function(response){
              $.each(allids,function($key,val){
                      $("#sid"+val).remove();
              })
          }
      });

      })

  });
</script>

@foreach ($datas as $data)

<tr id="sid{{ $data->nis }}">
  <td class="text-center">
      <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->nis }}"> {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
    <td>{{ $data->nis }} - {{ $data->nama }}</td>
    <td>{{ $data->tapel_nama }} - {{ $data->kelas_nama }}</td>

        @php
        $ambilemail = DB::table('users')
        ->where('nomerinduk', '=', $data->nis)
        ->get();
        @endphp
        @foreach ($ambilemail as $ae)
        @php
          $email=$ae->email;
          $profile_photo_path=$ae->profile_photo_path;
        @endphp
        @endforeach
    <td> {{ $email }} </td>
    <td> 
      @if($profile_photo_path!='')
              {{-- <img alt="image" src="{{ $ae->profile_photo_url }}" class="rounded-circle mr-1"> --}}
              <img alt="image" src="{{ asset("storage/") }}/{{ $profile_photo_path }}" class="img-thumbnail" width="50px">
      @else
            <img alt="image" src="https://ui-avatars.com/api/?name={{ $data->nama }}&color=7F9CF5&background=EBF4FF" class="img-thumbnail" width="50px">

      @endif
    </td>
    <td class="text-center">
        <x-button-reset-pass link="/admin/{{ $pages }}/{{$data->id}}/reset" />
        <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
        <x-button-delete link="/admin/{{ $pages }}/{{$data->id}}" />
    </td>
  </tr>
@endforeach

<tr>
  <td class="text-left" colspan="2">
    <a href="#" class="btn btn-sm  btn-danger" id="deleteAllSelectedRecord"
    onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><i class="fas fa-trash"></i> Hapus Terpilih</a></td>
</tr>
@endsection

@section('foottable') 
@php
  $cari=$request->cari;
  $tapel_nama=$request->tapel_nama;
  $kelas_nama=$request->kelas_nama;
@endphp
  {{-- {{ $datas->appends(['cari'=>$request->cari,'yearmonth'=>$request->yearmonth,'kategori_nama'=>$request->kategori_nama])->links() }} --}}
  {{ $datas->onEachSide(1)
    ->appends(['cari'=>$cari])
    ->appends(['tapel_nama'=>$tapel_nama])
    ->appends(['kelas_nama'=>$kelas_nama])
    ->links() }}
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><i class="far fa-file"></i> Halaman ke-{{ $datas->currentPage() }}</li>
      <li class="breadcrumb-item"><i class="fas fa-paste"></i> {{ $datas->total() }} Total Data</li>
      <li class="breadcrumb-item active" aria-current="page"><i class="far fa-copy"></i> {{ $datas->perPage() }} Data Perhalaman</li>

  </ol>
  </nav>
@endsection

{{-- DATATABLE-END --}}

@section('container')

  <div class="section-body">
    

    <div class="row ">
      <div class="col-12 col-md-12 col-lg-12">
        {{-- <div class="card"> --}}
          {{-- <div class="card-body"> --}}
            <form action="{{ route($pages.'.cari') }}" method="GET">
              <div class="row">
                  <div class="form-group col-md-2 col-2 text-right">
                    <input type="text" name="cari" id="cari" class="form-control form-control-md @error('cari') is-invalid @enderror" value="{{$request->cari}}"  placeholder="Cari...">
                    @error('cari')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-2 col-2 text-right">
            
                    <select class="form-control form-control-sm" name="tapel_nama" >   
                    @if($request->tapel_nama)
                      <option>{{$request->tapel_nama}}</option>
                    @else
                     <option value="" disabled selected>Pilih Tahun Pelajaran</option>
                    @endif
                  @foreach ($tapel as $t)
                      <option>{{ $t->nama }}</option>
                  @endforeach
                </select>
                  </div>
                  <div class="form-group  col-md-2 col-2 text-right">
             
                  <select class="form-control form-control-sm" name="kelas_nama">    
                    @if($request->kelas_nama)
                      <option>{{$request->kelas_nama}}</option>
                    @else
                     <option value="" disabled selected>Pilih Kelas</option>
                    @endif
                 
                @foreach ($kelas as $t)
                    <option>{{ $t->nama }}</option>
                @endforeach
              </select>
                  </div>
              <div class="form-group   text-right">
         
              <button type="submit" value="CARI" class="btn btn-icon btn-info btn-md mt-1" ><span
              class="pcoded-micon"> <i class="fas fa-search"></i> Pecarian</span></button>

                  </div>
               
             
            </form>
            <div class="form-group col-md-4 col-4 mt-1 text-right">
              <a href="/admin/{{  $pages }}/#add"  class="btn btn-icon btn-primary btn-sm"><span
                class="pcoded-micon"> <i class="far fa-plus-square"></i> Tambah </span></a href="$add">
             
              
              <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#importExcel"><i class="fas fa-upload"></i>
                Import 
              </button>



     
              <a href="/admin/data{{  $pages }}/export" type="submit" value="Import" class="btn btn-icon btn-primary btn-sm"><span
                    class="pcoded-micon"> <i class="fas fa-download"></i> Export </span></a href="$add">


              <button type="button" class="btn btn-icon btn-danger btn-sm" data-toggle="modal" data-target="#cleartemp"><i class="fas fa-trash"></i>
                      Clear Temp
                    </button>




              </div>
          </div>
        
        <x-layout-table pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>
          
       </div> 
       </div> 

      <div class="col-12 col-md-12 col-lg-12" id="add">
        <div class="card">
            <form action="/admin/{{ $pages }}" method="post">
                @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-6 col-6">
                    <label for="nis">NIS <code>*)</code></label>
                    <input type="number" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" value="{{old('nis')}}" required>
                    @error('nis')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                 
                  <div class="form-group col-md-6 col-6">
                    <label for="nama">Nama <code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                 
                  <div class="form-group col-md-6 col-6">
                    <label for="tempatlahir">Tempat Lahir <code>*)</code></label>
                    <input type="text" name="tempatlahir" id="tempatlahir" class="form-control @error('tempatlahir') is-invalid @enderror" value="{{old('tempatlahir')}}" required>
                    @error('tempatlahir')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgllahir" @error('tgllahir') is-invalid @enderror" value="{{old('tgllahir')}}" >
                    @error('tgllahir')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Agama <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="agama"> 
                      @if (old('agama'))
                      <option>{{old('agama')}}</option>                        
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
                    <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{old('alamat')}}" required>
                    @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                  <div class="form-group col-md-6 col-6">
                    <label>Tahun Pelajaran <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="tapel_nama">  
                          @if (old('tapel_nama'))
                          <option>{{old('tapel_nama')}}</option>                        
                          @endif
                      @foreach ($tapel as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Kelas <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="kelas_nama">
                          @if (old('kelas_nama'))
                          <option>{{old('kelas_nama')}}</option>                        
                          @endif
                      @foreach ($kelas as $k)
                          <option>{{ $k->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Jenis Kelamin <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="jk">
                      @if (old('jk'))
                      <option>{{old('jk')}}</option>                        
                      @endif
                       
                    
                          <option>Laki-laki</option>
                          <option>Perempuan</option>
                    </select>
                  </div>

                  <div class="form-group col-md-12 col-12">
                    <label for="email">Email <code>*)</code></label>
                    <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" onblur="duplicateEmail(this)"  required>
                    @error('email')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password">Password <code>*)</code></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password2">Konfirmasi Password <code>*)</code></label>
                    <input type="password" name="password2" id="password2" class="form-control @error('password2') is-invalid @enderror"  required>
                    @error('password2')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="moodleuser">User Ujian <code>*)</code></label>
                    <input type="text" name="moodleuser" id="moodleuser" class="form-control @error('moodleuser') is-invalid @enderror" value="{{old('moodleuser')}}" required>
                    @error('moodleuser')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="moodlepass">Password Ujian <code>*)</code></label>
                    <input type="text" name="moodlepass" id="moodlepass" class="form-control @error('moodlepass') is-invalid @enderror" value="{{old('moodlepass')}}" required>
                    @error('moodlepass')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                 
                </div>
             
            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>


        

      </div>
    </div>
  </div>

  
@endsection

@section('container-modals')

              <!-- Import Excel -->
              <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route('siswa.import') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                      </div>
                      <div class="modal-body">
           
                        {{ csrf_field() }}
           
                        <label>Pilih file excel(.xlsx)</label>
                        <div class="form-group">
                          <input type="file" name="file" required="required">
                        </div>
           
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
          
          
              <!-- Import Excel -->
              <div class="modal fade" id="cleartemp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route('cleartemp') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Temporari</h5>
                      </div>
                      <div class="modal-body">
           
                        {{ csrf_field() }}
           
                        <label></label>
           
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus!</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

@endsection