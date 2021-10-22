<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('dashboard')}}">{{Fungsi::app_nama()}}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('dashboard')}}">{{Fungsi::app_namapendek()}}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Layout v4.0</li>


@if((Auth::user()->tipeuser)=='admin')
            <li {{$pages=='dashboard' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
            <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span>Pengaturan</span></a>
                <ul class="dropdown-menu">

                    <li {{$pages=='settings' ? 'class=active' : ''}}><a class="nav-link" href="{{route('settings')}}"><i class="fas fa-cog"></i> <span>Aplikasi</span></a></li>
                    <li {{$pages=='dashboard' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-retweet"></i> <span>Reset Password</span></a></li>
                    <li {{$pages=='dashboard' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-key"></i><span>Password Ujian</span></a></li>
                </ul>
            </li>
            <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-dumpster"></i>  <span>Mastering</span></a>
                <ul class="dropdown-menu">

                    <li {{$pages=='users' ? 'class=active' : ''}}><a class="nav-link" href="{{route('users')}}"><i class="fas fa-building"></i> <span>User</span></a></li>
                    <li {{$pages=='tapel' ? 'class=active' : ''}}><a class="nav-link" href="{{route('tapel')}}"><i class="fas fa-passport"></i> <span>Tahun Pelajaran</span></a></li>
                    <li {{$pages=='kelas' ? 'class=active' : ''}}><a class="nav-link" href="{{route('kelas')}}"><i class="fas fa-school"></i><span>Kelas</span></a></li>
                    <li {{$pages=='siswa' ? 'class=active' : ''}}><a class="nav-link" href="{{route('siswa')}}"><i class="fas fa-user-graduate"></i><span>Siswa</span></a></li>
                    <li {{$pages=='guru' ? 'class=active' : ''}}><a class="nav-link" href="{{route('guru')}}"><i class="fas fa-chalkboard-teacher"></i><span>Guru</span></a></li>
                    <li {{$pages=='mapel' ? 'class=active' : ''}}><a class="nav-link" href="{{route('guru')}}"><i class="fab fa-monero"></i><span>Mata Pelajaran</span></a></li>
                </ul>
            </li>
            <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-money-check-alt"></i>  <span>Pembiayaan</span></a>
                <ul class="dropdown-menu">

                    <li {{$pages=='users' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-fire"></i> <span>Atur Tagihan</span></a></li>
                    <li {{$pages=='tapel' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-graduation-cap"></i> <span>Tagihan Pembelajaran</span></a></li>
                </ul>
            </li>
            <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>   <span>Pembelajaran</span></a>
                <ul class="dropdown-menu">

                    <li {{$pages=='users' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fab fa-monero"></i> <span>Mata Pelajaran</span></a></li>
                    <li {{$pages=='tapel' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-microchip"></i> <span>Silabus</span></a></li>
                    <li {{$pages=='kelas' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="far fa-star"></i><span>Penilaian</span></a></li>
                </ul>
            </li>
            <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-id-card-alt"></i>  <span>Absensi</span></a>
                <ul class="dropdown-menu">

                    <li {{$pages=='users' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-id-card-alt"></i><span>Absensi</span></a></li>
                    <li {{$pages=='tapel' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-times-circle"></i><span>Pelanggaran</span></a></li>
                </ul>
            </li>
            <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-calendar-check"></i>   <span>Eoy dan SoY</span></a>
                <ul class="dropdown-menu">

                    <li {{$pages=='users' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="far fa-calendar-check"></i> <span>EoY</span></a></li>
                    <li {{$pages=='tapel' ? 'class=active' : ''}}><a class="nav-link" href="{{route('dashboard')}}"><i class="far fa-calendar-plus"></i> <span>SoY</span></a></li>
                </ul>
            </li>


@elseif((Auth::user()->tipeuser)=='bk')
@else

@endif
        </ul>


    </aside>
</div>
