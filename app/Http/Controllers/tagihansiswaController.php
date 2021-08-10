<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\tagihansiswa;
use App\Models\tagihansiswadetail;
use App\Models\tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class tagihansiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        // dd($this->checkauth());

        #WAJIB
        $pages='tagihansiswa';
        $jmldata='0';
        $datas='0';


        $tapel=tapel::all();
        $kelas=kelas::all();
        $datas=DB::table('tagihansiswa')->orderBy('siswa_nis','asc')
        ->paginate($this->paginationjml());
        // // $tagihansiswa=tagihansiswa::all();
        // $tagihansiswa = DB::table('tagihansiswa')->where('prefix','tagihansiswa')->get();
        $jmldata = DB::table('tagihansiswa')->count();

        return view('admin.tagihansiswa.index',compact('pages','jmldata','datas','tapel','kelas','request'));
    }

    public function kepsekindex(Request $request)
    {
        if($this->checkauth('kepsek')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='tagihansiswa';
        $jmldata='0';
        $datas='0';


        $tapel=tapel::all();
        $kelas=kelas::all();
        $datas=DB::table('tagihansiswa')->orderBy('siswa_nis','asc')
        ->paginate($this->paginationjml());
        // // $tagihansiswa=tagihansiswa::all();
        // $tagihansiswa = DB::table('tagihansiswa')->where('prefix','tagihansiswa')->get();
        $jmldata = DB::table('tagihansiswa')->count();

        return view('kepsek.tagihansiswa.index',compact('pages','jmldata','datas','tapel','kelas','request'));
    }

    public function siswaindex(Request $request)
    {

        if($this->checkauth('siswa')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='tagihansiswa';
        $jmldata='0';
        $datas='0';

        $nis=(Auth::user()->nomerinduk);

        $tapel=tapel::all();
        $kelas=kelas::all();
        $datas=DB::table('tagihansiswa')->orderBy('siswa_nis','asc')->where('siswa_nis',$nis)
        ->paginate($this->paginationjml());
        // // $tagihansiswa=tagihansiswa::all();
        // $tagihansiswa = DB::table('tagihansiswa')->where('prefix','tagihansiswa')->get();
        $jmldata = DB::table('tagihansiswa')->count();

        return view('siswa.tagihansiswa.index',compact('pages','jmldata','datas','tapel','kelas','request'));
    }
    

    public function cari(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        // dd($request);
        $cari=$request->cari;
        $tapel_nama=$request->tapel_nama;
        $kelas_nama=$request->kelas_nama;

        #WAJIB
        $pages='tagihansiswa';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('tagihansiswa')
    // ->where('nis','like',"%".$cari."%")
    ->where('siswa_nama','like',"%".$cari."%")
    ->where('tapel_nama','like',"%".$tapel_nama."%")
    ->where('kelas_nama','like',"%".$kelas_nama."%")
    ->orWhere('siswa_nis','like',"%".$cari."%")
    ->where('tapel_nama','like',"%".$tapel_nama."%")
    ->where('kelas_nama','like',"%".$kelas_nama."%")
    ->paginate($this->paginationjml());

        // $kategori=kategori::all();
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('tagihansiswa')->count();


        return view('admin.tagihansiswa.index',compact('pages','jmldata','datas','tapel','kelas','request'));
    }

    public function kepsekcari(Request $request)
    {
        if($this->checkauth('kepsek')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        // dd($request);
        $cari=$request->cari;
        $tapel_nama=$request->tapel_nama;
        $kelas_nama=$request->kelas_nama;

        #WAJIB
        $pages='tagihansiswa';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('tagihansiswa')
    // ->where('nis','like',"%".$cari."%")
    ->where('siswa_nama','like',"%".$cari."%")
    ->where('tapel_nama','like',"%".$tapel_nama."%")
    ->where('kelas_nama','like',"%".$kelas_nama."%")
    ->orWhere('siswa_nis','like',"%".$cari."%")
    ->where('tapel_nama','like',"%".$tapel_nama."%")
    ->where('kelas_nama','like',"%".$kelas_nama."%")
    ->paginate($this->paginationjml());

        // $kategori=kategori::all();
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('tagihansiswa')->count();


        return view('kepsek.tagihansiswa.index',compact('pages','jmldata','datas','tapel','kelas','request'));
    }
    public function sync()
    {

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        $tapel=tapel::all();
        $kelas=kelas::all();
        // 1.ambil tagihanatur
        $tagihanatur=DB::table('tagihanatur')->orderBy('tapel_nama','asc')->get();
        foreach ($tagihanatur as $ta){
            $tapel_nama=$ta->tapel_nama;
            $kelas_nama=$ta->kelas_nama;
            $nominaltagihan=$ta->nominaltagihan;
            $tagihanatur_kd=$ta->id;
            // dd($tapel_nama,$kelas_nama,$nominaltagihan);

            // 2. ambil datasiswa where tapel dan kelas
                $siswa=DB::table('siswa')->where('tapel_nama',$tapel_nama)
                    ->where('kelas_nama',$kelas_nama)
                    ->orderBy('tapel_nama','asc')
                    ->get();
                foreach ($siswa as $s){
                    $siswa_nama=$s->nama;
                    $siswa_nis=$s->nis;
                    // dd($tapel_nama,$kelas_nama,$nominaltagihan,$siswa_nama,$siswa_nis);
                    // 3.cek apakah data siswanis&tapel&kelas sudah ada?
                     $cektagihansiswa=DB::table('tagihansiswa')
                        ->where('siswa_nis',$siswa_nis)
                        ->where('tapel_nama',$tapel_nama)
                        ->where('kelas_nama',$kelas_nama)
                        ->count();

                    if($cektagihansiswa>0){
                        //jika sudah ada maka update nominal tagihan
                        tagihansiswa::where('siswa_nis',$siswa_nis)
                        ->where('tapel_nama',$tapel_nama)
                        ->where('kelas_nama',$kelas_nama)
                        ->update([
                            'siswa_nama'=>$siswa_nama,
                            'nominaltagihan'=>$nominaltagihan,
                            'updated_at'=>date("Y-m-d H:i:s")
                        ]);


                    }else{
                        //jika belum ada maka insert
                            DB::table('tagihansiswa')->insert(
                                array(
                                    'siswa_nis'     =>   $siswa_nis,
                                    'siswa_nama'     =>   $siswa_nama,
                                    'tapel_nama'     =>   $tapel_nama,
                                    'kelas_nama'     =>   $kelas_nama,
                                    'tagihanatur_kd'     =>   $tagihanatur_kd,
                                    'nominaltagihan'     =>   $nominaltagihan,
                                    'created_at'=>date("Y-m-d H:i:s"),
                                    'updated_at'=>date("Y-m-d H:i:s")
                                ));

                    }

                }

        }

        return redirect()->back()->with('status','Data berhasil di Sinkroniasai!')->with('tipe','success')->with('icon','fas fa-retweet');

    }
    public function bayartagihan(Request $request,tagihansiswa $tagihansiswa)
    {

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        $request->validate([
            'nominal'=>'required|numeric|min:10000'

        ],
        [
            'nominal.required'=>'Nominal Harus diisi',
            'nominal.numeric'=>'Nominal Harus Angka',
            'nominal.min'=>'Nominal bayar minimal Rp.10.000,00',

        ]);

        //jika lebih dari total nominal maka gagal
            $sumdetailbayar = DB::table('tagihansiswadetail')
            ->where('tagihansiswa_id', '=', $tagihansiswa->id)
            ->sum('nominal');

            $kurang=$tagihansiswa->nominaltagihan-$sumdetailbayar;

            if($request->nominal>$kurang){
                $kelebihan=$request->nominal-$kurang;
                return redirect()->back()->with('status','Pembayaran gagal di lakukan! Uang Bayar Kelebihan '.$this->rupiah($kelebihan).' dari Tagihan')->with('tipe','danger')->with('icon','far fa-money-bill-alt');
            }
            // dd($kurang);

        // dd($request);
        DB::table('tagihansiswadetail')->insert(
            array(
                'tagihansiswa_id'     =>   $tagihansiswa->id,
                'nominal'     =>   $request->nominal,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ));
    return redirect()->back()->with('status','Pembayaran berhasil di lakukan!')->with('tipe','success')->with('icon','far fa-money-bill-alt');

    }

    public function bayartagihandestroy(tagihansiswadetail $tagihansiswadetail)
    {
        // dd($tagihansiswadetail);

        tagihansiswadetail::destroy($tagihansiswadetail->id);
        return redirect(URL::to('/').'/admin/tagihansiswa')->with('status','Data Pembayaran siswa berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tagihansiswa  $tagihansiswa
     * @return \Illuminate\Http\Response
     */
    public function show(tagihansiswa $tagihansiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tagihansiswa  $tagihansiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(tagihansiswa $tagihansiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tagihansiswa  $tagihansiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tagihansiswa $tagihansiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tagihansiswa  $tagihansiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(tagihansiswa $tagihansiswa)
    {
        //
    }
}
