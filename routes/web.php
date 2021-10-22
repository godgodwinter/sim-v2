<?php

use App\Http\Controllers\admindashboardcontroller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


Route::get('/', function () {
    return view('landing');
});


//halaman admin fixed
Route::group(['middleware' => ['auth:web', 'verified']], function() {

//DASHBOARD-MENU
    Route::get('/dashboard', [admindashboardcontroller::class, 'index'])->name('dashboard');

});
