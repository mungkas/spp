<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Exports\KeuanganExport;
use Maatwebsite\Excel\Facades\Excel;

class KeuanganController extends Controller
{
    //
    public function index()
    {
        $keuangan = Keuangan::orderBy('created_at','desc')->paginate(10);
        return view('keuangan.index', [
            'keuangan' => $keuangan,
            
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([

            'siswa_id' => 'nullable|numeric',
            'tagihan_id' => 'nullable|numeric',
            'keperluan' => 'required|in:in,out',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable',
        ]);

        $keuangan = Keuangan::orderBy('created_at','desc')->first();
        if($keuangan != null){
            $simpan = Keuangan::make([
                'siswa_id' => $request->siswa_id,
                'tagihan_id' => $request->tagihan_id,
                'tipe' => $request->keperluan,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan
            ]);
            if($request->keperluan == 'in'){
                $simpan->total_kas = $keuangan->total_kas + $request->jumlah;
            }else if($request->keperluan == 'out'){
                $simpan->total_kas = $keuangan->total_kas - $request->jumlah;
            }
        }else{
            $simpan = Keuangan::make([
                'siswa_id' => $request->siswa_id,
                'tagihan_id' => $request->tagihan_id,
                'tipe' => $request->keperluan,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan
            ]);
            $simpan->total_kas = $request->jumlah;
        }

        if($simpan->save()){
            return redirect()->route('keuangan.index')->with([
                'type' => 'success',
                'msg' => 'Pencatatan Keuangan dibuat'
            ]);
        }else{
            return redirect()->route('keuangan.index')->with([
                'type' => 'danger',
                'msg' => 'Terjadi Kesalahan'
            ]);
        }

    }

    public function export()
    {
        return Excel::download(new KeuanganExport, 'mutasi_keuangan-'.now().'.xlsx');
    }
}
