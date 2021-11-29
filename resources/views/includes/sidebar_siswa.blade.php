
<li {{$pages=='dashboard' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>


<li {{$pages=='materibelajar' ? 'class=active' : ''}}><a class="nav-link" href="{{route('menusiswa.dataajar')}}"><i class="fas fa-microchip"></i> <span>Materi Belajar</span></a></li>

<li {{$pages=='penilaian' ? 'class=active' : ''}}><a class="nav-link" href="{{route('menusiswa.lihatnilai')}}"><i class="far fa-star"></i> <span>Penilaian</span></a></li>

<li {{$pages=='inputnilai' ? 'class=active' : ''}}><a class="nav-link" href="#"><i class="fas fa-fire"></i>  <span>Pembiayaan</span></a></li>

<li {{$pages=='inputnilai' ? 'class=active' : ''}}><a class="nav-link" href="#"><i class="fas fa-id-card-alt"></i> <span>Absensi</span></a></li>

<li {{$pages=='ekskul' ? 'class=active' : ''}}><a class="nav-link" href="{{route('menusiswa.ekskul')}}"><i class="far fa-calendar-check"></i> <span>Eskul</span></a></li>
{{--
<li {{$pages=='tagihan' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-home"></i> <span>Pelanggaran</span></a></li> --}}
{{--
<li {{$pages=='tagihan' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-home"></i> <span>Tagihan</span></a></li> --}}

