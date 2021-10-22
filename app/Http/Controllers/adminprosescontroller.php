<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class adminprosescontroller extends Controller
{
    public function cleartemp()
	{
            $file = new Filesystem;
            $file->cleanDirectory(public_path('file_temp'));

        // unlink(public_path('file_temp'));
        return redirect()->back()->with('status','File Temp berhasil di Hapus!')->with('tipe','success')->with('icon','fas fa-trash');

    }
}
