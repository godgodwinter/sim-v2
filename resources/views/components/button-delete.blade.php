<form action="{{ $link }}" method="post" class="d-inline">
    @method('delete')
    @csrf
    <button class="btn btn-icon btn-danger btn-sm"
        onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"  data-toggle="tooltip" data-placement="top" title="Hapus Data!"><span
            class="pcoded-micon"> <i class="fas fa-trash"></i></span></button>
</form>