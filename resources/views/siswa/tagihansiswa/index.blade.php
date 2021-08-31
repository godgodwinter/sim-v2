@extends('layouts.layoutadmin1')

@section('title','Tagihan Ku')
@section('halaman','tagihansiswa')

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

@php
$tipeuser=(Auth::user()->tipeuser);

$nama=Auth::user()->name;
$email=Auth::user()->email;
$profile_photo_path=Auth::user()->profile_photo_path;
@endphp

{{-- DATATABLE --}}
@section('headtable')
  <th width="5%" class="text-center">#</th>
  <th width="5%" >Bayar</th>
  <th>Nama</th>
  <th>Tahun</th>
  <th>Kelas</th>
  <th>Nominal Tagihan</th>
  <th>Terbayar</th>
  <th>Kurang</th>
  <th width="10%"  class="text-center">%</th>
@endsection

@section('bodytable')
@foreach ($datas as $data)@php
    $sumdetailbayar = DB::table('tagihansiswadetail')
      ->where('siswa_nis', '=', $data->siswa_nis)
      ->where('tapel_nama', '=', $data->tapel_nama)
      ->where('kelas_nama', '=', $data->kelas_nama)
      ->sum('nominal');
      $kurang=$data->nominaltagihan-$sumdetailbayar;
      $persen=number_format(($sumdetailbayar/$data->nominaltagihan*100),2);
        $warna='light';
        $icon='fas fa-times';
      if($persen>='100'){
        $warna='success';
        $icon='fas fa-check';
      }
    @endphp
    <tr>
      <td  class="text-center">{{ ($loop->index)+1 }}</td>
      <td class="text-center">
        <button class="btn btn-icon btn-{{ $warna }}" data-toggle="modal" data-target="#modalbayar{{ $data->id }}" ><i class="far fa-money-bill-alt"></i></button>
      </td>
      <td class="text-left">{{ $data->siswa_nis }} - {{ $data->siswa_nama }}</td>
      <td class="text-left">{{ $data->tapel_nama }}</td>
      <td class="text-left">{{ $data->kelas_nama }}</td>
      <td class="text-left">@currency($data->nominaltagihan)</td>
      <td class="text-left">@currency($sumdetailbayar)</td>
      <td>@currency($kurang)</td>
      <td class="text-center">

    <span class="btn btn-icon icon-left btn-{{ $warna }}"><i class="{{ $icon }}"></i> {{ $persen }} %</span>
      
      </td>

      {{-- <td class="text-center">
          <a href="/admin/{{ $pages }}/{{$data->id}}"  class="btn btn-icon icon-left btn-info"><i class="fas fa-edit"></i> Detail</a>
        <form action="/admin/{{ $pages }}/{{$data->id}}" method="post" class="d-inline">
              @method('delete')
              @csrf
              <button class="btn btn-icon btn-danger"
                  onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><span
                      class="pcoded-micon"> <i class="fas fa-trash"></i></span></button>
          </form>
      </td> --}}
    </tr>
@endforeach
@endsection

@section('foottable') 
  {{ $datas->links() }}
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
{{-- {{   dd($caridatas) }} --}}

@php
        
$ambilsiswa = DB::table('siswa')
  ->where('nis', '=', Auth::user()->nomerinduk)
  ->get();
  foreach ($ambilsiswa as $siswa) {
    # code...
  }

    
$ambilsiswausers = DB::table('users')
  ->where('nomerinduk', '=', Auth::user()->nomerinduk)
  ->get();
  foreach ($ambilsiswausers as $du) {
    # code...
  }
      @endphp


<section class="section">
  <div class="section-body">
    <h2 class="section-title">Hi, {{ Auth::user()->name }}!</h2>
    <p class="section-lead">
      Berikut adalah informasi tentang pembayaran tagihan anda. Hubungi admin jika data anda belum muncul.
@if($caridatas>0)
  
@foreach ($datas as $data)
@php
$warna='default';
$sumdetailbayar = DB::table('tagihansiswadetail')
  ->where('tapel_nama', '=', $data->tapel_nama)
  ->where('kelas_nama', '=', $data->kelas_nama)
  ->where('siswa_nis', '=', $data->siswa_nis)
  ->sum('nominal');
  $kurang=$data->nominaltagihan-$sumdetailbayar;
  $persen=number_format(($sumdetailbayar/$data->nominaltagihan*100),2);
  if($persen=='100'){
    $warna='success';
  }
@endphp
@endforeach

{{-- {{ dd($data) }} --}}


    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-5">
        <div class="card profile-widget">
          <div class="profile-widget-header">
            @if($profile_photo_path!='')
            <img alt="image" src="{{ asset("storage/") }}/{{ $profile_photo_path }}" class="rounded-circle profile-widget-picture" width="50px">
            {{-- <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture"> --}}
            @else
            <img alt="image" src="https://ui-avatars.com/api/?name={{ $nama }}&color=FFEDDA&background=3DB2FF" class="rounded-circle profile-widget-picture" width="50px">

      @endif
            <div class="row text-right">

              <div class="col-12 col-md-12 col-lg-12">
                <a href="{{ route('siswa.cetak.tagihanku') }}" class="btn btn-icon icon-left btn-info btn-sm"><i class="fas fa-print"></i>Cetak PDF</a>
            </div>
            </div>
              <div class="profile-widget-items">
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Tagihan</div>
                <div class="profile-widget-item-value">@currency($data->nominaltagihan)</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Dibayarkan</div>
                <div class="profile-widget-item-value">@currency($sumdetailbayar)</div>
              </div>
              <div class="profile-widget-item ">
                <div class="profile-widget-item-label">Persentase</div>
                <div class="profile-widget-item-value text-{{ $warna }}">{{ $persen }} %</div>
              </div>
            </div>
          </div>
          <div class="profile-widget-description">
            <div class="profile-widget-name">{{ Auth::user()->name }} <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> NIS : {{ $data->siswa_nis }}</div></div>
          
            
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th class="text-center">Pembayaran ke-</th>
                    <th>Nominal</th>
                    <th>Tanggal Bayar</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $detailbayar = DB::table('tagihansiswadetail')
                    ->where('siswa_nis', '=', $data->siswa_nis)
                    ->where('tapel_nama', '=', $data->tapel_nama)
                    ->where('kelas_nama', '=', $data->kelas_nama)
                    ->get();
                  @endphp
                  @foreach ($detailbayar as $db)
                  <tr>
                    <td  class="text-center">{{ ($loop->index)+1 }}</td>
                    <td class="text-left">
                      @currency($db->nominal)</td>
                   
                 
                    <td>{{ date('d M Y',strtotime($db->created_at)) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            
          </div>
        </div>
      </div>
      @endif


      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
          <div class="card">
            <form action="/admin/siswa/{{ $siswa->id}}" method="post">
                @method('put')
                @csrf
              <div class="card-header">
                  <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT  Profile</span>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6 col-6">
                      <label for="nis">NIS <code>*)</code></label>
                      <input type="number" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ $siswa->nis }}" required readonly>
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
                      <input type="date" class="form-control" name="tgllahir" @error('tgllahir') is-invalid @enderror" value="{{ $siswa->tgllahir }}" >
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
                      <select class="form-control form-control-lg" required name="tapel_nama" readonly>  
                            @if ($siswa->tapel_nama)
                            <option>{{ $siswa->tapel_nama }}</option>                        
                            @endif
                   
                      </select>
                    </div>
  
                    <div class="form-group col-md-6 col-6">
                      <label>Kelas <code>*)</code></label>
                      <select class="form-control form-control-lg" required name="kelas_nama" readonly>
                            @if ($siswa->kelas_nama)
                            <option>{{ $siswa->kelas_nama }}</option>                        
                            @endif
                     
                      </select>
                    </div>
                    
                    <div class="form-group col-md-12 col-12">
                      <label for="email">Email <code>*)</code></label>
                      <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $du->email }}" onblur="duplicateEmail(this)"  required readonly>
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
</section>

  
@endsection


