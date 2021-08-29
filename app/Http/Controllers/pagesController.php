<?php

namespace App\Http\Controllers;

use App\Models\tapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pagesController extends Controller
{
    public function formatimport()
    {
        $pages='beranda';
        return view('admin.pages.formatimport',compact('pages'
    ));
    }

    public function guide()
    {
        $pages='beranda';
        return view('admin.pages.guide',compact('pages'
    ));
    }
}
