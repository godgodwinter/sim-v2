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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
crossorigin="anonymous"></script>
  @yield('csshere')
</head>

<body>
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
            <img alt="image" src="{{ asset("assets/") }}/img/avatar/avatar-1.png" class="rounded-circle mr-1">

          </figure>
                {{-- <img alt="image" src="{{ asset("assets/") }}/img/avatar/avatar-1.png" class="rounded-circle mr-1"> --}}
            
            <div class="d-sm-none d-lg-inline-block">Hi, Guest</div></a>
            <div class="dropdown-menu dropdown-menu-right">
          
          
             
             
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

              <li class="menu-header">Dashboard v-1.0</li>
       
              <li @if ($pages==='beranda')
              class="active"
              @endif >
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-home"></i><span>Login</span></a>
              </li>

        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">


        <section class="section">

          {{-- HEADER-START --}}
          <div class="section-header">
            <h1>@yield('title')</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Login</a></div>
                {{-- <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div> --}}
              <div class="breadcrumb-item">@yield('halaman')</div>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset("assets/") }}/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="{{ asset("assets/") }}/js/scripts.js"></script>
  <script src="{{ asset("assets/") }}/js/custom.js"></script>
  <script src="{{ asset("assets/") }}/js/page/bootstrap-modal.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
