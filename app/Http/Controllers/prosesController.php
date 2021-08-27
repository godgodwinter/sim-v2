<?php

namespace App\Http\Controllers;

use App\Exports\Exportpegawai;
use App\Exports\ExportSiswa;
use App\Imports\Importpegawai;
use App\Imports\ImportSiswa;
use App\Models\siswa;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class prosesController extends Controller
{

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

	public function uploadsiswadelete(Request $request,siswa $siswa){
		
        // dd($request);
        Storage::disk('public')->delete($request->namaphoto);
		User::where('nomerinduk',$siswa->nis)
		->update([
			'profile_photo_path' => "",
		'updated_at'=>date("Y-m-d H:i:s")
		]);
        return redirect()->back()->with('status','Photo berhasil Dihapus!')->with('tipe','dange')->with('icon','fas fa-trash');
	}

    public function cleartemp() 
	{ 
            $file = new Filesystem;
            $file->cleanDirectory(public_path('file_temp'));

        // unlink(public_path('file_temp'));
        return redirect()->back()->with('status','Data berhasil di Hapus!')->with('tipe','success')->with('icon','fas fa-trash');
         
    }


}
