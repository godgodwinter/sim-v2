<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class admindashboardcontroller extends Controller
{
    public function index(){

        $pages='dashboard';
        return view('pages.admin.dashboard.index',compact('pages'));
    }
}
