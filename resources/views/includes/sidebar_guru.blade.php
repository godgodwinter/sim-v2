
<li {{$pages=='dashboard' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>

<li {{$pages=='kelas' ? 'class=active' : ''}}><a class="nav-link" href="{{route('guru.kelas')}}"><i class="fas fa-school"></i> <span>Kelas</span></a></li>

<li {{$pages=='silabus' ? 'class=active' : ''}}><a class="nav-link" href="{{route('guru.silabus')}}"><i class="fas fa-microchip"></i> <span>KD - Mapel</span></a></li>

<li {{$pages=='penilaian' ? 'class=active' : ''}}><a class="nav-link" href="{{route('guru.penilaian')}}"><i class="far fa-star"></i> <span>Penilaian</span></a></li>

<li {{$pages=='absensi' ? 'class=active' : ''}}><a class="nav-link" href="{{route('guru.absensi')}}"><i class="fas fa-id-card-alt"></i> <span>Absensi</span></a></li>

<li {{$pages=='pelanggaran' ? 'class=active' : ''}}><a class="nav-link" href="{{route('pelanggaran')}}"><i class="fas fa-times-circle"></i> <span>Pelanggaran</span></a></li>
