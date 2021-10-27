
<li {{$pages=='dashboard' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>


<li {{$pages=='belajar' ? 'class=active' : ''}}><a class="nav-link" href="{{route('menusiswa.dataajar')}}"><i class="fas fa-microchip"></i> <span>Materi Belajar</span></a></li>
{{--
<li {{$pages=='tagihan' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-home"></i> <span>Absensi</span></a></li>

<li {{$pages=='tagihan' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-home"></i> <span>Pelanggaran</span></a></li> --}}
{{--
<li {{$pages=='tagihan' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-home"></i> <span>Tagihan</span></a></li> --}}

