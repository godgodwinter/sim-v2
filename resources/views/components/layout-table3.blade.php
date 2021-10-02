<div class="card profile-widget">
    <div class="profile-widget-header">
        <img alt="image" src="{{ asset("assets/") }}/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
        <div class="profile-widget-items">
            <div class="form-group col-md-12 col-12 mt-1 text-right">
              @yield('tomboltambahan')
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

            <a href="#" class="btn btn-sm  btn-danger mb-2" id="deleteAllSelectedRecord"
            onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"  data-toggle="tooltip" data-placement="top" title="Hapus Terpilih">
            <i class="fas fa-trash-alt mr-2"></i> Hapus Terpilih</i>
        </a>
        </div>
        <div class="card-footer text-right">
                @yield('foottable')
        </div>
    </div>

</div>
