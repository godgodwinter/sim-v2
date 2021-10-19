@php
    if(empty($pages)){
        $pages='kosong';
    }

    $ambilsettings = DB::table('settings')
      ->where('id', '=', '1')
      ->get();
      foreach ($ambilsettings as $settings) {
      }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title') - {{ $settings->aplikasijudul }} </title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset("assets/") }}/css/style.css">
  <link rel="stylesheet" href="{{ asset("assets/") }}/css/components.css">

  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> --}}


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
crossorigin="anonymous"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
{{-- <link rel="stylesheet" href="https://demo.getstisla.com/assets/modules/summernote/summernote-bs4.css"> --}}
{{-- <link rel="stylesheet" href="{{ asset("assets/") }}/stisla/summernote-bs4.css"> --}}
{{-- <link rel="stylesheet" href="{{ asset("assets/") }}/stisla/summernote.min.css"> --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset("assets/") }}/css/babeng.css">

<script src="{{ asset("assets/") }}/stisla/chart.min.js"></script>

<style>
    .container {
        max-width: 500px;
    }
    h2 {
        color: white;
    }
    .form-control2 {
      border: 0;
  }
  input[readonly]{
    background-color:transparent;
    border: 0;
    font-size: 1em;
  }
  .babeng-select{
    position: relative;
    width: 200px;

  }
  .babeng{
    width:150px;
    border-radius: 5px;
    background: #fff;
    border: 1px solid #ccc;
    outline:none;
    padding: 6px;
  }

  .babeng:focus{
    border:1px solid #56b4ef;
    box-shadow: 0px 0px 3px 1px #c8def0;
  }

  #babeng-bar {
      width: 100%;
      /* height: 45px; */
      overflow: hidden;
      padding-bottom: 0px;
  }

  #babeng-bar span {
      height: 100%;
      display: inline;
      overflow: hidden;
      padding-left: 0px
  }

  #babeng-row {
      height: 100%;
      width: 100%;
      text-align: center;
  display: inline;
  }

  #babeng-submit {
      height: 35px;
  }
  </style>
  @yield('csshere')
</head>

<body>
    {{-- <script>
        Swal.fire(
        'Ini adalah judulnya',
        'Ini adalah teksnya',
        'success'
        )
    </script> --}}
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

          <figure class="avatar avatar-sm">
                <img alt="image" src="{{ Auth::user()->profile_photo_url }}" class="rounded-circle mr-1"  >

          </figure>
                {{-- <img alt="image" src="{{ asset("assets/") }}/img/avatar/avatar-1.png" class="rounded-circle mr-1"> --}}

            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in</div>

              <a href="{{ route('profile.show') }}"  class="dropdown-item has-icon">
                <i class="fas fa-user"></i>
                {{ __('Profile') }}
            </a>

              <div class="dropdown-divider"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf


                    <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt">
                        </i> Logout
                      </a>
            </form>

            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ $settings->aplikasijudul }}</a>
          </div>

          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">{{ $settings->aplikasijudulsingkat }}</a>
          </div>
          <ul class="sidebar-menu">

              <li class="menu-header">Dashboard v-3.2</li>
        @if(((Auth::user()->tipeuser)=='admin')||((Auth::user()->tipeuser)=='kepsek'))

              <li @if ($pages==='beranda')
              class="active"
              @endif >
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-home"></i><span>Beranda</span></a>
              </li>
          @endif



             {{--   <li @if ($pages==='profil')
                class="active"
                @endif >
                <a href="{{ route('profile.show') }}" class="nav-link"><i class="far fa-address-card"></i><span>Profile</span></a>
              </li>--}}

@if((Auth::user()->tipeuser)=='admin')

                <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span>Pengaturan</span></a>
                    <ul class="dropdown-menu">


                            <li @if ($pages==='settings')
                                class="active"
                                @endif >
                                <a href="{{ route('settings') }}" class="nav-link"><i class="fas fa-cog"></i><span>Aplikasi</span></a>
                            </li>
                            <li @if ($pages==='siswa')
                                class="active"
                                @endif >
                                <a href="{{ route('settings.resetsiswa') }}" class="nav-link"><i class="fas fa-retweet"></i><span>Reset Password</span></a>
                            </li>

                            <li @if ($pages==='siakadguru')
                                class="active"
                                @endif >
                                <a href="{{ route('passwordujian') }}" class="nav-link"><i class="fas fa-key"></i><span>Password Ujian</span></a>
                            </li>
                    </ul>
                </li>


              {{-- <li class="menu-header">Mastering</li> --}}
              <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-dumpster"></i> <span>Mastering</span></a>
                <ul class="dropdown-menu">

                        <li @if ($pages==='pegawai')
                            class="active"
                            @endif >
                            <a href="{{ route('pegawai') }}" class="nav-link"><i class="fas fa-building"></i><span>User</span></a>
                        </li>
                        <li @if ($pages==='tapel')
                            class="active"
                            @endif >
                            <a href="{{ route('tapel') }}" class="nav-link"><i class="fas fa-passport"></i><span>Tahun Pelajaran</span></a>
                        </li>
                        <li @if ($pages==='kelas')
                            class="active"
                            @endif >
                            <a href="{{ route('kelas') }}" class="nav-link"><i class="fas fa-school"></i><span>Kelas</span></a>
                        </li>
                        <li @if ($pages==='siswa')
                            class="active"
                            @endif >
                            <a href="{{ route('siswa') }}" class="nav-link"><i class="fas fa-user-graduate"></i><span>Siswa</span></a>
                        </li>

                        <li @if ($pages==='siakadguru')
                            class="active"
                            @endif >
                            <a href="{{ route('siakadguru') }}" class="nav-link"><i class="fas fa-chalkboard-teacher"></i><span>Guru</span></a>
                        </li>
                        <li @if ($pages==='siakadpelajaran')
                        class="active"
                        @endif >
                        <a href="{{ route('siakadpelajaran') }}" class="nav-link"><i class="fab fa-monero"></i><span>Mata Pelajaran</span></a>
                        </li>
                        <li @if ($pages==='pelanggaran')
                        class="active"
                        @endif >
                        <a href="{{ route('pelanggaran') }}" class="nav-link"><i class="fas fa-times-circle"></i><span>Pelanggaran </span></a>
                        </li>
                </ul>
              </li>


              <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-money-check-alt"></i> <span>Pembiayaan</span></a>
                <ul class="dropdown-menu">
                        <li @if ($pages==='tagihanatur')
                        class="active"
                        @endif >
                        <a href="{{ route('tagihanatur') }}" class="nav-link"><i class="fas fa-fire"></i><span>Atur Tagihan</span></a>
                        </li>

                        <li @if ($pages==='tagihansiswa')
                        class="active"
                        @endif >
                        <a href="{{ route('tagihansiswa') }}" class="nav-link"><i class="fas fa-graduation-cap"></i><span>Tagihan Pembelajaran</span></a>
                        </li>
                </ul>
              </li>







               <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Pembelajaran</span></a>
                <ul class="dropdown-menu">

                        {{-- <li @if ($pages==='siakadjenisnilai')
                        class="active"
                        @endif >
                        <a href="{{ route('siakadjenisnilai') }}" class="nav-link"><i class="fas fa-receipt"></i><span>Jenis Nilai</span></a>
                        </li> --}}

                        <li @if ($pages==='siakadpelajaran')
                        class="active"
                        @endif >
                        <a href="{{ route('siakadpelajaran') }}" class="nav-link"><i class="fab fa-monero"></i><span>Mata Pelajaran</span></a>
                        </li>

                        <li @if ($pages==='siakaddataajar')
                            class="active"
                            @endif >
                            <a href="{{ route('siakaddataajar') }}" class="nav-link"><i class="fas fa-microchip"></i><span>Silabus</span></a>
                        </li>

                        <li @if ($pages==='penilaian')
                            class="active"
                            @endif >
                            <a href="{{ route('penilaian') }}" class="nav-link"><i class="far fa-star"></i><span>Penilaian</span></a>
                        </li>

                        {{-- <li @if ($pages==='siakadkepribadian')
                        class="active"
                        @endif >
                        <a href="{{ route('siakadkepribadian') }}" class="nav-link"><i class="fas fa-coins"></i><span>Kepribadian</span></a>
                        </li>

                        <li @if ($pages==='siakadekstrakulikuler')
                        class="active"
                        @endif >
                        <a href="{{ route('siakadekstrakulikuler') }}" class="nav-link"><i class="fas fa-building"></i><span>Ekstrakulikuler</span></a>
                        </li> --}}


                </ul>
              </li>



              <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-id-card-alt"></i><span>Absensi</span></a>
                <ul class="dropdown-menu">
                        <li @if ($pages==='absensi')
                        class="active"
                        @endif >
                        <a href="{{ route('absensi') }}" class="nav-link"><i class="fas fa-id-card-alt"></i><span>Absensi</span></a>
                        </li>

                        <li @if ($pages==='pelanggarandetail')
                        class="active"
                        @endif >
                        <a href="{{ route('pelanggarandetail') }}" class="nav-link"><i class="fas fa-times-circle"></i><span>Pelanggaran </span></a>
                        </li>
                </ul>
              </li>

             {{--  <li class="menu-header">Transaksi</li>

              <li @if ($pages==='pemasukan')
                class="active"
                @endif >
                <a href="{{ route('pemasukan') }}" class="nav-link"><i class="fas fa-hand-holding-usd"></i><span>Pemasukan</span></a>
              </li>

              <li @if ($pages==='pengeluaran')
                class="active"
                @endif >
                <a href="{{ route('pengeluaran') }}" class="nav-link"><i class="fas fa-file-invoice-dollar"></i><span>Pengeluaran</span></a>
              </li>
--}}

              {{-- <li class="menu-header">Reporting</li>
              <li @if ($pages==='laporan')
                class="active"
                @endif >
                <a href="{{ route('laporan') }}" class="nav-link"><i class="fab fa-resolving"></i><span>Laporan</span></a>
              </li> --}}

              <li class="menu-header">Eoy dan SoY</li>


              <li @if ($pages==='eoy')
                class="active"
                @endif >
                <a href="{{ route('eoy') }}" class="nav-link"><i class="far fa-calendar-check"></i><span>EoY</span></a>
              </li>

              <li @if ($pages==='soy')
                class="active"
                @endif >
                <a href="{{ route('soy') }}" class="nav-link"><i class="far fa-calendar-plus"></i><span>SoY</span></a>
              </li>

              {{-- <li class="menu-header">Menu Arsip</li>


              <li @if ($pages==='arsip')
                class="active"
                @endif >
                <a href="{{ route('arsip') }}" class="nav-link"><i class="fas fa-history"></i><span>Arsip</span></a>
              </li> --}}

            </ul>

    @elseif((Auth::user()->tipeuser)=='kepsek')
              <li class="menu-header">Menu Kepala Sekolah</li>
              <li @if ($pages==='laporan')
                class="active"
                @endif >
                <a href="{{ route('laporan') }}" class="nav-link"><i class="fab fa-korvue"></i><span>Laporan Keuangan</span></a>
              </li>

              <li @if ($pages==='tagihansiswa')
                class="active"
                @endif >
                <a href="{{ route('kepsek.tagihansiswa') }}" class="nav-link"><i class="fab fa-korvue"></i><span>Pembayaran Siswa</span></a>
              </li>

    @elseif((Auth::user()->tipeuser)=='siswa')
              <li class="menu-header">Menu Siswa</li>
              <li @if ($pages==='tagihansiswa')
                class="active"
                @endif >
                <a href="{{ route('siswa.tagihansiswa') }}" class="nav-link"><i class="fab fa-korvue"></i><span>Tagihanku</span></a>
              </li>
              <li @if ($pages==='tagihansiswa')
                class="active"
                @endif >
                <a href="{{ route('siswa.tagihansiswa') }}" class="nav-link"><i class="fab fa-korvue"></i><span>Nilai Mapel</span></a>
              </li>

              <li @if ($pages==='tagihansiswa')
                class="active"
                @endif >
                <a href="{{ route('siswa.tagihansiswa') }}" class="nav-link"><i class="fab fa-korvue"></i><span>Lihat Raport</span></a>
              </li>

    @elseif((Auth::user()->tipeuser)=='guru')
    <li class="menu-header">Menu Guru</li>
              <li @if ($pages==='tagihansiswa')
                class="active"
                @endif >
                <a href="{{ route('userguru.penilaian') }}" class="nav-link"><i class="fab fa-korvue"></i><span> Penilaian</span></a>
              </li>
                <li class="menu-header">Menu WaliKelas</li>
                <li @if ($pages==='tagihansiswa')
                  class="active"
                  @endif >
                <a href="{{ route('userguru.kelasku') }}" class="nav-link"><i class="fab fa-korvue"></i><span> Kelas Saya</span></a>
              </li>
    @endif
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">


        <section class="section">

          {{-- HEADER-START --}}
          <div class="section-header">
            <h1>@yield('title')</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                {{-- <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div> --}}
           @yield('halaman')
            </div>
          </div>
          {{-- HEADER-END --}}

          @yield('notif')

            @yield('container')



        </section>
        @yield('container-modals')




      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2022
        </div>
        @php
        // exec('git rev-parse --verify HEAD 2> /dev/null', $output);
        // $hash = $output[0];
        // dd($hash)

        $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));

        $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
        $commitDate->setTimezone(new \DateTimeZone('UTC'));

        // dd($commitDate);
        // dd($commitDate->format('Y-m-d H:i:s'));
        $versi=$commitDate->format('Ymd.H.i.s');
    @endphp
        <div class="footer-right">
          v2. {{ $versi }}
        </div>
      </footer>
    </div>
  </div>

  @yield('jshere')
  <!-- General JS Scripts -->

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="{{ asset("assets/") }}/stisla/jquery.uploadPreview.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset("assets/") }}/stisla/summernote-bs4.js"></script>
  <script src="{{ asset("assets/") }}/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="{{ asset("assets/") }}/js/scripts.js"></script>
  <script src="{{ asset("assets/") }}/js/custom.js"></script>
  <script src="{{ asset("assets/") }}/js/page/bootstrap-modal.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
