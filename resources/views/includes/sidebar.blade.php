<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('dashboard')}}">{{Fungsi::app_nama()}}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('dashboard')}}">{{Fungsi::app_namapendek()}}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Layout v4.1</li>


@if((Auth::user()->tipeuser)=='admin')

@include('includes.sidebar_admin')

@elseif((Auth::user()->tipeuser)=='guru')

@include('includes.sidebar_guru')

@elseif((Auth::user()->tipeuser)=='siswa')
@include('includes.sidebar_siswa')

@else
@endif
        </ul>


    </aside>
</div>
