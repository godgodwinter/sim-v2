<?php

namespace App\Http\Controllers;

use App\Models\pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class pengeluaranController extends Controller
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
        $pages='pengeluaran';
        $jmldata='0';
        $datas='0';
        $month=date('m');
        $year=date('Y');


        

        $datas=DB::table('pengeluaran')
        ->whereMonth('tglbayar', '=', $month)
        ->whereYear('tglbayar', '=', $year)
        ->orderBy('tglbayar','desc')
        ->paginate($this->paginationjml());
        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','pengeluaran')->get();
        $jmldata = DB::table('pengeluaran')->count();

        return view('admin.pengeluaran.index',compact('pages','jmldata','datas','kategori','request'));
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
        $pages='pengeluaran';
        $jmldata='0';
        $datas='0';

if($yearmonth!==null){

    $datas=DB::table('pengeluaran')
    ->where('nama','like',"%".$cari."%")
    ->where('kategori_nama','like',"%".$kategori_nama."%")
    ->whereMonth('tglbayar', '=', $month)
    ->whereYear('tglbayar', '=', $year)
    ->paginate($this->paginationjml());
}else{

    $datas=DB::table('pengeluaran')
    ->where('nama','like',"%".$cari."%")
    ->where('kategori_nama','like',"%".$kategori_nama."%")
    ->paginate($this->paginationjml());
}

        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','pengeluaran')->get();
        $jmldata = DB::table('pengeluaran')->count();


        return view('admin.pengeluaran.index',compact('pages','jmldata','datas','kategori','request'));
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
        pengeluaran::create($request->all());
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,pengeluaran $pengeluaran)
    {
        #WAJIB
        $pages='pengeluaran';
        $jmldata='0';
        $datas='0';
        $month=date('m');
        $year=date('Y');


        

        $datas=DB::table('pengeluaran')
        ->whereMonth('tglbayar', '=', $month)
        ->whereYear('tglbayar', '=', $year)
        ->orderBy('tglbayar','desc')
        ->paginate($this->paginationjml());
        $jmldata = DB::table('pengeluaran')->count();
        $kategori = DB::table('kategori')->where('prefix','pengeluaran')->get();
        return view('admin.pengeluaran.edit',compact('pengeluaran','pages','jmldata','datas','kategori','request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pengeluaran $pengeluaran)
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

        pengeluaran::where('id',$pengeluaran->id)
            ->update([
                'nama'=>$request->nama,
                'catatan'=>$request->catatan,
                'nominal'=>$request->nominal,
                'kategori_nama'=>$request->kategori_nama,
                'tglbayar'=>$request->tglbayar,
            ]);
            return redirect(URL::to('/').'/admin/pengeluaran')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(pengeluaran $pengeluaran)
    {
        pengeluaran::destroy($pengeluaran->id);
        return redirect(URL::to('/').'/admin/pengeluaran')->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    
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
        pengeluaran::whereIn('id',$ids)->delete();

        
        // load ulang
     
        #WAJIB
        $pages='pengeluaran';
        $jmldata='0';
        $datas='0';


        $month=date('m');
        $year=date('Y');


        

        $datas=DB::table('pengeluaran')
        ->whereMonth('tglbayar', '=', $month)
        ->whereYear('tglbayar', '=', $year)
        ->orderBy('tglbayar','desc')
        ->paginate($this->paginationjml());
        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','pengeluaran')->get();
        $jmldata = DB::table('pengeluaran')->count();

        return view('admin.pengeluaran.index',compact('pages','jmldata','datas','kategori','request'));

    }
}
