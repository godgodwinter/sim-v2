<?php

namespace App\Http\Controllers;

use App\Models\mapel;
use Illuminate\Http\Request;

class admindashboardcontroller extends Controller
{
    public function index(){

        $pages='dashboard';
        $mapel=mapel::get();
        return view('pages.admin.dashboard.index',compact('pages','mapel'));
    }
}
