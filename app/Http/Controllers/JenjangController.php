<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jenjang;
use App\Models\Periode;

class JenjangController extends Controller
{
    //
    public function index()
    {
        $jenjang = Jenjang::orderBy('created_at','desc')->paginate(10);
        return view('jenjang.index', ['jenjang' => $jenjang]);
    }

    public function create()
    {
        $periode = Periode::all();
        return view('jenjang.form', ['periode' => $periode]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'nullable|numeric',
            'nama' => 'required|max:255',
        ]);

        if(Jenjang::create($request->input())){
            return redirect()->route('jenjang.index')->with([
                'type' => 'success',
                'msg' => 'Jenjang ditambahkan'
            ]);
        }else{
            return redirect()->route('jenjang.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }

    public function edit(Jenjang $jenjang)
    {
        $periode = Periode::all();
        return view('jenjang.form', [
            'periode' => $periode,
            'jenjang' => $jenjang
        ]);
    }

    public function update(Request $request, Jenjang $jenjang)
    {
        $request->validate([
            'periode_id' => 'nullable|numeric',
            'nama' => 'required|max:255',
        ]);

        if($jenjang->fill($request->input())->save()){
            return redirect()->route('jenjang.index')->with([
                'type' => 'success',
                'msg' => 'Jenjang diubah'
            ]);
        }else{
            return redirect()->route('jenjang.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }

    public function destroy(Jenjang $jenjang)
    {
        if($jenjang->siswa->count() != 0){
            return redirect()->route('jenjang.index')->with([
                'type' => 'danger',
                'msg' => 'Tidak dapat menghapus jenjang yang memiliki siswa'
            ]);
        }
        if($jenjang->delete()){
            return redirect()->route('jenjang.index')->with([
                'type' => 'success',
                'msg' => 'Jenjang dihapus'
            ]);
        }else{
            return redirect()->route('jenjang.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }
}
