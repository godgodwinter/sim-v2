<?php

use App\Http\Controllers\adminbanksoalcontroller;
use App\Http\Controllers\admindashboardcontroller;
use App\Http\Controllers\admingurucontroller;
use App\Http\Controllers\adminkelascontroller;
use App\Http\Controllers\adminkompetensidasarcontroller;
use App\Http\Controllers\adminmapelcontroller;
use App\Http\Controllers\adminmateripokokcontroller;
use App\Http\Controllers\adminpenilaiancontroller;
use App\Http\Controllers\adminprosescontroller;
use App\Http\Controllers\adminseedercontroller;
use App\Http\Controllers\adminsettingscontroller;
use App\Http\Controllers\adminsilabuscontroller;
use App\Http\Controllers\adminsiswacontroller;
use App\Http\Controllers\adminsynccontroller;
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
    Route::get('/admin/settings/resetpassword', [adminsettingscontroller::class, 'resetpassword'])->name('settings.resetpassword');
    Route::get('/admin/settings/resetpassword/cari', [adminsettingscontroller::class, 'resetpasswordcari'])->name('settings.resetpassword.cari');
    Route::get('/admin/settings/resetpassword/resetsemua', [adminsettingscontroller::class, 'resetsemua'])->name('settings.resetpassword.resetsemua');
    Route::get('/admin/settings/passwordujian', [adminsettingscontroller::class, 'passwordujian'])->name('settings.passwordujian');
    Route::post('/admin/settings/passwordujian/generate', [adminsettingscontroller::class, 'passwordujiangenerate'])->name('settings.passwordujian.generate');

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


    //siswa
    Route::get('/admin/siswa', [adminsiswacontroller::class, 'index'])->name('siswa');
    Route::get('/admin/siswa/{id}', [adminsiswacontroller::class, 'edit'])->name('siswa.edit');
    Route::post('/admin/siswa/{id}/reset', [adminsiswacontroller::class, 'reset'])->name('siswa.reset');
    Route::put('/admin/siswa/{id}', [adminsiswacontroller::class, 'update'])->name('siswa.update');
    Route::delete('/admin/siswa/{id}', [adminsiswacontroller::class, 'destroy'])->name('siswa.destroy');
    Route::get('/admin/datasiswa/cari', [adminsiswacontroller::class, 'cari'])->name('siswa.cari');
    Route::get('/admin/datasiswa/create', [adminsiswacontroller::class, 'create'])->name('siswa.create');
    Route::post('/admin/datasiswa', [adminsiswacontroller::class, 'store'])->name('siswa.store');
    Route::delete('/admin/datasiswa/multidel', [adminsiswacontroller::class, 'multidel'])->name('siswa.multidel');


    //mapel
    Route::get('/admin/mapel', [adminmapelcontroller::class, 'index'])->name('mapel');
    Route::get('/admin/mapel/{id}', [adminmapelcontroller::class, 'edit'])->name('mapel.edit');
    Route::put('/admin/mapel/{id}', [adminmapelcontroller::class, 'update'])->name('mapel.update');
    Route::delete('/admin/mapel/{id}', [adminmapelcontroller::class, 'destroy'])->name('mapel.destroy');
    Route::get('/admin/datamapel/cari', [adminmapelcontroller::class, 'cari'])->name('mapel.cari');
    Route::get('/admin/datamapel/create', [adminmapelcontroller::class, 'create'])->name('mapel.create');
    Route::post('/admin/datamapel', [adminmapelcontroller::class, 'store'])->name('mapel.store');
    Route::delete('/admin/datamapel/multidel', [adminmapelcontroller::class, 'multidel'])->name('mapel.multidel');


    //silabus
    Route::get('/admin/silabus', [adminsilabuscontroller::class, 'index'])->name('silabus');
    Route::get('/admin/datasilabus/cari', [adminsilabuscontroller::class, 'cari'])->name('silabus.cari');


    //banksoal
    Route::get('/admin/dataajar/{dataajar}/banksoal', [adminbanksoalcontroller::class, 'index'])->name('dataajar.banksoal');
    Route::get('/admin/dataajar/{dataajar}/banksoal/create', [adminbanksoalcontroller::class, 'create'])->name('dataajar.banksoal.create');
    Route::get('/admin/dataajar/{dataajar}/banksoal/cari', [adminbanksoalcontroller::class, 'cari'])->name('dataajar.banksoal.cari');
    Route::post('/admin/dataajar/{dataajar}/banksoal/store', [adminbanksoalcontroller::class, 'store'])->name('dataajar.banksoal.store');
    Route::get('/admin/dataajar/{dataajar}/banksoal/edit/{id}', [adminbanksoalcontroller::class, 'edit'])->name('dataajar.banksoal.edit');
    Route::post('/admin/dataajar/{dataajar}/banksoal/update/{id}', [adminbanksoalcontroller::class, 'update'])->name('dataajar.banksoal.update');
    Route::delete('/admin/dataajar/{dataajar}/banksoal/delete/{id}', [adminbanksoalcontroller::class, 'destroy'])->name('dataajar.banksoal.delete');


    //kompetensidasar
    Route::get('/admin/dataajar/{dataajar}/kompetensidasar', [adminkompetensidasarcontroller::class, 'index'])->name('dataajar.kompetensidasar');
    Route::get('/admin/dataajar/{dataajar}/kompetensidasar/create', [adminkompetensidasarcontroller::class, 'create'])->name('dataajar.kompetensidasar.create');
    Route::get('/admin/dataajar/{dataajar}/kompetensidasar/cari', [adminkompetensidasarcontroller::class, 'cari'])->name('dataajar.kompetensidasar.cari');
    Route::post('/admin/dataajar/{dataajar}/kompetensidasar/store', [adminkompetensidasarcontroller::class, 'store'])->name('dataajar.kompetensidasar.store');
    Route::get('/admin/dataajar/{dataajar}/kompetensidasar/edit/{id}', [adminkompetensidasarcontroller::class, 'edit'])->name('dataajar.kompetensidasar.edit');
    Route::post('/admin/dataajar/{dataajar}/kompetensidasar/update/{id}', [adminkompetensidasarcontroller::class, 'update'])->name('dataajar.kompetensidasar.update');
    Route::delete('/admin/dataajar/{dataajar}/kompetensidasar/delete/{id}', [adminkompetensidasarcontroller::class, 'destroy'])->name('dataajar.kompetensidasar.delete');

    //materipokok
    Route::get('/admin/dataajar/{dataajar}/kompetensidasar/materipokok/{kd}', [adminmateripokokcontroller::class, 'index'])->name('dataajar.kompetensidasar.materipokok.index');
    Route::get('/admin/dataajar/{dataajar}/kompetensidasar/materipokok/{kd}/create', [adminmateripokokcontroller::class, 'create'])->name('dataajar.kompetensidasar.materipokok.create');
    Route::post('/admin/dataajar/{dataajar}/kompetensidasar/materipokok/{kd}/store', [adminmateripokokcontroller::class, 'store'])->name('dataajar.kompetensidasar.materipokok.store');



    //penilaian
    Route::get('/admin/penilaian', [adminpenilaiancontroller::class, 'index'])->name('penilaian');
    Route::get('/admin/datapenilaian/cari', [adminpenilaiancontroller::class, 'cari'])->name('penilaian.cari');
    //inputnilai
    Route::get('/admin/datapenilaian/inputnilai/{dataajar}', [adminpenilaiancontroller::class, 'inputnilai'])->name('penilaian.inputnilai');

    //sync
    Route::get('/admin/sync/mapeltodataajar', [adminsynccontroller::class, 'mapeltodataajar'])->name('sync.mapeltodataajar');

    //Seeder
    Route::post('/admin/seeder/kelas', [adminseedercontroller::class, 'kelas'])->name('seeder.kelas');
    Route::post('/admin/seeder/siswa', [adminseedercontroller::class, 'siswa'])->name('seeder.siswa');
    Route::post('/admin/seeder/guru', [adminseedercontroller::class, 'guru'])->name('seeder.guru');
    Route::post('/admin/seeder/mapel', [adminseedercontroller::class, 'mapel'])->name('seeder.mapel');
    Route::post('/admin/seeder/hard', [adminseedercontroller::class, 'hard'])->name('seeder.hard');

    //proseslainlain
    Route::post('/admin/proses/cleartemp', [adminprosescontroller::class, 'cleartemp'])->name('cleartemp');
});
