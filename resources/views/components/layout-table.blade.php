<div class="card profile-widget">
    <div class="profile-widget-header">
        <img alt="image" src="{{ asset("assets/") }}/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
        <div class="profile-widget-items">
        <div class="profile-widget-item">
            <div class="profile-widget-item-label">Tabel </div>
            <div class="profile-widget-item-value">@yield('title')</div>
        </div>
            <div class="profile-widget-item">
                <div class="profile-widget-item-label">
        {{-- <a href="#" class="btn btn-sm  btn-danger" id="deleteAllSelectedRecord"
        onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><i class="fas fa-trash"></i> Hapus Terpilih</a>  --}}
      </div>
            {{-- <h4>Simple Table</h4> --}}
        </div>
        </div>
    </div>
{{-- @yield('datatable') --}}
{{-- {{ dd($datas) }} --}}      

    <div class="card-body -mt-5">
        <div class="table-responsive">
            <table class="table table-bordered table-md">
            <tr>
                @yield('headtable')
            </tr>
                @yield('bodytable')
            
            </table>
        </div>
        <div class="card-footer text-right">
                @yield('foottable')
        </div>
    </div>   

</div>
  