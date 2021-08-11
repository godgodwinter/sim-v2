<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('stisla-luar');
});


//halaman admin fixed
Route::group(['middleware' => ['auth:web', 'verified']], function() {

//DASHBOARD-MENU
Route::get('/home', 'App\Http\Controllers\adminberandaController@index');
Route::get('/dashboard', 'App\Http\Controllers\adminberandaController@index')->name('dashboard');
Route::post('admin/settings/{settings}', 'App\Http\Controllers\adminberandaController@settingsstore')->name('settings.store');


//kategori-MENU
Route::resource('admin/kategori','App\Http\Controllers\kategoriController')->except(['index']);
Route::get('admin/kategori', 'App\Http\Controllers\kategoriController@index')->name('kategori');

//TAPEL-MENU
Route::resource('admin/tapel','App\Http\Controllers\tapelController')->except(['index','store']);
Route::get('admin/tapel', 'App\Http\Controllers\tapelController@index')->name('tapel');
Route::post('admin/tapel', 'App\Http\Controllers\tapelController@store')->name('tapel.add');


//KELAS-MENU
Route::resource('admin/kelas','App\Http\Controllers\kelasController')->except(['index']);
Route::get('admin/kelas', 'App\Http\Controllers\kelasController@index')->name('kelas');


//siswa-MENU
Route::resource('admin/siswa','App\Http\Controllers\siswaController')->except(['index']);
Route::get('admin/siswa', 'App\Http\Controllers\siswaController@index')->name('siswa');
Route::get('admin/carisiswa', 'App\Http\Controllers\siswaController@cari')->name('siswa.cari');
Route::get('admin/datasiswa/export', 'App\Http\Controllers\prosesController@exportsiswa')->name('siswa.export');
Route::post('admin/datasiswa/import', 'App\Http\Controllers\prosesController@importsiswa')->name('siswa.import');
Route::post('admin/datasiswa/upload/{siswa}', 'App\Http\Controllers\prosesController@uploadsiswa')->name('siswa.upload');
Route::delete('admin/datasiswa/upload/{siswa}', 'App\Http\Controllers\prosesController@uploadsiswadelete')->name('siswa.uploaddelete');

Route::post('admin/datasiswa/cleartemp', 'App\Http\Controllers\prosesController@cleartemp')->name('cleartemp');

//pegawai-MENU
Route::resource('admin/pegawai','App\Http\Controllers\pegawaiController')->except(['index']);
Route::get('admin/pegawai', 'App\Http\Controllers\pegawaiController@index')->name('pegawai');
Route::get('admin/caripegawai', 'App\Http\Controllers\pegawaiController@cari')->name('pegawai.cari');

//pemasukan-MENU
Route::resource('admin/pemasukan','App\Http\Controllers\pemasukanController')->except(['index']);
Route::get('admin/pemasukan', 'App\Http\Controllers\pemasukanController@index')->name('pemasukan');
Route::get('admin/caripemasukan', 'App\Http\Controllers\pemasukanController@cari')->name('pemasukan.cari');

//pengeluaran-MENU
Route::resource('admin/pengeluaran','App\Http\Controllers\pengeluaranController')->except(['index']);
Route::get('admin/pengeluaran', 'App\Http\Controllers\pengeluaranController@index')->name('pengeluaran');
Route::get('admin/caripengeluaran', 'App\Http\Controllers\pengeluaranController@cari')->name('pengeluaran.cari');


//tagihanatur-MENU
Route::resource('admin/tagihanatur','App\Http\Controllers\tagihanaturController')->except(['index']);
Route::get('admin/tagihanatur', 'App\Http\Controllers\tagihanaturController@index')->name('tagihanatur');
Route::get('admin/caritagihanatur', 'App\Http\Controllers\tagihanaturController@cari')->name('tagihanatur.cari');


//tagihansiswa-MENU
Route::resource('admin/tagihansiswa','App\Http\Controllers\tagihansiswaController')->except(['index']);
Route::get('admin/tagihansiswa', 'App\Http\Controllers\tagihansiswaController@index')->name('tagihansiswa');
Route::get('admin/caritagihansiswa', 'App\Http\Controllers\tagihansiswaController@cari')->name('tagihansiswa.cari');
//kepsek-menu
Route::get('kepsek/tagihansiswa', 'App\Http\Controllers\tagihansiswaController@kepsekindex')->name('kepsek.tagihansiswa');
Route::get('kepsek/caritagihansiswa', 'App\Http\Controllers\tagihansiswaController@kepsekcari')->name('kepsek.tagihansiswa.cari');
//siswa-menu
Route::get('siswa/tagihansiswa', 'App\Http\Controllers\tagihansiswaController@siswaindex')->name('siswa.tagihansiswa');


Route::post('admin/tagihansiswa/sync', 'App\Http\Controllers\tagihansiswaController@sync')->name('tagihansiswa.sync');
Route::post('admin/tagihansiswa/bayartagihan/{tagihansiswa}', 'App\Http\Controllers\tagihansiswaController@bayartagihan')->name('tagihansiswa.bayartagihan');
Route::delete('admin/tagihansiswa/bayartagihan/{tagihansiswadetail}/hapus', 'App\Http\Controllers\tagihansiswaController@bayartagihandestroy')->name('tagihansiswa.bayartagihandestroy');


//laporan-MENU
// Route::resource('admin/laporan','App\Http\Controllers\laporanController')->except(['index']);
Route::get('admin/laporan', 'App\Http\Controllers\laporanController@index')->name('laporan');
Route::get('admin/laporan/cetak', 'App\Http\Controllers\laporanController@cetak')->name('laporan.cetak');


Route::get('/404', 'App\Http\Controllers\adminberandaController@notfound');
// Route::post('/checkemail',['uses'=>'PagesController@checkEmail']);
// Route::post('/checkemail', 'App\Http\Controllers\PagesController@checkEmail')->name('checkEmail');
// Route::get('/home', function () {
//     return view('guess/home');
// });

});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
