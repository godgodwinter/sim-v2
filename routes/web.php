<?php

use App\Http\Controllers\admindashboardcontroller;
use App\Http\Controllers\adminprosescontroller;
use App\Http\Controllers\adminseedercontroller;
use App\Http\Controllers\adminsettingscontroller;
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
    //settings
    Route::get('/admin/settings', [adminsettingscontroller::class, 'index'])->name('settings');
    Route::put('/admin/settings/{id}', [adminsettingscontroller::class, 'update'])->name('settings.update');

    //Seeder
    Route::post('/admin/seeder/sekolah', [adminseedercontroller::class, 'sekolah'])->name('seeder.sekolah');
    Route::post('/admin/seeder/masternilaipsikologi', [adminseedercontroller::class, 'masternilaipsikologi'])->name('seeder.masternilaipsikologi');
    Route::post('/admin/seeder/hard', [adminseedercontroller::class, 'hard'])->name('seeder.hard');

    //proseslainlain
    Route::post('/admin/proses/cleartemp', [adminprosescontroller::class, 'cleartemp'])->name('cleartemp');
});
