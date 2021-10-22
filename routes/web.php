<?php

use App\Http\Controllers\admindashboardcontroller;
use App\Http\Controllers\admingurucontroller;
use App\Http\Controllers\adminkelascontroller;
use App\Http\Controllers\adminprosescontroller;
use App\Http\Controllers\adminseedercontroller;
use App\Http\Controllers\adminsettingscontroller;
use App\Http\Controllers\admintapelcontroller;
use App\Http\Controllers\adminuserscontroller;
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

    //MASTERING
    //USER
    Route::get('/admin/users', [adminuserscontroller::class, 'index'])->name('users');
    Route::get('/admin/users/{id}', [adminuserscontroller::class, 'edit'])->name('users.edit');
    Route::put('/admin/users/{id}', [adminuserscontroller::class, 'update'])->name('users.update');
    Route::delete('/admin/users/{id}', [adminuserscontroller::class, 'destroy'])->name('users.destroy');
    Route::get('/admin/datausers/cari', [adminuserscontroller::class, 'cari'])->name('users.cari');
    Route::get('/admin/datausers/create', [adminuserscontroller::class, 'create'])->name('users.create');
    Route::post('/admin/datausers', [adminuserscontroller::class, 'store'])->name('users.store');
    Route::delete('/admin/datausers/multidel', [adminuserscontroller::class, 'multidel'])->name('users.multidel');

    //tapel
    Route::get('/admin/tapel', [admintapelcontroller::class, 'index'])->name('tapel');
    Route::get('/admin/tapel/{id}', [admintapelcontroller::class, 'edit'])->name('tapel.edit');
    Route::put('/admin/tapel/{id}', [admintapelcontroller::class, 'update'])->name('tapel.update');
    Route::delete('/admin/tapel/{id}', [admintapelcontroller::class, 'destroy'])->name('tapel.destroy');
    Route::get('/admin/datatapel/cari', [admintapelcontroller::class, 'cari'])->name('tapel.cari');
    Route::get('/admin/datatapel/create', [admintapelcontroller::class, 'create'])->name('tapel.create');
    Route::post('/admin/datatapel', [admintapelcontroller::class, 'store'])->name('tapel.store');
    Route::delete('/admin/datatapel/multidel', [admintapelcontroller::class, 'multidel'])->name('tapel.multidel');


    //guru
    Route::get('/admin/guru', [admingurucontroller::class, 'index'])->name('guru');
    Route::get('/admin/guru/{id}', [admingurucontroller::class, 'edit'])->name('guru.edit');
    Route::put('/admin/guru/{id}', [admingurucontroller::class, 'update'])->name('guru.update');
    Route::delete('/admin/guru/{id}', [admingurucontroller::class, 'destroy'])->name('guru.destroy');
    Route::get('/admin/dataguru/cari', [admingurucontroller::class, 'cari'])->name('guru.cari');
    Route::get('/admin/dataguru/create', [admingurucontroller::class, 'create'])->name('guru.create');
    Route::post('/admin/dataguru', [admingurucontroller::class, 'store'])->name('guru.store');
    Route::delete('/admin/dataguru/multidel', [admingurucontroller::class, 'multidel'])->name('guru.multidel');


    //kelas
    Route::get('/admin/kelas', [adminkelascontroller::class, 'index'])->name('kelas');
    Route::get('/admin/kelas/{id}', [adminkelascontroller::class, 'edit'])->name('kelas.edit');
    Route::put('/admin/kelas/{id}', [adminkelascontroller::class, 'update'])->name('kelas.update');
    Route::delete('/admin/kelas/{id}', [adminkelascontroller::class, 'destroy'])->name('kelas.destroy');
    Route::get('/admin/datakelas/cari', [adminkelascontroller::class, 'cari'])->name('kelas.cari');
    Route::get('/admin/datakelas/create', [adminkelascontroller::class, 'create'])->name('kelas.create');
    Route::post('/admin/datakelas', [adminkelascontroller::class, 'store'])->name('kelas.store');
    Route::delete('/admin/datakelas/multidel', [adminkelascontroller::class, 'multidel'])->name('kelas.multidel');

    //Seeder
    Route::post('/admin/seeder/sekolah', [adminseedercontroller::class, 'sekolah'])->name('seeder.sekolah');
    Route::post('/admin/seeder/masternilaipsikologi', [adminseedercontroller::class, 'masternilaipsikologi'])->name('seeder.masternilaipsikologi');
    Route::post('/admin/seeder/hard', [adminseedercontroller::class, 'hard'])->name('seeder.hard');

    //proseslainlain
    Route::post('/admin/proses/cleartemp', [adminprosescontroller::class, 'cleartemp'])->name('cleartemp');
});
