<?php

namespace App\Http\Controllers;

use App\Models\pemasukan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class pemasukanController extends Controller
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
        #WAJIB
        $pages='pemasukan';
        $jmldata='0';
        $datas='0';
        $month=date('m');
        $year=date('Y');


        

        $datas=DB::table('pemasukan')
        ->whereMonth('tglbayar', '=', $month)
        ->whereYear('tglbayar', '=', $year)
        ->orderBy('tglbayar','desc')
        ->paginate($this->paginationjml());
        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','pemasukan')->get();
        $jmldata = DB::table('pemasukan')->count();
        $sekarang = Carbon::now();

        return view('admin.pemasukan.index',compact('pages','jmldata','datas','kategori','sekarang','request'));
    }

    public function cari(Request $request)
    {
        // dd($request);
        $cari=$request->cari;
        $yearmonth=$request->yearmonth;
        $kategori_nama=$request->kategori_nama;

        $year = date("Y",strtotime($yearmonth));
        $month = date("m",strtotime($yearmonth));
        // $year = date_format($yearmonth, "Y");
        // $month = date_format($yearmonth, "m");
        // dd($year);
        #WAJIB
        $pages='pemasukan';
        $jmldata='0';
        $datas='0';

if($yearmonth!==null){

    $datas=DB::table('pemasukan')
    ->where('nama','like',"%".$cari."%")
    ->where('kategori_nama','like',"%".$kategori_nama."%")
    ->whereMonth('tglbayar', '=', $month)
    ->whereYear('tglbayar', '=', $year)
    ->paginate($this->paginationjml());
}else{

    $datas=DB::table('pemasukan')
    ->where('nama','like',"%".$cari."%")
    ->where('kategori_nama','like',"%".$kategori_nama."%")
    ->paginate($this->paginationjml());
}

        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','pemasukan')->get();
        $jmldata = DB::table('pemasukan')->count();


        return view('admin.pemasukan.index',compact('pages','jmldata','datas','kategori','request'));
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
        $request->validate([
            'nama'=>'required',
            // 'catatan'=>'required',
            'kategori_nama'=>'required',
            'nominal'=>'required|numeric',
            'tglbayar'=>'required',

        ],
        [
            'nama.required'=>'Nama harus diisi',

        ]);
            // dd($request);
        pemasukan::create($request->all());
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,pemasukan $pemasukan)
    {

        #WAJIB
        $pages='pemasukan';
        $jmldata='0';
        $datas='0';
        $month=date('m');
        $year=date('Y');


        

        $datas=DB::table('pemasukan')
        ->whereMonth('tglbayar', '=', $month)
        ->whereYear('tglbayar', '=', $year)
        ->paginate($this->paginationjml());
        $jmldata = DB::table('pemasukan')->count();
        $kategori = DB::table('kategori')->where('prefix','pemasukan')->get();
        return view('admin.pemasukan.edit',compact('pemasukan','pages','jmldata','datas','kategori','request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function edit(pemasukan $pemasukan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pemasukan $pemasukan)
    {
        $request->validate([
            'nama'=>'required',
            'nominal'=>'required|numeric',
            // 'catatan'=>'required',
            'kategori_nama'=>'required',
            'tglbayar'=>'required',

        ],
        [
            'nama.required'=>'Nama harus diisi',

        ]);
         //aksi update

        pemasukan::where('id',$pemasukan->id)
            ->update([
                'nama'=>$request->nama,
                'catatan'=>$request->catatan,
                'nominal'=>$request->nominal,
                'kategori_nama'=>$request->kategori_nama,
                'tglbayar'=>$request->tglbayar,
            ]);
            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(pemasukan $pemasukan)
    {
        pemasukan::destroy($pemasukan->id);
        return redirect(URL::to('/').'/admin/pemasukan')->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    
    }

    public function deletechecked(Request $request)
    {
        
        $ids=$request->ids;

        // $datasiswa = DB::table('siswa')->where('id',$ids)->get();
        // foreach($datasiswa as $ds){
        //     $nis=$ds->nis;
        // }

        // dd($request);

        // DB::table('tagihansiswa')->where('siswa_nis', $ids)->where('tapel_nama',$this->tapelaktif())->delete();
        pemasukan::whereIn('id',$ids)->delete();

        
        // load ulang
     
        #WAJIB
        $pages='pemasukan';
        $jmldata='0';
        $datas='0';
        $month=date('m');
        $year=date('Y');


        

        $datas=DB::table('pemasukan')
        ->whereMonth('tglbayar', '=', $month)
        ->whereYear('tglbayar', '=', $year)
        ->paginate($this->paginationjml());
        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','pemasukan')->get();
        $jmldata = DB::table('pemasukan')->count();
        $sekarang = Carbon::now();

        return view('admin.pemasukan.index',compact('pages','jmldata','datas','kategori','sekarang','request'));

    }
}
