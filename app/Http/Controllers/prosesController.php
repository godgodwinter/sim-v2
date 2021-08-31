<?php

namespace App\Http\Controllers;

use App\Exports\Exportkelas;
use App\Exports\Exportpegawai;
use App\Exports\Exportpemasukan;
use App\Exports\Exportpengeluaran;
use App\Exports\ExportSiswa;
use App\Exports\Exporttagihanatur;
use App\Exports\Exporttagihansiswa;
use App\Exports\Exporttagihansiswadetail;
use App\Exports\Exporttapel;
use App\Imports\Importkelas;
use App\Imports\Importpegawai;
use App\Imports\Importpemasukan;
use App\Imports\Importpengeluaran;
use App\Imports\ImportSiswa;
use App\Imports\Importtagihanatur;
use App\Imports\Importtagihansiswa;
use App\Imports\Importtagihansiswadetail;
use App\Imports\Importtapel;
use App\Models\settings;
use App\Models\siswa;
use App\Models\tagihanatur;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class prosesController extends Controller
{

	public function exporttapel()
	{
        $tgl=date("YmdHis");
		return Excel::download(new Exporttapel, 'sim-tapel-'.$tgl.'.xlsx');
	}
	public function exportkelas()
	{
        $tgl=date("YmdHis");
		return Excel::download(new Exportkelas, 'sim-kelas-'.$tgl.'.xlsx');
	}
	public function exportpemasukan()
	{
        $tgl=date("YmdHis");
		return Excel::download(new Exportpemasukan, 'sim-pemasukan-'.$tgl.'.xlsx');
	}
	public function exportpengeluaran()
	{
        $tgl=date("YmdHis");
		return Excel::download(new Exportpengeluaran, 'sim-pengeluaran-'.$tgl.'.xlsx');
	}
	public function exportsiswa()
	{
        $tgl=date("YmdHis");
		return Excel::download(new ExportSiswa, 'sim-siswa-'.$tgl.'.xlsx');
	}

	public function exportpegawai()
	{
        $tgl=date("YmdHis");
		return Excel::download(new Exportpegawai, 'sim-pegawai-'.$tgl.'.xlsx');
	}

	public function exporttagihanatur()
	{
        $tgl=date("YmdHis");
		return Excel::download(new Exporttagihanatur, 'sim-tagihanatur-'.$tgl.'.xlsx');
	}

	public function exporttagihansiswa()
	{
        $tgl=date("YmdHis");
		return Excel::download(new Exporttagihansiswa, 'sim-tagihansiswa-'.$tgl.'.xlsx');
	}

	public function exporttagihansiswadetail()
	{
        $tgl=date("YmdHis");
		return Excel::download(new Exporttagihansiswadetail, 'sim-tagihansiswadetail-'.$tgl.'.xlsx');
	}


	public function importtapel(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_temp',$nama_file);
 
		// import data
		Excel::import(new Importtapel, public_path('/file_temp/'.$nama_file));
 
		// notifikasi dengan session
		// Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		// return redirect('/siswa');
        return redirect()->back()->with('status','Data berhasil Diimport!')->with('tipe','success')->with('icon','fas fa-edit');
	}

	public function importkelas(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_temp',$nama_file);
 
		// import data
		Excel::import(new Importkelas, public_path('/file_temp/'.$nama_file));
 
		// notifikasi dengan session
		// Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		// return redirect('/siswa');
        return redirect()->back()->with('status','Data berhasil Diimport!')->with('tipe','success')->with('icon','fas fa-edit');
	}

	public function importpemasukan(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_temp',$nama_file);
 
		// import data
		Excel::import(new Importpemasukan, public_path('/file_temp/'.$nama_file));
 
		// notifikasi dengan session
		// Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		// return redirect('/siswa');
        return redirect()->back()->with('status','Data berhasil Diimport!')->with('tipe','success')->with('icon','fas fa-edit');
	}

	public function importpengeluaran(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_temp',$nama_file);
 
		// import data
		Excel::import(new Importpengeluaran, public_path('/file_temp/'.$nama_file));
 
		// notifikasi dengan session
		// Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		// return redirect('/siswa');
        return redirect()->back()->with('status','Data berhasil Diimport!')->with('tipe','success')->with('icon','fas fa-edit');
	}

	public function importpegawai(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_temp',$nama_file);
 
		// import data
		Excel::import(new Importpegawai, public_path('/file_temp/'.$nama_file));
 
		// notifikasi dengan session
		// Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		// return redirect('/siswa');
        return redirect()->back()->with('status','Data berhasil Diimport!')->with('tipe','success')->with('icon','fas fa-edit');
	}

	public function importsiswa(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_temp',$nama_file);
 
		// import data
		Excel::import(new ImportSiswa, public_path('/file_temp/'.$nama_file));
 
		// notifikasi dengan session
		// Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		// return redirect('/siswa');
        return redirect(URL::to('/').'/admin/datatagihan/addall')->with('status','Data berhasil diimport!')->with('tipe','success')->with('icon','fas fa-feather');
	}

	public function importtagihanatur(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_temp',$nama_file);
 
		// import data
		Excel::import(new Importtagihanatur, public_path('/file_temp/'.$nama_file));
 
		// notifikasi dengan session
		// Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		// return redirect('/siswa');
		
        return redirect(URL::to('/').'/admin/datatagihan/addall')->with('status','Data berhasil diimport!')->with('tipe','success')->with('icon','fas fa-feather');
	}

	public function importtagihansiswa(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_temp',$nama_file);
 
		// import data
		Excel::import(new Importtagihansiswa, public_path('/file_temp/'.$nama_file));
 
		// notifikasi dengan session
		// Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		// return redirect('/siswa');
		
        return redirect()->back()->with('status','Data berhasil Diimport!')->with('tipe','success')->with('icon','fas fa-edit');
	}

	public function importtagihansiswadetail(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_temp',$nama_file);
 
		// import data
		Excel::import(new Importtagihansiswadetail, public_path('/file_temp/'.$nama_file));
 
		// notifikasi dengan session
		// Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		// return redirect('/siswa');
		
        return redirect()->back()->with('status','Data berhasil Diimport!')->with('tipe','success')->with('icon','fas fa-edit');
	}

	public function uploadsiswa(Request $request,siswa $siswa){
        // dd($request);
		$this->validate($request, [
			'file' => 'required',
		]);
		$namafilebaru=$siswa->nis;
 
		// menyimpan data file yang diupload ke variabel $file
		$file = $request->file('file');
 
      	        // nama file
		echo 'File Name: '.$file->getClientOriginalName();
		echo '<br>';
 
      	        // ekstensi file
		echo 'File Extension: '.$file->getClientOriginalExtension();
		// dd()
		echo '<br>';
 
      	        // real path
		echo 'File Real Path: '.$file->getRealPath();
		echo '<br>';
 
      	        // ukuran file
		echo 'File Size: '.$file->getSize();
		echo '<br>';
 
      	        // tipe mime
		echo 'File Mime Type: '.$file->getMimeType();
 
      	        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'storage/profile-photos';
 
                // upload file
		$file->move($tujuan_upload,"profile-photos/".$namafilebaru.".jpg");


		User::where('nomerinduk',$siswa->nis)
		->update([
			'profile_photo_path' => "profile-photos/".$namafilebaru.".jpg",
		'updated_at'=>date("Y-m-d H:i:s")
		]);

        return redirect()->back()->with('status','Photo berhasil Diupload!')->with('tipe','success')->with('icon','fas fa-edit');

	}

	public function uploadlogo(Request $request,settings $settings){
        // dd($request);
		$this->validate($request, [
			'file' => 'required',
		]);
		$namafilebaru='sekolahlogo';
 
		// menyimpan data file yang diupload ke variabel $file
		$file = $request->file('file');
 
      	        // nama file
		echo 'File Name: '.$file->getClientOriginalName();
		echo '<br>';
 
      	        // ekstensi file
		echo 'File Extension: '.$file->getClientOriginalExtension();
		// dd()
		echo '<br>';
 
      	        // real path
		echo 'File Real Path: '.$file->getRealPath();
		echo '<br>';
 
      	        // ukuran file
		echo 'File Size: '.$file->getSize();
		echo '<br>';
 
      	        // tipe mime
		echo 'File Mime Type: '.$file->getMimeType();
 
      	        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'storage/gambar/logo';
 
                // upload file
		$file->move($tujuan_upload,"gambar/logo/".$namafilebaru.".jpg");


		settings::where('id','1')
		->update([
			'sekolahlogo' => "gambar/logo/".$namafilebaru.".jpg",
		'updated_at'=>date("Y-m-d H:i:s")
		]);

        return redirect()->back()->with('status','Photo berhasil Diupload!')->with('tipe','success')->with('icon','fas fa-edit');

	}

	public function uploadsiswadelete(Request $request,siswa $siswa){
		
        // dd($request);
        Storage::disk('public')->delete($request->namaphoto);
		User::where('nomerinduk',$siswa->nis)
		->update([
			'profile_photo_path' => "",
		'updated_at'=>date("Y-m-d H:i:s")
		]);
        return redirect()->back()->with('status','Photo berhasil Dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
	}

	public function uploadlogodelete(Request $request,settings $settings){
		
        // dd($request);
        Storage::disk('public')->delete($request->namaphoto);
		settings::where('id','1')
		->update([
			'sekolahlogo' => "",
		'updated_at'=>date("Y-m-d H:i:s")
		]);
        return redirect()->back()->with('status','Photo berhasil Dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
	}


	public function uploadtagihanatur(Request $request,tagihanatur $tagihanatur){
        // dd($request);
		$this->validate($request, [
			'file' => 'required',
		]);
		$namafilebaru=$tagihanatur->id;
 
		// menyimpan data file yang diupload ke variabel $file
		$file = $request->file('file');
 
      	        // nama file
		echo 'File Name: '.$file->getClientOriginalName();
		echo '<br>';
 
      	        // ekstensi file
		echo 'File Extension: '.$file->getClientOriginalExtension();
		// dd()
		echo '<br>';
 
      	        // real path
		echo 'File Real Path: '.$file->getRealPath();
		echo '<br>';
 
      	        // ukuran file
		echo 'File Size: '.$file->getSize();
		echo '<br>';
 
      	        // tipe mime
		echo 'File Mime Type: '.$file->getMimeType();
 
      	        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'storage/gambar/scan';
 
                // upload file
		$file->move($tujuan_upload,$namafilebaru.".jpg");


		tagihanatur::where('id',$tagihanatur->id)
		->update([
			'gambar' => $namafilebaru.".jpg",
		'updated_at'=>date("Y-m-d H:i:s")
		]);

        return redirect()->back()->with('status','Photo berhasil Diupload!')->with('tipe','success')->with('icon','fas fa-edit');

	}
	public function uploadtagihanaturdelete(Request $request,tagihanatur $tagihanatur){
		
        // dd($request);
        Storage::disk('public')->delete($request->namaphoto);
		tagihanatur::where('id',$tagihanatur->id)
		->update([
			'gambar' => "",
			'updated_at'=>date("Y-m-d H:i:s")
		]);
        return redirect()->back()->with('status','Photo berhasil Dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
	}

    public function cleartemp() 
	{ 
            $file = new Filesystem;
            $file->cleanDirectory(public_path('file_temp'));

        // unlink(public_path('file_temp'));
        return redirect()->back()->with('status','Data berhasil di Hapus!')->with('tipe','success')->with('icon','fas fa-trash');
         
    }


}
