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
Route::get('/admin/settings', 'App\Http\Controllers\settingsController@index')->name('settings');
Route::post('admin/settings/{settings}', 'App\Http\Controllers\adminberandaController@settingsstore')->name('settings.store');
Route::post('admin/settings/upload/1', 'App\Http\Controllers\prosesController@uploadlogo')->name('settings.uploadlogo');
Route::delete('admin/settings/upload/1', 'App\Http\Controllers\prosesController@uploadlogodelete')->name('siswa.uploadlogodelete');


//kategori-MENU
Route::resource('admin/kategori','App\Http\Controllers\kategoriController')->except(['index']);
Route::get('admin/kategori', 'App\Http\Controllers\kategoriController@index')->name('kategori');

//TAPEL-MENU
Route::resource('admin/tapel','App\Http\Controllers\tapelController')->except(['index','store']);
Route::get('admin/tapel', 'App\Http\Controllers\tapelController@index')->name('tapel');
Route::post('admin/tapel', 'App\Http\Controllers\tapelController@store')->name('tapel.add');
Route::delete('admin/datatapel/multidel', 'App\Http\Controllers\tapelController@deletechecked')->name('tapel.multidel');


//KELAS-MENU
Route::resource('admin/kelas','App\Http\Controllers\kelasController')->except(['index']);
Route::get('admin/kelas', 'App\Http\Controllers\kelasController@index')->name('kelas');
Route::delete('admin/datakelas/multidel', 'App\Http\Controllers\kelasController@deletechecked')->name('kelas.multidel');


//siswa-MENU
Route::resource('admin/siswa','App\Http\Controllers\siswaController')->except(['index']);
Route::get('admin/siswa', 'App\Http\Controllers\siswaController@index')->name('siswa');
Route::get('admin/carisiswa', 'App\Http\Controllers\siswaController@cari')->name('siswa.cari');
Route::post('admin/siswa/{siswa}/reset', 'App\Http\Controllers\siswaController@resetpass')->name('siswa.resetpass');
Route::delete('admin/datasiswa/multidel', 'App\Http\Controllers\siswaController@deletechecked')->name('siswa.multidel');

Route::post('admin/datasiswa/upload/{siswa}', 'App\Http\Controllers\prosesController@uploadsiswa')->name('siswa.upload');
Route::delete('admin/datasiswa/upload/{siswa}', 'App\Http\Controllers\prosesController@uploadsiswadelete')->name('siswa.uploaddelete');


//pegawai-MENU
Route::resource('admin/pegawai','App\Http\Controllers\pegawaiController')->except(['index']);
Route::get('admin/pegawai', 'App\Http\Controllers\pegawaiController@index')->name('pegawai');
Route::get('admin/caripegawai', 'App\Http\Controllers\pegawaiController@cari')->name('pegawai.cari');
Route::post('admin/pegawai/{pegawai}/reset', 'App\Http\Controllers\pegawaiController@resetpass')->name('pegawai.resetpass');
Route::delete('admin/datapegawai/multidel', 'App\Http\Controllers\pegawaiController@deletechecked')->name('pegawai.multidel');

//pemasukan-MENU
Route::resource('admin/pemasukan','App\Http\Controllers\pemasukanController')->except(['index']);
Route::get('admin/pemasukan', 'App\Http\Controllers\pemasukanController@index')->name('pemasukan');
Route::get('admin/caripemasukan', 'App\Http\Controllers\pemasukanController@cari')->name('pemasukan.cari');
Route::delete('admin/datapemasukan/multidel', 'App\Http\Controllers\pemasukanController@deletechecked')->name('pemasukan.multidel');

//pengeluaran-MENU
Route::resource('admin/pengeluaran','App\Http\Controllers\pengeluaranController')->except(['index']);
Route::get('admin/pengeluaran', 'App\Http\Controllers\pengeluaranController@index')->name('pengeluaran');
Route::get('admin/caripengeluaran', 'App\Http\Controllers\pengeluaranController@cari')->name('pengeluaran.cari');
Route::delete('admin/datapengeluaran/multidel', 'App\Http\Controllers\pengeluaranController@deletechecked')->name('pengeluaran.multidel');


//tagihanatur-MENU
Route::resource('admin/tagihanatur','App\Http\Controllers\tagihanaturController')->except(['index']);
Route::get('admin/tagihanatur', 'App\Http\Controllers\tagihanaturController@index')->name('tagihanatur');
Route::get('admin/caritagihanatur', 'App\Http\Controllers\tagihanaturController@cari')->name('tagihanatur.cari');
Route::delete('admin/datatagihanatur/multidel', 'App\Http\Controllers\tagihanaturController@deletechecked')->name('tagihanatur.multidel');

Route::post('admin/datatagihanatur/upload/{tagihanatur}', 'App\Http\Controllers\prosesController@uploadtagihanatur')->name('tagihanatur.upload');
Route::delete('admin/datatagihanatur/upload/{tagihanatur}', 'App\Http\Controllers\prosesController@uploadtagihanaturdelete')->name('tagihanatur.uploaddelete');


//tagihansiswa-MENU
Route::resource('admin/tagihansiswa','App\Http\Controllers\tagihansiswaController')->except(['index']);
Route::get('admin/tagihansiswa', 'App\Http\Controllers\tagihansiswaController@index')->name('tagihansiswa');
Route::get('admin/caritagihansiswa', 'App\Http\Controllers\tagihansiswaController@cari')->name('tagihansiswa.cari');
//kepsek-menu
Route::get('kepsek/tagihansiswa', 'App\Http\Controllers\tagihansiswaController@kepsekindex')->name('kepsek.tagihansiswa');
Route::get('kepsek/caritagihansiswa', 'App\Http\Controllers\tagihansiswaController@kepsekcari')->name('kepsek.tagihansiswa.cari');

//usersiswa-menu
Route::get('siswa/tagihansiswa', 'App\Http\Controllers\tagihansiswaController@siswaindex')->name('siswa.tagihansiswa');
Route::get('siswa/tagihanku/cetak', 'App\Http\Controllers\tagihansiswaController@siswacetaktagihanku')->name('siswa.cetak.tagihanku');

Route::delete('admin/datatagihansiswa/multidel', 'App\Http\Controllers\tagihansiswaController@deletechecked')->name('tagihansiswa.multidel');


Route::post('admin/tagihansiswa/bayartagihan/{tagihansiswa}', 'App\Http\Controllers\tagihansiswaController@bayartagihan')->name('tagihansiswa.bayartagihan');
Route::delete('admin/tagihansiswa/bayartagihan/{tagihansiswadetail}/hapus', 'App\Http\Controllers\tagihansiswaController@bayartagihandestroy')->name('tagihansiswa.bayartagihandestroy');


//laporan-MENU
// Route::resource('admin/laporan','App\Http\Controllers\laporanController')->except(['index']);
Route::get('admin/laporan', 'App\Http\Controllers\laporanController@index')->name('laporan');
Route::get('admin/laporan/cetak', 'App\Http\Controllers\laporanController@cetak')->name('laporan.cetak');


// tagihan-Menu
Route::get('admin/datatagihan/addall', 'App\Http\Controllers\tagihanaturController@addall')->name('admin.tagihan.addall');
// Route::get('admin/datatagihan/addallbayar', 'App\Http\Controllers\tagihanaturController@addallbayar')->name('admin.tagihan.addallbayar');
Route::post('admin/tagihansiswa/sync', 'App\Http\Controllers\tagihansiswaController@sync')->name('tagihansiswa.sync');
Route::get('admin/datatagihan/sync', 'App\Http\Controllers\tagihansiswaController@sync')->name('tagihansiswa.sync');


// ExportdanImport
Route::get('admin/datatapel/export', 'App\Http\Controllers\prosesController@exporttapel')->name('tapel.export');
Route::post('admin/datatapel/import', 'App\Http\Controllers\prosesController@importtapel')->name('tapel.import');
Route::get('admin/datakelas/export', 'App\Http\Controllers\prosesController@exportkelas')->name('kelas.export');
Route::post('admin/datakelas/import', 'App\Http\Controllers\prosesController@importkelas')->name('kelas.import');
Route::get('admin/datapemasukan/export', 'App\Http\Controllers\prosesController@exportpemasukan')->name('pemasukan.export');
Route::post('admin/datapemasukan/import', 'App\Http\Controllers\prosesController@importpemasukan')->name('pemasukan.import');
Route::get('admin/datapengeluaran/export', 'App\Http\Controllers\prosesController@exportpengeluaran')->name('pengeluaran.export');
Route::post('admin/datapengeluaran/import', 'App\Http\Controllers\prosesController@importpengeluaran')->name('pengeluaran.import');

Route::get('admin/datasiswa/export', 'App\Http\Controllers\prosesController@exportsiswa')->name('siswa.export');
Route::post('admin/datasiswa/import', 'App\Http\Controllers\prosesController@importsiswa')->name('siswa.import');
Route::get('admin/datapegawai/export', 'App\Http\Controllers\prosesController@exportpegawai')->name('pegawai.export');
Route::post('admin/datapegawai/import', 'App\Http\Controllers\prosesController@importpegawai')->name('pegawai.import');

Route::get('admin/datatagihanatur/export', 'App\Http\Controllers\prosesController@exporttagihanatur')->name('tagihanatur.export');
Route::post('admin/datatagihanatur/import', 'App\Http\Controllers\prosesController@importtagihanatur')->name('tagihanatur.import');
Route::get('admin/datatagihansiswa/export', 'App\Http\Controllers\prosesController@exporttagihansiswa')->name('tagihansiswa.export');
Route::post('admin/datatagihansiswa/import', 'App\Http\Controllers\prosesController@importtagihansiswa')->name('tagihansiswa.import');
Route::get('admin/datatagihansiswadetail/export', 'App\Http\Controllers\prosesController@exporttagihansiswadetail')->name('tagihansiswadetail.export');
Route::post('admin/datatagihansiswadetail/import', 'App\Http\Controllers\prosesController@importtagihansiswadetail')->name('tagihansiswadetail.import');



// OherMenu /pagescontroller
Route::get('admin/formatimport', 'App\Http\Controllers\pagesController@formatimport')->name('formatimport');
Route::get('admin/guide', 'App\Http\Controllers\pagesController@guide')->name('guide');

Route::get('admin/eoy', 'App\Http\Controllers\pagesController@eoy')->name('eoy');
Route::post('admin/eoy/do', 'App\Http\Controllers\pagesController@eoy_do')->name('eoy.do');

Route::get('admin/soy', 'App\Http\Controllers\pagesController@soy')->name('soy');
Route::post('admin/soy/do', 'App\Http\Controllers\pagesController@soy_do')->name('soy.do');

Route::get('admin/arsip', 'App\Http\Controllers\pagesController@arsip')->name('arsip');

//resetmenu
Route::post('admin/reset/hard', 'App\Http\Controllers\adminresetController@hard')->name('reset.hard');
Route::post('admin/reset/setting', 'App\Http\Controllers\adminresetController@settings')->name('reset.settings');
Route::post('admin/reset/siswa', 'App\Http\Controllers\adminresetController@siswa')->name('reset.siswa');
Route::post('admin/reset/tagihansiswa', 'App\Http\Controllers\adminresetController@tagihansiswa')->name('reset.tagihansiswa');

//seeder
Route::post('admin/seeder/siswa', 'App\Http\Controllers\adminseederController@siswa')->name('seeder.siswa');
Route::post('admin/seeder/kelas', 'App\Http\Controllers\adminseederController@kelas')->name('seeder.kelas');



Route::post('admin/datasiswa/cleartemp', 'App\Http\Controllers\prosesController@cleartemp')->name('cleartemp');


// SIAKAD
Route::get('siakad/admin/beranda', 'App\Http\Controllers\siakadadminpagescontroller@beranda')->name('siakad.admin.beranda');
// SIAKAD-MENU-SIAKADTAPEL
Route::get('admin/siakadtapel', 'App\Http\Controllers\tapelController@siakad_index')->name('siakadtapel');
Route::post('admin/siakadtapel', 'App\Http\Controllers\tapelController@store')->name('siakadtapel.store');
Route::get('admin/siakadtapel/{tapel}', 'App\Http\Controllers\tapelController@siakad_show')->name('siakad.tapel.edit');
Route::put('admin/siakadtapel/{tapel}', 'App\Http\Controllers\tapelController@siakad_update')->name('siakadtapel.update');
Route::delete('admin/siakadtapel/{tapel}', 'App\Http\Controllers\tapelController@destroy')->name('siakadtapel.delete');

// SIAKAD-MENU-SIAKADguru
Route::get('admin/siakadguru', 'App\Http\Controllers\siakadgurucontroller@siakad_index')->name('siakadguru');
Route::post('admin/siakadguru', 'App\Http\Controllers\siakadgurucontroller@store')->name('siakadguru.store');
Route::get('admin/siakadguru/{guru}', 'App\Http\Controllers\siakadgurucontroller@siakad_show')->name('siakad.guru.edit');
Route::put('admin/siakadguru/{guru}', 'App\Http\Controllers\siakadgurucontroller@siakad_update')->name('siakadguru.update');
Route::delete('admin/siakadguru/{guru}', 'App\Http\Controllers\siakadgurucontroller@destroy')->name('siakadguru.delete');
Route::post('admin/siakadguru/{guru}/reset', 'App\Http\Controllers\siakadgurucontroller@resetpass')->name('siakadguru.resetpass');

// SIAKAD-MENU-SIAKADkelas
Route::get('admin/siakadkelas', 'App\Http\Controllers\kelasController@siakad_index')->name('siakadkelas');
Route::post('admin/siakadkelas', 'App\Http\Controllers\kelasController@store')->name('siakadkelas.store');
Route::get('admin/siakadkelas/{kelas}', 'App\Http\Controllers\kelasController@siakad_show')->name('siakad.kelas.edit');
Route::put('admin/siakadkelas/{kelas}', 'App\Http\Controllers\kelasController@siakad_update')->name('siakadkelas.update');
Route::delete('admin/siakadkelas/{kelas}', 'App\Http\Controllers\kelasController@destroy')->name('siakadkelas.delete');

// SIAKAD-MENU-SIAKADjenisnilai
Route::get('admin/siakadjenisnilai', 'App\Http\Controllers\siakadjenisnilaicontroller@siakad_index')->name('siakadjenisnilai');
Route::post('admin/siakadjenisnilai', 'App\Http\Controllers\siakadjenisnilaicontroller@store')->name('siakadjenisnilai.store');
Route::get('admin/siakadjenisnilai/{jenisnilai}', 'App\Http\Controllers\siakadjenisnilaicontroller@siakad_show')->name('siakad.jenisnilai.edit');
Route::put('admin/siakadjenisnilai/{jenisnilai}', 'App\Http\Controllers\siakadjenisnilaicontroller@siakad_update')->name('siakadjenisnilai.update');
Route::delete('admin/siakadjenisnilai/{jenisnilai}', 'App\Http\Controllers\siakadjenisnilaicontroller@destroy')->name('siakadjenisnilai.delete');


// SIAKAD-MENU-SIAKADpelajaran
Route::get('admin/siakadpelajaran', 'App\Http\Controllers\siakadadminpelajarancontroller@siakad_index')->name('siakadpelajaran');
Route::post('admin/siakadpelajaran', 'App\Http\Controllers\siakadadminpelajarancontroller@store')->name('siakadpelajaran.store');
Route::get('admin/siakadpelajaran/{pelajaran}', 'App\Http\Controllers\siakadadminpelajarancontroller@siakad_show')->name('siakad.pelajaran.edit');
Route::put('admin/siakadpelajaran/{pelajaran}', 'App\Http\Controllers\siakadadminpelajarancontroller@siakad_update')->name('siakadpelajaran.update');
Route::delete('admin/siakadpelajaran/{pelajaran}', 'App\Http\Controllers\siakadadminpelajarancontroller@destroy')->name('siakadpelajaran.delete');

// SIAKAD-MENU-SIAKADdataajar
Route::get('admin/siakaddataajar', 'App\Http\Controllers\siakadadmindataajarcontroller@siakad_index')->name('siakaddataajar');
Route::post('admin/siakaddataajar', 'App\Http\Controllers\siakadadmindataajarcontroller@store')->name('siakaddataajar.store');
Route::get('admin/siakaddataajar/{dataajar}', 'App\Http\Controllers\siakadadmindataajarcontroller@siakad_show')->name('siakad.dataajar.edit');
Route::put('admin/siakaddataajar/{dataajar}', 'App\Http\Controllers\siakadadmindataajarcontroller@siakad_update')->name('siakaddataajar.update');
Route::delete('admin/siakaddataajar/{dataajar}', 'App\Http\Controllers\siakadadmindataajarcontroller@destroy')->name('siakaddataajar.delete');

Route::get('admin/siakadpegawai', 'App\Http\Controllers\pegawaiController@siakad_index')->name('siakadpegawai');
Route::get('admin/siakadsiswa', 'App\Http\Controllers\siswaController@siakad_index')->name('siakadsiswa');
Route::get('admin/siakadlaporan', 'App\Http\Controllers\laporanController@siakad_index')->name('siakadlaporan');
Route::get('admin/siakadeoy', 'App\Http\Controllers\proseController@siakad_eoy')->name('siakadeoy');
Route::get('admin/siakadsoy', 'App\Http\Controllers\prosesController@siakad_soy')->name('siakadsoy');
Route::get('admin/siakadarsip', 'App\Http\Controllers\prosesController@siakad_arsip')->name('siakadarsip');


Route::get('/register', 'App\Http\Controllers\adminberandaController@notfound')->name('cleartemp');

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
