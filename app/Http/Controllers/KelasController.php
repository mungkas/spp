<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jenjang;
use App\Models\Periode;
use App\Models\Kelas;

class KelasController extends Controller
{
    //
    public function index()
    {
        $kelas = Kelas::orderBy('created_at','desc')->paginate(10);
        return view('kelas.index', ['kelas' => $kelas]);
    }

    public function create()
    {
        $periode = Periode::all();
        $jenjang = Jenjang::all();
        return view('kelas.form', [
            'periode' => $periode,
            'jenjang' => $jenjang
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'nullable|numeric',
            'jenjang_id' => 'nullable|numeric',
            'nama' => 'required|max:255',
        ]);

        if(Kelas::create($request->input())){
            return redirect()->route('kelas.index')->with([
                'type' => 'success',
                'msg' => 'Kelas ditambahkan'
            ]);
        }else{
            return redirect()->route('kelas.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }

    public function edit(Kelas $kelas)
    {
        $periode = Periode::all();
        $jenjang = Jenjang::all();
        return view('kelas.form', [
            'periode' => $periode,
            'jenjang' => $jenjang,
            'kelas' => $kelas
        ]);
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'periode_id' => 'nullable|numeric',
            'jenjang_id' => 'nullable|numeric',
            'nama' => 'required|max:255',
        ]);

        if($kelas->fill($request->input())->save()){
            return redirect()->route('kelas.index')->with([
                'type' => 'success',
                'msg' => 'Kelas diubah'
            ]);
        }else{
            return redirect()->route('kelas.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }

    public function destroy(Kelas $kelas)
    {
        if($kelas->siswa->count() != 0){
            return redirect()->route('kelas.index')->with([
                'type' => 'danger',
                'msg' => 'Tidak dapat menghapus kelas yang memiliki siswa'
            ]);
        }
        if($kelas->delete()){
            return redirect()->route('kelas.index')->with([
                'type' => 'success',
                'msg' => 'Kelas dihapus'
            ]);
        }else{
            return redirect()->route('kelas.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }
}
