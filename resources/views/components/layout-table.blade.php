<div class="card">



    <div class="card-body -mt-5">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
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
