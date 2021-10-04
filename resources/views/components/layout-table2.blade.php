

<div class="card ">
            <div class="form-group col-md-12 col-12 text-right mt-2">
              <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#importExcel"><i class="fas fa-upload"></i>
                Import
              </button>
              <a href="/admin/@yield('linkpages')/export" type="submit" value="Import" class="btn btn-icon btn-primary btn-sm"><span
                    class="pcoded-micon"> <i class="fas fa-download"></i> Export </span></a>
    </div>
{{-- @yield('datatable') --}}
{{-- {{ dd($datas) }} --}}

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-striped  table-sm">
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

