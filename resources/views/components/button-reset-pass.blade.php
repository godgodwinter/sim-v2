{{-- <a href="{{ $link }}" class="btn btn-icon btn-info btn-sm"><i class="fas fa-redo"></i></a> --}}
<form action="{{ $link }}" method="post" class="d-inline">
    @csrf
    <button class="btn btn-icon btn-info btn-sm"
        onclick="return  confirm('Anda yakin mereset password siswa ini? Y/N')" data-toggle="tooltip" data-placement="top" title="Reset Password!"><span
            class="pcoded-micon"> <i class="fas fa-redo"></i></span></button>
</form>