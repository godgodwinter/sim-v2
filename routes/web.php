<?php

use App\Helpers\Fungsi;
use App\Http\Controllers\pagesController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    return view('landing');
});


//halaman admin fixed
Route::group(['middleware' => ['auth:web', 'verified']], function() {

//DASHBOARD-MENU
Route::get('/home', 'App\Http\Controllers\adminberandaController@index');
Route::get('/dashboard', 'App\Http\Controllers\adminberandaController@index')->name('dashboard');
Route::get('/admin/settings', 'App\Http\Controllers\settingsController@index')->name('settings');
Route::get('/admin/passwordujian', 'App\Http\Controllers\pagesController@passwordujian')->name('passwordujian');
Route::post('/admin/passwordujian/generate', 'App\Http\Controllers\pagesController@passwordujian_generate')->name('passwordujian.generate');
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

//KKO-MENU
Route::get('admin/kko', 'App\Http\Controllers\kkocontroller@index')->name('kko');
Route::post('admin/kko', 'App\Http\Controllers\kkocontroller@store')->name('kko.add');
Route::get('admin/kko/{id}', 'App\Http\Controllers\kkocontroller@show')->name('kko.show');
Route::put('admin/kko/{id}', 'App\Http\Controllers\kkocontroller@update')->name('kko.update');
Route::delete('admin/kko/{id}', 'App\Http\Controllers\kkocontroller@destroy')->name('kko.update');
Route::delete('admin/datakko/multidel', 'App\Http\Controllers\kkocontroller@deletechecked')->name('kko.multidel');


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

// sinkronisasidata
Route::post('admin/tagihansiswa/sync', 'App\Http\Controllers\tagihansiswaController@sync')->name('tagihansiswa.sync');
Route::get('admin/datatagihan/sync', 'App\Http\Controllers\tagihansiswaController@sync')->name('tagihansiswa.sync');
Route::post('admin/sync/dataajar', 'App\Http\Controllers\synccontroller@dataajar')->name('sync.dataajar');
Route::get('admin/sync/dataajar', 'App\Http\Controllers\synccontroller@dataajar')->name('sync.dataajar');


// ExportdanImport
Route::get('admin/datatapel/export', 'App\Http\Controllers\prosesController@exporttapel')->name('tapel.export');
Route::post('admin/datatapel/import', 'App\Http\Controllers\prosesController@importtapel')->name('tapel.import');
Route::get('admin/datakelas/export', 'App\Http\Controllers\prosesController@exportkelas')->name('kelas.export');
Route::post('admin/datakelas/import', 'App\Http\Controllers\prosesController@importkelas')->name('kelas.import');
Route::get('admin/datapemasukan/export', 'App\Http\Controllers\prosesController@exportpemasukan')->name('pemasukan.export');
Route::post('admin/datapemasukan/import', 'App\Http\Controllers\prosesController@importpemasukan')->name('pemasukan.import');
Route::get('admin/datapengeluaran/export', 'App\Http\Controllers\prosesController@exportpengeluaran')->name('pengeluaran.export');
Route::post('admin/datapengeluaran/import', 'App\Http\Controllers\prosesController@importpengeluaran')->name('pengeluaran.import');
Route::get('admin/datakko/export', 'App\Http\Controllers\prosesController@exportkko')->name('kko.export');
Route::post('admin/datakko/import', 'App\Http\Controllers\prosesController@importkko')->name('kko.import');

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
Route::post('admin/seeder/guru', 'App\Http\Controllers\adminseederController@guru')->name('seeder.guru');
Route::post('admin/seeder/mapel', 'App\Http\Controllers\adminseederController@mapel')->name('seeder.mapel');
Route::post('admin/seeder/jenisnilai', 'App\Http\Controllers\adminseederController@jenisnilai')->name('seeder.jenisnilai');
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

Route::get('/select2/guru', 'App\Http\Controllers\siakadgurucontroller@dataAjax');

// SIAKAD-MENU-SIAKADsiswa
Route::get('admin/siakadsiswa', 'App\Http\Controllers\siswaController@siakad_index')->name('siakadsiswa');
Route::post('admin/siakadsiswa', 'App\Http\Controllers\siswaController@store')->name('siakadsiswa.store');
Route::get('admin/siakadsiswa/{siswa}', 'App\Http\Controllers\siswaController@siakad_show')->name('siakad.siswa.edit');
Route::put('admin/siakadsiswa/{siswa}', 'App\Http\Controllers\siswaController@siakad_update')->name('siakadsiswa.update');
Route::delete('admin/siakadsiswa/{siswa}', 'App\Http\Controllers\siswaController@destroy')->name('siakadsiswa.delete');
Route::post('admin/siakadsiswa/{siswa}/reset', 'App\Http\Controllers\siswaController@resetpass')->name('siakadsiswa.resetpass');
Route::get('admin/carisiswa/siakad', 'App\Http\Controllers\siswaController@siakad_cari')->name('siakadsiswa.cari');


// SIAKAD-MENU-SIAKADpegawai
Route::get('admin/siakadpegawai', 'App\Http\Controllers\pegawaiController@siakad_index')->name('siakadpegawai');
Route::post('admin/siakadpegawai', 'App\Http\Controllers\pegawaiController@store')->name('siakadpegawai.store');
Route::get('admin/siakadpegawai/{pegawai}', 'App\Http\Controllers\pegawaiController@siakad_show')->name('siakad.pegawai.edit');
Route::put('admin/siakadpegawai/{pegawai}', 'App\Http\Controllers\pegawaiController@siakad_update')->name('siakadpegawai.update');
Route::delete('admin/siakadpegawai/{pegawai}', 'App\Http\Controllers\pegawaiController@destroy')->name('siakadpegawai.delete');
Route::post('admin/siakadpegawai/{pegawai}/reset', 'App\Http\Controllers\pegawaiController@resetpass')->name('siakadpegawai.resetpass');
Route::get('admin/caripegawai/siakad', 'App\Http\Controllers\pegawaiController@siakad_cari')->name('siakadpegawai.cari');


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
Route::get('admin/siakaddataajar/cari', 'App\Http\Controllers\siakadadmindataajarcontroller@siakad_index_cari')->name('dataajar.cari');
Route::get('admin/siakaddataajar_old', 'App\Http\Controllers\siakadadmindataajarcontroller@siakad_index_old')->name('siakaddataajar_old');
Route::post('admin/siakaddataajarajax', 'App\Http\Controllers\siakadadmindataajarcontroller@store_ajax')->name('siakaddataajar.store.ajax');
Route::post('admin/siakaddataajarajax_new', 'App\Http\Controllers\siakadadmindataajarcontroller@store_ajax_new')->name('siakaddataajar.store.ajax_new');
Route::post('admin/siakaddataajar', 'App\Http\Controllers\siakadadmindataajarcontroller@store')->name('siakaddataajar.store');
Route::get('admin/siakaddataajar/{dataajar}', 'App\Http\Controllers\siakadadmindataajarcontroller@siakad_show')->name('siakad.dataajar.edit');
Route::put('admin/siakaddataajar/{dataajar}', 'App\Http\Controllers\siakadadmindataajarcontroller@siakad_update')->name('siakaddataajar.update');
Route::delete('admin/siakaddataajar/{dataajar}', 'App\Http\Controllers\siakadadmindataajarcontroller@destroy')->name('siakaddataajar.delete');

// SIAKAD-MENU-kompetensidasar
Route::get('admin/kompetensidasar/{pelajaran_nama}/{kelas_nama}/{tapel_nama}', 'App\Http\Controllers\kompetensidasarcontroller@index')->name('kompetensidasar.index');
Route::delete('admin/kompetensidasar/hapus/{id}', 'App\Http\Controllers\kompetensidasarcontroller@destroy')->name('kompetensidasar.materipokok.delete');
Route::get('admin/kompetensidasar/edit/{id}', 'App\Http\Controllers\kompetensidasarcontroller@show')->name('kompetensidasar.materipokok.edit');
Route::post('admin/kompetensidasar/edit/{id}', 'App\Http\Controllers\kompetensidasarcontroller@update')->name('kompetensidasar.materipokok.update');
Route::post('admin/kompetensidasar/{pelajaran_nama}/{kelas_nama}/{tapel_nama}', 'App\Http\Controllers\kompetensidasarcontroller@store')->name('kompetensidasar.store');
Route::post('admin/kompetensidasar/{pelajaran_nama}/{kelas_nama}/{tapel_nama}/materi', 'App\Http\Controllers\kompetensidasarcontroller@materistore')->name('kompetensidasar.store.materi');
Route::delete('admin/kompetensidasar/materipokok/hapus/{id}', 'App\Http\Controllers\kompetensidasarcontroller@materidestroy')->name('kompetensidasar.materipokok.delete');
Route::get('admin/materipokok/edit/{id}', 'App\Http\Controllers\kompetensidasarcontroller@materipokokshow')->name('materipokok.materipokok.edit');
Route::post('admin/materipokok/edit/{id}', 'App\Http\Controllers\kompetensidasarcontroller@materipokokupdate')->name('materipokok.materipokok.update');



// admin-MENU-banksoal
Route::get('admin/databanksoal/{id}', 'App\Http\Controllers\banksoalcontroller@index')->name('pelajaran.banksoal.index');
Route::post('admin/databanksoal/{id}', 'App\Http\Controllers\banksoalcontroller@store')->name('pelajaran.banksoal.store');
Route::get('admin/databanksoal/{dataajarid}/show/{id}', 'App\Http\Controllers\banksoalcontroller@show')->name('banksoal.edit');
// Route::get('admin/kompetensidasar/{pelajaran_nama}/{kelas_nama}/{tapel_nama}/materipokok/banksoal/{materipokok_nama}/{kompetensidasar_kode}/{kompetensidasar_tipe}/detail', 'App\Http\Controllers\banksoalcontroller@detail')->name('banksoal.detail');

// Route::get('admin/banksoal/{id}', 'App\Http\Controllers\banksoalcontroller@show')->name('banksoal.edit');
Route::put('admin/banksoal/{id}', 'App\Http\Controllers\banksoalcontroller@update')->name('banksoal.update');
Route::delete('admin/banksoal/{id}', 'App\Http\Controllers\banksoalcontroller@destroy')->name('banksoal.delete');
Route::get('admin/banksoal/{id}/detail', 'App\Http\Controllers\banksoalcontroller@detail')->name('banksoal.detail');
Route::post('admin/banksoal/{id}/detail', 'App\Http\Controllers\banksoalcontroller@detailstore')->name('banksoal.detailstore');
Route::get('admin/banksoal/{id}/detail/{detail}', 'App\Http\Controllers\banksoalcontroller@detail')->name('banksoal.detail');
Route::post('admin/banksoal/{id}/detail/{detail}', 'App\Http\Controllers\banksoalcontroller@detailstore')->name('banksoal.detailstore');
Route::get('admin/banksoaldetail/{id}', 'App\Http\Controllers\banksoalcontroller@detailshow')->name('banksoal.detail.show');
Route::put('admin/banksoaldetailupdate/{id}', 'App\Http\Controllers\banksoalcontroller@detailupdate')->name('banksoal.detail.update');
Route::delete('admin/banksoaldetail/{id}', 'App\Http\Controllers\banksoalcontroller@detaildestroy')->name('banksoal.detail.delete');


// SIAKAD-MENU-inputnilai
Route::get('admin/datainputnilai/{id}', 'App\Http\Controllers\inputnilaicontroller@index')->name('pelajaran.inputnilai.index');
Route::post('admin/datainputnilai/{id}', 'App\Http\Controllers\inputnilaicontroller@store')->name('pelajaran.inputnilai.store');
// Route::get('admin/kompetensidasar/{pelajaran_nama}/{kelas_nama}/{tapel_nama}/materipokok/inputnilai/{materipokok_nama}/{kompetensidasar_kode}/{kompetensidasar_tipe}', 'App\Http\Controllers\inputnilaicontroller@index')->name('kompetensidasar.materipokok.inputnilai.index');
// Route::post('admin/kompetensidasar/{pelajaran_nama}/{kelas_nama}/{tapel_nama}/materipokok/inputnilai/{materipokok_nama}/{kompetensidasar_kode}/{kompetensidasar_tipe}', 'App\Http\Controllers\inputnilaicontroller@store')->name('kompetensidasar.materipokok.inputnilai.index');
Route::get('api/inputnilai/multiinput', 'App\Http\Controllers\inputnilaicontroller@apimultistore')->name('api.inputnilai.multiinput');
Route::get('api/inputnilai/singleinput', 'App\Http\Controllers\inputnilaicontroller@apisinglestore')->name('api.inputnilai.singleinput');

//moodle-generatesoal
Route::get('admin/moodle/generate2', 'App\Http\Controllers\banksoalcontroller@generateDocx')->name('moodle.generateDocx');
Route::post('admin/moodle/generate', 'App\Http\Controllers\banksoalcontroller@generateworldsoal')->name('moodle.generate');
Route::post('admin/moodle/generate/soal', 'App\Http\Controllers\banksoalcontroller@generateworldsoallooping')->name('moodle.generate.soallooping'); //world
Route::post('admin/moodle/generate/txt', 'App\Http\Controllers\banksoalcontroller@generatetxt')->name('moodle.generate.txt'); //txt
Route::post('generatesoalxml', 'App\Http\Controllers\banksoalcontroller@generatexml')->name('moodle.generate.xml'); //txt
Route::get('soal/xml', 'App\Http\Controllers\banksoalcontroller@generatexml2')->name('moodle.generate.xmlget'); //txt
Route::post('soal/xml/generate', 'App\Http\Controllers\banksoalcontroller@generatexml_new')->name('moodle.generate.xmlget_do'); //txt
// Route::post('soal/xml/generate', 'App\Http\Controllers\banksoalcontroller@generatexml_do')->name('moodle.generate.xmlget_do'); //txt
// Route::get('admin/kompetensidasar/{pelajaran_nama}/{kelas_nama}/{tapel_nama}', 'App\Http\Controllers\kompetensidasarcontroller@index')->name('kompetensidasar.index');

//API
Route::get('admin/api/fungsi/tingkatkesulitan', 'App\Http\Controllers\apicontroller@tingkatkesulitan')->name('api.fungsi.tingkatkesulitan');
Route::get('admin/api/fungsi/generate/kompetensidasar', 'App\Http\Controllers\apicontroller@generatekompetensidasar')->name('api.fungsi.generate.kompetensidasar');

Route::get('admin/api/form/banksoal_jawaban', 'App\Http\Controllers\apicontroller@tingkatkesulitan')->name('api.form.banksoal_jawaban');

Route::get('admin/api/periksa/banksoal_jawaban/edit', 'App\Http\Controllers\apicontroller@tingkatkesulitan')->name('api.periksa.banksoal_jawaban.edit');


// SIAKAD-MENU-inputnilai
Route::get('admin/kompetensidasar/{pelajaran_nama}/{kelas_nama}/{tapel_nama}/materipokok/inputnilai/{materipokok_nama}/{kompetensidasar_kode}/{kompetensidasar_tipe}', 'App\Http\Controllers\inputnilaicontroller@index')->name('kompetensidasar.materipokok.inputnilai.index');

// SIAKAD-MENU-SIAKADkepribadian
Route::get('admin/siakadkepribadian', 'App\Http\Controllers\siakadadminkepribadiancontroller@siakad_index')->name('siakadkepribadian');
Route::post('admin/siakadkepribadian', 'App\Http\Controllers\siakadadminkepribadiancontroller@store')->name('siakadkepribadian.store');
Route::get('admin/siakadkepribadian/{kepribadian}', 'App\Http\Controllers\siakadadminkepribadiancontroller@siakad_show')->name('siakad.kepribadian.edit');
Route::put('admin/siakadkepribadian/{kepribadian}', 'App\Http\Controllers\siakadadminkepribadiancontroller@siakad_update')->name('siakadkepribadian.update');
Route::delete('admin/siakadkepribadian/{kepribadian}', 'App\Http\Controllers\siakadadminkepribadiancontroller@destroy')->name('siakadkepribadian.delete');

// SIAKAD-MENU-SIAKADekstrakulikuler
Route::get('admin/siakadekstrakulikuler', 'App\Http\Controllers\siakadadminekstrakulikulercontroller@siakad_index')->name('siakadekstrakulikuler');
Route::post('admin/siakadekstrakulikuler', 'App\Http\Controllers\siakadadminekstrakulikulercontroller@store')->name('siakadekstrakulikuler.store');
Route::get('admin/siakadekstrakulikuler/{ekstrakulikuler}', 'App\Http\Controllers\siakadadminekstrakulikulercontroller@siakad_show')->name('siakad.ekstrakulikuler.edit');
Route::put('admin/siakadekstrakulikuler/{ekstrakulikuler}', 'App\Http\Controllers\siakadadminekstrakulikulercontroller@siakad_update')->name('siakadekstrakulikuler.update');
Route::delete('admin/siakadekstrakulikuler/{ekstrakulikuler}', 'App\Http\Controllers\siakadadminekstrakulikulercontroller@destroy')->name('siakadekstrakulikuler.delete');


// SIAKAD-MENU-siakadinputnilai
Route::get('admin/inputnilai/mapel/{dataajar}', 'App\Http\Controllers\siakadadmininputnilaicontroller@mapel')->name('siakad.inputnilai.mapel');
Route::post('admin/inputnilai/mapelajax/{dataajar}', 'App\Http\Controllers\siakadadmininputnilaicontroller@mapel_store_ajax')->name('siakad.inputnilai.mapelajaxstore');
Route::post('admin/inputnilai/mapel/{dataajar}', 'App\Http\Controllers\siakadadmininputnilaicontroller@mapel_store')->name('siakad.inputnilai.mapel.store');

// Route::get('admin/inputnilai/kelas/{kelas}', 'App\Http\Controllers\siakadadmininputnilaicontroller@inputnilai')->name('siakad.inputnilai.kelas');
Route::get('admin/inputnilai/kelas/{kelas}', 'App\Http\Controllers\siakadadmininputnilaicontroller@inputnilaiajax')->name('siakad.inputnilaiajax.kelas');
Route::post('admin/inputnilai/kelas/{kelas}', 'App\Http\Controllers\siakadadmininputnilaicontroller@inputnilai_store')->name('siakad.inputnilai.kelas.store');
Route::post('admin/inputnilaiajax/kelas/{kelas}', 'App\Http\Controllers\siakadadmininputnilaicontroller@inputnilai_storeajax')->name('siakad.inputnilaiajax.kelas.store');

Route::get('admin/inputnilai/kepribadian/{kepribadian}/{kelas}', 'App\Http\Controllers\siakadadmininputnilaicontroller@kepribadian')->name('siakad.inputnilai.kepribadian');
Route::get('admin/inputnilai/ekstra/{ekstrakulikuler}/{kelas}', 'App\Http\Controllers\siakadadmininputnilaicontroller@ekstra')->name('siakad.inputnilai.ekstra');
Route::post('admin/inputnilai/ekstra/{ekstrakulikuler}/{kelas}/{siswa}', 'App\Http\Controllers\siakadadmininputnilaicontroller@ekstra_store')->name('siakad.inputnilai.ekstra.store');
Route::post('admin/inputnilai/kepribadian/{kepribadian}/{kelas}/{siswa}', 'App\Http\Controllers\siakadadmininputnilaicontroller@kepribadian_store')->name('siakad.inputnilai.kepribadian.store');

Route::post('admin/inputnilaiajax/ekstra/{ekstrakulikuler}/{kelas}/{siswa}', 'App\Http\Controllers\siakadadmininputnilaicontroller@ekstra_storeajax')->name('siakad.inputnilai.ekstra.storeajax');
Route::post('admin/inputnilaiajax/kepribadian/{kepribadian}/{kelas}/{siswa}', 'App\Http\Controllers\siakadadmininputnilaicontroller@kepribadian_storeajax')->name('siakad.inputnilai.kepribadian.storeajax');


Route::get('admin/siakadnilaikepribadian', 'App\Http\Controllers\siakadadminkepribadiancontroller@nilai')->name('siakadnilaikepribadian');
Route::get('admin/siakadnilaiekstrakulikuler', 'App\Http\Controllers\siakadadminekstrakulikulercontroller@nilai')->name('siakadnilaiekstrakulikuler');

Route::get('admin/siakadlaporan', 'App\Http\Controllers\laporanController@siakad_index')->name('siakadlaporan');
Route::get('admin/siakadeoy', 'App\Http\Controllers\proseController@siakad_eoy')->name('siakadeoy');
Route::get('admin/siakadsoy', 'App\Http\Controllers\prosesController@siakad_soy')->name('siakadsoy');
Route::get('admin/siakadarsip', 'App\Http\Controllers\prosesController@siakad_arsip')->name('siakadarsip');


//usersiswa-menu
Route::get('siswa/tagihansiswa', 'App\Http\Controllers\tagihansiswaController@siswaindex')->name('siswa.tagihansiswa');
Route::get('siswa/tagihanku/cetak', 'App\Http\Controllers\tagihansiswaController@siswacetaktagihanku')->name('siswa.cetak.tagihanku');

//userguru-menu
	Route::get('guru/kelasku', 'App\Http\Controllers\usergurupagescontroller@kelasku')->name('userguru.kelasku');
	Route::get('guru/penilaian', 'App\Http\Controllers\usergurupagescontroller@penilaian')->name('userguru.penilaian');

Route::get('/qrtests', function()
{
	return QrCode::size(250)
	->backgroundColor(255, 255, 204)
	->generate(url('/qrtests'));
});

Route::get('admin/testing/qr', 'App\Http\Controllers\laporanController@qr')->name('testing.qr');

Route::get('/barcode', [pagesController::class, 'barcode'])->name('barcode.index');

Route::get('/register', 'App\Http\Controllers\adminberandaController@notfound')->name('cleartemp');

// Route::post('/checkemail',['uses'=>'PagesController@checkEmail']);
// Route::post('/checkemail', 'App\Http\Controllers\PagesController@checkEmail')->name('checkEmail');
// Route::get('/home', function () {
//     return view('guess/home');
// });

});

// SIAKAD-MENU-raport
Route::get('raport', 'App\Http\Controllers\raportcontroller@index')->name('raport');
Route::get('raport/{nis}', 'App\Http\Controllers\raportcontroller@show')->name('raport.show');
Route::get('raport/{nis}/cetak', 'App\Http\Controllers\raportcontroller@cetak')->name('raport.cetak');

Route::get('/404', 'App\Http\Controllers\adminberandaController@notfound');
// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
