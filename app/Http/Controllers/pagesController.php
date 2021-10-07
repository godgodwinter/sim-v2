<?php

namespace App\Http\Controllers;

use App\Models\arsip_siswa;
use App\Models\arsip_tagihanatur;
use App\Models\arsip_tagihansiswa;
use App\Models\arsip_tagihansiswadetail;
use App\Models\arsip_users;
use App\Models\kelas;
use App\Models\settings;
use App\Models\siswa;
use App\Models\tagihanatur;
use App\Models\tagihansiswa;
use App\Models\tagihansiswadetail;
use App\Models\tapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Faker\Factory as Faker;

class pagesController extends Controller
{
    public function formatimport()
    {
        $pages='beranda';
        return view('admin.pages.formatimport',compact('pages'
    ));
    }

    public function guide()
    {
        $pages='beranda';
        return view('admin.pages.guide',compact('pages'
    ));
    }

    public function barcode()
    {
        $pages='beranda';
        return view('admin.testing.barcode',compact('pages'
    ));
    }
    public function passwordujian(Request $request){
        $pages='passwordujian';
        return view('admin.pages.passwordujian',compact('pages'
    ));

    }

    public function passwordujian_generate(Request $request){
        $jml=6;
        if(($request->jml!=null)AND($request->jml!='')){
            $jml=$request->jml;
        }
        $moodleuser='a';
        $moodlepass='b';
        // dd($jml);
        // 1. ambil semua data siswa
        $siswas=DB::table('siswa')
            ->get();
        foreach($siswas as $siswa){

            $faker = Faker::create('id_ID');

            $moodleuser=$faker->unique()->regexify('[A-Za-z0-9]{'.$jml.'}');
            $moodlepass=$faker->unique()->regexify('[A-Za-z0-9]{'.$jml.'}');
            // dd($moodleuser,$moodlepass,$jml);

        siswa::where('id',$siswa->id)
        ->update([
            'moodleuser'     =>   $moodleuser,
            'moodlepass'     =>   $moodlepass,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);
        }
        // 2. faker generate username dan password
        // 3. update data
        return redirect()->back()->with('status','Generate Berhasil !')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function eoy()
    {
        $pages='eoy';
        return view('admin.pages.eoy',compact('pages'
    ));
    }

    public function eoy_do(Request $request)
    {
        //buat arsipkode
        // $arsipkode=$this->tapelaktif();
        $arsipkode=$this->cegah2($this->tapelaktif());
        // $arsipkodebaliking=$this->balikin2($arsipkodeubah);
        // dd($arsipkode);

        $jmldatatagihansiswadetail=DB::table('tagihansiswadetail')->where('tapel_nama',$this->tapelaktif())
        ->count();
        if($jmldatatagihansiswadetail<1){
            return redirect()->back()->with('status','Proses EoY gagal! Data pembayaran pada tahun '.$this->tapelaktif().' tidak ditemukan. Lakukan Pembayaran terlebih dahulu!')->with('tipe','danger')->with('icon','fas fa-trash');

        }
        // start-DATATAPEL
        //ambildata
        $datastapel=DB::table('tapel')
        ->get();
        foreach($datastapel as $tapel){

        $datas=DB::table('arsip_tapel')
        ->where('nama',$tapel->nama)
        ->count();

            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_tapel')->insert(
                        array(
                                'nama' => $tapel->nama,
                                'arsipkode' => $arsipkode,
                                'created_at'=>$tapel->created_at,
                                'updated_at'=>$tapel->updated_at
                        ));
                }else{

                }
        //hapus semua data ditabel awal
        tapel::destroy($tapel->id);

        }
        // end-DATATAPEL

        // start-DATAKELAS
        //ambildata
        $dataskelas=DB::table('kelas')
        ->get();
        foreach($dataskelas as $kelas){

        $datas=DB::table('arsip_kelas')
        ->where('nama',$kelas->nama)
        ->count();

            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_kelas')->insert(
                        array(
                                'nama' => $kelas->nama,
                                'arsipkode' => $arsipkode,
                                'created_at'=>$kelas->created_at,
                                'updated_at'=>$kelas->updated_at
                        ));
                }else{

                }
        //hapus semua data ditabel awal
        kelas::destroy($kelas->id);

        }
        // end-DATAKELAS



        // start-DATAUSERS
        //ambildata
        $datasusers=DB::table('users')
        ->where('tipeuser','siswa')
        ->get();
        foreach($datasusers as $users){

        $datas=DB::table('arsip_users')
        ->where('nomerinduk',$users->nomerinduk)
        ->count();

            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_users')->insert(
                        array(
                            'name'     =>   $users->name,
                            'email'     =>   $users->email,
                            'email_verified_at'     =>   $users->email_verified_at,
                            'password'     =>   $users->password,
                            'two_factor_secret'     =>   $users->two_factor_secret,
                            'two_factor_recovery_codes'     =>   $users->two_factor_recovery_codes,
                            'remember_token'     =>   $users->remember_token,
                            'current_team_id'     =>   $users->current_team_id,
                            'profile_photo_path'     =>   $users->profile_photo_path,
                            'tipeuser'     =>   $users->tipeuser,
                            'nomerinduk'     =>   $users->nomerinduk,
                            'arsipkode' => $arsipkode,
                            'created_at'=>$users->created_at,
                            'updated_at'=>$users->updated_at
                        ));
                }else{
                    arsip_users::where('nomerinduk',$users->nomerinduk)
                        ->update([
                            'name'     =>   $users->name,
                            'email'     =>   $users->email,
                            'email_verified_at'     =>   $users->email_verified_at,
                            'password'     =>   $users->password,
                            'two_factor_secret'     =>   $users->two_factor_secret,
                            'two_factor_recovery_codes'     =>   $users->two_factor_recovery_codes,
                            'remember_token'     =>   $users->remember_token,
                            'current_team_id'     =>   $users->current_team_id,
                            'profile_photo_path'     =>   $users->profile_photo_path,
                            'tipeuser'     =>   $users->tipeuser,
                            'nomerinduk'     =>   $users->nomerinduk,
                           'updated_at'=>$users->updated_at
                        ]);

                }
        //hapus semua data ditabel awal
        User::destroy($users->id);

        }
        // end-DATAUSERS
        // start-DATASISWA
        //ambildata
        $datassiswa=DB::table('siswa')
        ->get();
        foreach($datassiswa as $siswa){

        $datas=DB::table('arsip_siswa')
        ->where('nis',$siswa->nis)
        ->where('tapel_nama',$siswa->tapel_nama)
        ->where('kelas_nama',$siswa->kelas_nama)
        ->count();

            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_siswa')->insert(
                        array(
                            'nis'     =>   $siswa->nis,
                            'nama'     =>   $siswa->nama,
                            'tempatlahir'     =>   $siswa->tempatlahir,
                            'tgllahir'     =>   $siswa->tgllahir,
                            'agama'     =>   $siswa->agama,
                            'alamat'     =>   $siswa->alamat,
                            'tapel_nama'     =>   $siswa->tapel_nama,
                            'kelas_nama'     =>   $siswa->kelas_nama,
                            'jk'     =>   $siswa->jk,
                            'moodleuser'     =>   $siswa->moodleuser,
                            'moodlepass'     =>   $siswa->moodlepass,
                            'arsipkode' => $arsipkode,
                            'created_at'=>$siswa->created_at,
                            'updated_at'=>$siswa->updated_at
                        ));
                }else{
                    arsip_siswa::where('nis',$siswa->nis)
                    ->where('tapel_nama',$siswa->tapel_nama)
                    ->where('kelas_nama',$siswa->kelas_nama)
                        ->update([
                           'nama'     =>   $siswa->nama,
                           'tempatlahir'     =>   $siswa->tempatlahir,
                           'tgllahir'     =>   $siswa->tgllahir,
                           'agama'     =>   $siswa->agama,
                           'alamat'     =>   $siswa->alamat,
                           'jk'     =>   $siswa->jk,
                           'moodleuser'     =>   $siswa->moodleuser,
                           'moodlepass'     =>   $siswa->moodlepass,
                           'updated_at'=>$siswa->updated_at
                        ]);

                }
        //hapus semua data ditabel awal
        siswa::destroy($siswa->id);

        }
        // end-DATASISWA


        // start-DATATAGIHANATUR
        //ambildata
        $datastagihanatur=DB::table('tagihanatur')
        ->get();
        foreach($datastagihanatur as $tagihanatur){

        $datas=DB::table('arsip_tagihanatur')
        ->where('tapel_nama',$tagihanatur->tapel_nama)
        ->where('kelas_nama',$tagihanatur->kelas_nama)
        ->count();

            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_tagihanatur')->insert(
                        array(
                            'tapel_nama'     =>   $tagihanatur->tapel_nama,
                            'kelas_nama'     =>   $tagihanatur->kelas_nama,
                            'nominaltagihan'     =>   $tagihanatur->nominaltagihan,
                            'gambar'     =>   $tagihanatur->gambar,
                            'arsipkode' => $arsipkode,
                            'created_at'=>$tagihanatur->created_at,
                            'updated_at'=>$tagihanatur->updated_at
                        ));
                }else{
                    arsip_tagihanatur::where('tapel_nama',$tagihanatur->tapel_nama)
                    ->where('kelas_nama',$tagihanatur->kelas_nama)
                        ->update([
                           'nominaltagihan'     =>   $tagihanatur->nominaltagihan,
                           'gambar'     =>   $tagihanatur->gambar,
                           'updated_at'=>$tagihanatur->updated_at
                        ]);

                }
        //hapus semua data ditabel awal
        tagihanatur::destroy($tagihanatur->id);

        }
        // end-DATATAGIHANATUR


        // start-DATATAGIHANSISWA
        //ambildata
        $datastagihansiswa=DB::table('tagihansiswa')
        ->get();
        foreach($datastagihansiswa as $tagihansiswa){

        $datas=DB::table('arsip_tagihansiswa')
        ->where('siswa_nis',$tagihansiswa->siswa_nis)
        ->where('tapel_nama',$tagihansiswa->tapel_nama)
        ->where('kelas_nama',$tagihansiswa->kelas_nama)
        ->count();

            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_tagihansiswa')->insert(
                        array(
                            'tapel_nama'     =>   $tagihansiswa->tapel_nama,
                            'kelas_nama'     =>   $tagihansiswa->kelas_nama,
                            'nominaltagihan'     =>   $tagihansiswa->nominaltagihan,
                            'siswa_nis'     =>   $tagihansiswa->siswa_nis,
                            'siswa_nama'     =>   $tagihansiswa->siswa_nama,
                            'arsipkode' => $arsipkode,
                            'created_at'=>$tagihansiswa->created_at,
                            'updated_at'=>$tagihansiswa->updated_at
                        ));
                }else{
                    arsip_tagihansiswa::where('tapel_nama',$tagihansiswa->tapel_nama)
                    ->where('siswa_nis',$tagihansiswa->siswa_nis)
                    ->where('kelas_nama',$tagihansiswa->kelas_nama)
                        ->update([
                           'nominaltagihan'     =>   $tagihansiswa->nominaltagihan,
                           'siswa_nama'     =>   $tagihansiswa->siswa_nama,
                           'updated_at'=>$tagihansiswa->updated_at
                        ]);

                }
        //hapus semua data ditabel awal
        tagihansiswa::destroy($tagihansiswa->id);

        }
        // end-DATATAGIHANSISWA


        // start-DATATAGIHANSISWADETAIL
        //ambildata
        $datastagihansiswadetail=DB::table('tagihansiswadetail')
        ->get();
        foreach($datastagihansiswadetail as $tagihansiswadetail){

        $datas=DB::table('arsip_tagihansiswadetail')
        ->where('siswa_nis',$tagihansiswadetail->siswa_nis)
        ->where('tapel_nama',$tagihansiswadetail->tapel_nama)
        ->where('kelas_nama',$tagihansiswadetail->kelas_nama)
        ->where('created_at',$tagihansiswadetail->created_at)
        ->count();

            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_tagihansiswadetail')->insert(
                        array(
                            'tapel_nama'     =>   $tagihansiswadetail->tapel_nama,
                            'kelas_nama'     =>   $tagihansiswadetail->kelas_nama,
                            'nominal'     =>   $tagihansiswadetail->nominal,
                            'siswa_nis'     =>   $tagihansiswadetail->siswa_nis,
                            'siswa_nama'     =>   $tagihansiswadetail->siswa_nama,
                            'arsipkode' => $arsipkode,
                            'created_at'=>$tagihansiswadetail->created_at,
                            'updated_at'=>$tagihansiswadetail->updated_at
                        ));
                }else{
                    arsip_tagihansiswadetail::where('tapel_nama',$tagihansiswadetail->tapel_nama)
                    ->where('siswa_nis',$tagihansiswadetail->siswa_nis)
                    ->where('kelas_nama',$tagihansiswadetail->kelas_nama)
                    ->where('created_at',$tagihansiswadetail->created_at)
                        ->update([
                           'nominal'     =>   $tagihansiswadetail->nominal,
                           'siswa_nama'     =>   $tagihansiswadetail->siswa_nama,
                           'updated_at'=>$tagihansiswadetail->updated_at
                        ]);

                }
        //hapus semua data ditabel awal
        tagihansiswadetail::destroy($tagihansiswadetail->id);

        }
        // end-DATATAGIHANSISWADETAIL

        // dd($arsipkode);
        return redirect()->back()->with('status','Proses EoY berhasil!')->with('tipe','success')->with('icon','fas fa-edit');
    }


    public function soy()
    {
        $pages='soy';
        return view('admin.pages.soy',compact('pages'
    ));
    }

    public function soy_do(Request $request)
    {
        // 1.ambil tapelaktif
            $tapelaktif=$this->tapelaktif();
            $arsipkode=$this->cegah2($tapelaktif);
            // dd($arsipkode);


        //jika tidak ada data tapelaktif maka soy tidak dapat dilakukan
        $jmldataarsipkelas=DB::table('arsip_kelas')->where('arsipkode',$arsipkode)
        ->count();
        if($jmldataarsipkelas<1){
            return redirect()->back()->with('status','Proses SoY gagal! Data SoY pada tahun '.$this->tapelaktif().' tidak ditemukan. Lakukan EoY terlebih dahulu!')->with('tipe','danger')->with('icon','fas fa-trash');

        }

        // 2. ambil data where tapelaktif

        //START-SOY-DATAKELAS
        $dataarsipkelas=DB::table('arsip_kelas')->where('arsipkode',$arsipkode)
        ->get();


        foreach($dataarsipkelas as $kelas){
            $nama=$kelas->nama;
            // 3. tambahkan 1 pada kelas dan tagihanatur jika xii maka alumni jika x dan xi maaka +1, nominaltagihan dari settings>nomminaltagihandefaul
            $nama_baru=$this->naik_k_tanpa_alumni($nama);
            // dd($nama,$nama_baru);

        $datas=DB::table('kelas')
        ->where('nama',$nama_baru)
        ->count();

            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('kelas')->insert(
                        array(
                                'nama' => $nama_baru,
                                'created_at'=>$kelas->created_at,
                                'updated_at'=>$kelas->updated_at
                        ));
                }else{

                }

        }
        //END-SOY-DATAKELAS


        //START-SOY-DATATAPEL
        $dataarsiptapel=DB::table('arsip_tapel')->where('arsipkode',$arsipkode)
        ->get();

        foreach($dataarsiptapel as $tapel){
            $nama=$tapel->nama;
            // 3. tambahkan 1 pada tapel dan tagihanatur jika xii maka alumni jika x dan xi maaka +1, nominaltagihan dari settings>nomminaltagihandefaul
            $nama_baru=$this->naik_t($nama);
            // dd($nama,$nama_baru);

        $datas=DB::table('tapel')
        ->where('nama',$nama_baru)
        ->count();

            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('tapel')->insert(
                        array(
                                'nama' => $nama_baru,
                                'created_at'=>$tapel->created_at,
                                'updated_at'=>$tapel->updated_at
                        ));
                }else{

                }

        }
        //END-SOY-DATATAPEL


        //START-SOY-DATAtagihanatur
        $dataarsiptagihanatur=DB::table('arsip_tagihanatur')->where('arsipkode',$arsipkode)
        ->get();
        $kelas_nama_baru='alumni';
        foreach($dataarsiptagihanatur as $tagihanatur){
            $tapel_nama_baru=$this->naik_t($tagihanatur->tapel_nama);
            // 3. tambahkan 1 pada tagihanatur dan tagihanatur jika xii maka alumni jika x dan xi maaka +1, nominaltagihan dari settings>nomminaltagihandefaul
            $kelas_nama_baru=$this->naik_k_tanpa_alumni($tagihanatur->kelas_nama);
            // dd($nama,$nama_baru);


        $datas=DB::table('tagihanatur')
        ->where('tapel_nama',$tapel_nama_baru)
        ->where('kelas_nama',$kelas_nama_baru)
        ->count();

            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('tagihanatur')->insert(
                        array(
                            'tapel_nama'     =>   $tapel_nama_baru,
                            'kelas_nama'     =>   $kelas_nama_baru,
                            'nominaltagihan'     =>   $tagihanatur->nominaltagihan,
                            'gambar'     =>   $tagihanatur->gambar,
                            'created_at'=>$tagihanatur->created_at,
                            'updated_at'=>$tagihanatur->updated_at
                        ));
                }else{
                    tagihanatur::where('tapel_nama',$tapel_nama_baru)
                    ->where('kelas_nama',$kelas_nama_baru)
                        ->update([
                           'nominaltagihan'     =>   $tagihanatur->nominaltagihan,
                           'gambar'     =>   $tagihanatur->gambar,
                           'updated_at'=>$tagihanatur->updated_at
                        ]);

                }

        }
        //END-SOY-DATAtagihanatur


        //START-SOY-DATAUSER
        $dataarsipusers=DB::table('arsip_users')->where('arsipkode',$arsipkode)
        ->get();
        foreach($dataarsipusers as $users){
            // 3. tambahkan 1 pada users dan users jika xii maka alumni jika x dan xi maaka +1, nominaltagihan dari settings>nomminaltagihandefaul
            // dd($nama,$nama_baru);


        $datas=DB::table('users')
        ->where('nomerinduk',$users->nomerinduk)
        ->count();

        if ($datas<1) {
            //insert data ke arsip_
            DB::table('users')->insert(
                array(
                    'name'     =>   $users->name,
                    'email'     =>   $users->email,
                    'email_verified_at'     =>   $users->email_verified_at,
                    'password'     =>   $users->password,
                    'two_factor_secret'     =>   $users->two_factor_secret,
                    'two_factor_recovery_codes'     =>   $users->two_factor_recovery_codes,
                    'remember_token'     =>   $users->remember_token,
                    'current_team_id'     =>   $users->current_team_id,
                    'profile_photo_path'     =>   $users->profile_photo_path,
                    'tipeuser'     =>   $users->tipeuser,
                    'nomerinduk'     =>   $users->nomerinduk,
                    'created_at'=>$users->created_at,
                    'updated_at'=>$users->updated_at
                ));
        }else{
            User::where('nomerinduk',$users->nomerinduk)
                ->update([
                    'name'     =>   $users->name,
                    'email'     =>   $users->email,
                    'email_verified_at'     =>   $users->email_verified_at,
                    'password'     =>   $users->password,
                    'two_factor_secret'     =>   $users->two_factor_secret,
                    'two_factor_recovery_codes'     =>   $users->two_factor_recovery_codes,
                    'remember_token'     =>   $users->remember_token,
                    'current_team_id'     =>   $users->current_team_id,
                    'profile_photo_path'     =>   $users->profile_photo_path,
                    'tipeuser'     =>   $users->tipeuser,
                    'nomerinduk'     =>   $users->nomerinduk,
                   'updated_at'=>$users->updated_at
                ]);

        }

        }
        //END-SOY-DATAUSER

        //START-SOY-DATASISWA
        $dataarsipsiswa=DB::table('arsip_siswa')->where('arsipkode',$arsipkode)
        ->get();
        $kelas_nama_baru='alumni';
        foreach($dataarsipsiswa as $siswa){
            $tapel_nama_baru=$this->naik_t($siswa->tapel_nama);
            // 3. tambahkan 1 pada siswa dan siswa jika xii maka alumni jika x dan xi maaka +1, nominaltagihan dari settings>nomminaltagihandefaul
            $kelas_nama_baru=$this->naik_k($siswa->kelas_nama);
            // dd($nama,$nama_baru);


        $datas=DB::table('siswa')
        ->where('nis',$siswa->nis)
        ->where('tapel_nama',$tapel_nama_baru)
        ->where('kelas_nama',$kelas_nama_baru)
        ->count();

        $strex=explode(" ",$kelas_nama_baru);
        if($strex[0]!=='Alumni'){

            if ($datas<1) {
                //insert data ke arsip_
                DB::table('siswa')->insert(
                    array(
                        'nis'     =>   $siswa->nis,
                        'nama'     =>   $siswa->nama,
                        'tempatlahir'     =>   $siswa->tempatlahir,
                        'tgllahir'     =>   $siswa->tgllahir,
                        'agama'     =>   $siswa->agama,
                        'alamat'     =>   $siswa->alamat,
                        'tapel_nama'     =>   $tapel_nama_baru,
                        'kelas_nama'     =>   $kelas_nama_baru,
                        'jk'     =>   $siswa->jk,
                        'moodleuser'     =>   $siswa->moodleuser,
                        'moodlepass'     =>   $siswa->moodlepass,
                        'created_at'=>$siswa->created_at,
                        'updated_at'=>$siswa->updated_at
                    ));
            }else{
                siswa::where('nis',$siswa->nis)
                ->where('tapel_nama',$tapel_nama_baru)
                ->where('kelas_nama',$kelas_nama_baru)
                    ->update([
                    'nama'     =>   $siswa->nama,
                    'tempatlahir'     =>   $siswa->tempatlahir,
                    'tgllahir'     =>   $siswa->tgllahir,
                    'agama'     =>   $siswa->agama,
                    'alamat'     =>   $siswa->alamat,
                    'jk'     =>   $siswa->jk,
                    'moodleuser'     =>   $siswa->moodleuser,
                    'moodlepass'     =>   $siswa->moodlepass,
                    'updated_at'=>$siswa->updated_at
                    ]);

            }

        }else{

        }

        }
        //END-SOY-DATASISWA

        // 3.last tambah tapelaktif+1 di setting

        settings::where('id','1')
            ->update([
               'tapelaktif'     =>   $this->naik_t($this->tapelaktif()),
            ]);
        // 4. jalankan fungsi tambahsemua.
        // dd('ini soy');
        return redirect(URL::to('/').'/admin/datatagihan/addall')->with('status','Soy berhasil di lakukan!')->with('tipe','success')->with('icon','fas fa-feather');
    }

    public function arsip()
    {
        $pages='arsip';
        return view('admin.pages.guide',compact('pages'
    ));
    }


}
