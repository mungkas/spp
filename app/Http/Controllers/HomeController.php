<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Keuangan;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Exports\LaporanHarianExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Siswa;
use App\Models\Jenjang;

class HomeController extends Controller
{
    //

    public function index(){
        
        $total_uang_spp = Keuangan::where('transaksi_id','!=','null')->sum('jumlah');

        $transaksi = Transaksi::orderBy('siswa_id','desc')->whereMonth('created_at', date('m'))->get();
        
        $siswa = Siswa::count();
        $item = Tagihan::count();
        $jenjang = Jenjang::count();

        return view('dashboard.index',[
            'total_uang_spp' => $total_uang_spp,
            'transaksi' => $transaksi,
            'jumlah' => '0',
            'siswa' => $siswa,
            'item' => $item,
            'jenjang' => $jenjang,
        ]);
    }

    public function pengaturan(){
        $pengaturan = DB::table('pengaturan')->first();
        if($pengaturan == null){
            DB::table('pengaturan')->insert(['nama' => 'Sistem Pembayaran Menara Ilmu']);
            $pengaturan = DB::table('pengaturan')->first();
        }
        return view('pengaturan.index', ['pengaturan' => $pengaturan]);
    }

    public function editpengaturan(){
        $pengaturan = DB::table('pengaturan')->first();
        return view('pengaturan.form', ['pengaturan' => $pengaturan]);
    }

    public function storePengaturan(Request $request){
        $request->validate([
            'nama' => 'required|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        if($request->hasFile('logo')){
            $logo = $request->file('logo');
            $logo->storeAs('img','logo.jpg','standart');
            $logo = $logo->hashName();
            DB::table('pengaturan')->update(['nama' => $request->nama, 'logo' => $logo]);
        }else{
            DB::table('pengaturan')->update(['nama' => $request->nama]);
        }

        return redirect()->route('pengaturan.index')->with([
            'type' => 'success',
            'msg' => 'Pengaturan diubah'
        ]);
    }

    public function cetak(Request $request){

        $q = $request->get('q');
        if($q == null){
            $siswa = Siswa::orderBy('created_at','desc')->paginate(15);
        }else{
            $siswa = Siswa::where('jenjang_id','like','%'.$q.'%')->orderBy('created_at','desc')->paginate(15);
        }
        $date = \Carbon\Carbon::create($request->date)->format('Y-m-d');
        $transaksi = Transaksi::orderBy('siswa_id','desc')->whereDate('created_at', $date)->get();

        return view('dashboard.export', ['transaksi' => $transaksi, 'siswa' => $siswa, 'date' => $request->date, 'jumlah' => 0, 'print' => true]);
    }

    public function export(Request $request){
        $date = \Carbon\Carbon::create($request->date)->format('Y-m-d');
        return Excel::download(new LaporanHarianExport($date, $request->date), 'laporan-harian-'.now().'.xlsx');
    }
}
