<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\tagihan;
use App\Models\tagihandetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class admintagihancontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(Request $request)
    {
        #WAJIB
        $pages='tagihan';
        $datas=tagihan::orderBy('updated_at','desc')->paginate(Fungsi::paginationjml());

        return view('pages.admin.tagihan.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='tagihan';
        $datas=tagihan::where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.tagihan.index',compact('datas','request','pages'));
    }
    public function create()
    {
        $pages='tagihan';

        $tipe=DB::table('kategori')->where('prefix','tipetagihan')->get();

        return view('pages.admin.tagihan.create',compact('pages','tipe'));
    }

    public function store(Request $request)
    {
        // ubah rupiah ke angka
        //jika tidak ada angka maka kembali dan keterangan erro
    $request->validate([
        'total'=>'required',
        ],
        [
            'total.required'=>'Total tagihan Tidak boleh kosong',
        ]);

        $total=$request->total;

        $angka = Fungsi::toangka($total);
        $request->total=$angka;
        if($angka=='' || $angka==null || $angka <=0){
            $request->validate([
                'total'=>'required|integer|min:1',
                ],
                [
                    'total.required'=>'Total tagihan Tidak boleh kosong',
                    'total.integer'=>'Nominal tidak valid / tidak boleh 0',
                ]);
                // return redirect()->back()->with('status','Gagal Total Tagihan tidak valid!')->with('tipe','error')->with('icon','fas fa-feather');

        }
        // dd($total,$angka,$request->total);
        // $cek=DB::table('tagihan')
        // ->where('nama',$request->nama)
        // ->count();
        //     if($cek>0){
        //             $request->validate([
        //             'nama'=>'required|unique:tagihan,nama',
        //             ],
        //             [
        //                 'nama.unique'=>'nama sudah digunakan',
        //             ]);

        //     }

            $request->validate([
                'nama'=>'required',

            ],
            [
                'nama.nama'=>'Nama harus diisi',
            ]);

            // dd($angka);
            DB::table('tagihan')->insert(
                array(
                        'nama'     =>   $request->nama,
                        // 'tipe'     =>   $request->tipe,
                        'tingkatan'     =>   $request->tingkatan,
                        'jurusan'     =>   $request->jurusan,
                        'tagihan'     =>   $angka,
                        'total'     =>   $angka,
                        'semester'     =>   $request->semester,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));



        return redirect()->route('sync.tagihantodetail')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(tagihan $id)
    {
        $pages='tagihan';

        $tipepelajaran=DB::table('kategori')->where('prefix','tipepelajaran')->get();
        return view('pages.admin.tagihan.edit',compact('pages','id','tipepelajaran'));
    }
    public function update(tagihan $id,Request $request)
    {
        // ubah rupiah ke angka
        //jika tidak ada angka maka kembali dan keterangan erro
    $request->validate([
        'total'=>'required',
        ],
        [
            'total.required'=>'Total tagihan Tidak boleh kosong',
        ]);

        $total=$request->total;

        $angka = Fungsi::toangka($total);
        $request->total=$angka;
        if($angka=='' || $angka==null || $angka <=0){
            $request->validate([
                'total'=>'required|integer|min:1',
                ],
                [
                    'total.required'=>'Total tagihan Tidak boleh kosong',
                    'total.integer'=>'Nominal tidak valid / tidak boleh 0',
                ]);
                // return redirect()->back()->with('status','Gagal Total Tagihan tidak valid!')->with('tipe','error')->with('icon','fas fa-feather');

        }

        // if($request->nama!==$id->nama){

        //     $request->validate([
        //         'nama' => "required",
        //     ],
        //     [
        //     ]);
        // }

        $request->validate([
            'nama'=>'required',
        ],
        [
            'nama.required'=>'nama harus diisi',
        ]);


        tagihan::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            // 'tipe'     =>   $request->tipe,
            'tingkatan'     =>   $request->tingkatan,
            'jurusan'     =>   $request->jurusan,
            'tagihan'     =>   $angka,
            'total'     =>   $angka,
            'semester'     =>   $request->semester,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('sync.tagihantodetail')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(tagihan $id){

        tagihan::destroy($id->id);
        tagihandetail::where('tagihan_id',$id->id)->delete();
        return redirect()->route('tagihan')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        tagihan::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='tagihan';
        $datas=tagihan::paginate(Fungsi::paginationjml());

        return view('pages.admin.tagihan.index',compact('datas','request','pages'));

    }
}
