<div class="nav-collapse">
    <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
      <i class="fas fa-ellipsis-v"></i>
    </a>
    <ul class="navbar-nav">


@if((Auth::user()->tipeuser)=='admin')


@elseif((Auth::user()->tipeuser)=='guru')


@elseif((Auth::user()->tipeuser)=='siswa')
        {{-- {{ dd($pages) }} --}}
    <li class="nav-item {{$pages=='materibelajar' ? 'active' : ''}}"><a href="{{route('menusiswa.dataajar')}}" class="nav-link">Materi</a></li>
    <li class="nav-item {{$pages=='penilaian' ? 'active' : ''}}"><a href="{{route('menusiswa.lihatnilai')}}" class="nav-link">Penilaian</a></li>
    <li class="nav-item "><a href="#" class="nav-link">Pembiayaan</a></li>
    <li class="nav-item"><a href="#" class="nav-link">Absensi</a></li>
    <li class="nav-item"><a href="#" class="nav-link">Eksul</a></li>

@else
@endif


    </ul>
  </div>
