<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\KirimEmail;
use App\Models\Tagihan;
use App\Models\Jenjang;
use App\Models\Siswa;
use App\Models\Role;
use Illuminate\Support\Facades\Redirect;

class TagihanController extends Controller
{
    //
    public function index()
    {
        $tagihan = Tagihan::orderBy('created_at','desc')->paginate(10);
        return view('tagihan.index', ['tagihan' => $tagihan]);
    }

    public function create()
    {
        $jenjang = Jenjang::all();
        $siswa = Siswa::all();
        return view('tagihan.form',[
            'jenjang' => $jenjang,
            'siswa' => $siswa
        ]);
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'jumlah' => 'required|numeric',
            'peserta' => 'required|numeric'
            // 'tgl_mulai' => 'required|date|before:'.$request->tgl_selesai,
            // 'tgl_selesai' => 'required|date'
        ]);

        $tagihan = Tagihan::make($request->except('jenjang_id'));
        $siswa = new Siswa;

        switch($request->peserta){
            case 1: // semua
                $tagihan->wajib_semua = 1;
                break;
            case 2: // hanya jenjang
                $tagihan->jenjang_id = $request->jenjang_id;
                break;
            case 3: // siswa , make role
                $tagihan->save();
                foreach($request->siswa_id as $siswa_id){
                    $tagihan->siswa()->save(Siswa::find($siswa_id));
                }
                break;
            default:
                return Redirect::back()->withErrors(['Peserta Wajib diisi']);
        }

        if($tagihan->save()){
            return redirect()->route('tagihan.index')->with([
                'type' => 'success',
                'msg' => 'Item Tagihan ditambahkan'
            ]);
        }else{
            return redirect()->route('tagihan.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }

    public function edit(Tagihan $tagihan)
    {
        $jenjang = Jenjang::all();
        $siswa = Siswa::all();
        return view('tagihan.form',[
            'jenjang' => $jenjang,
            'siswa' => $siswa,
            'tagihan' => $tagihan
        ]);
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'jumlah' => 'required|numeric',
            'peserta' => 'required|numeric'
            // 'tgl_mulai' => 'required|date|before:'.$request->tgl_selesai,
            // 'tgl_selesai' => 'required|date'
        ]);

        $tagihan->fill($request->except('jenjang_id'));
        
        //remove all related
        $tagihan->siswa()->detach();
        $tagihan->jenjang_id = null;
        $tagihan->wajib_semua = null;

        switch($request->peserta){
            case 1: // semua
                $tagihan->wajib_semua = 1;
                break;
            case 2: // hanya jenjang
                $tagihan->jenjang_id = $request->jenjang_id;
                break;
            case 3: // siswa , make role
                foreach($request->siswa_id as $siswa_id){
                    $tagihan->siswa()->save(Siswa::find($siswa_id));
                }
                break;
            default:
                return Redirect::back()->withErrors(['Peserta Wajib diisi']);
        }

        if($tagihan->save()){
            return redirect()->route('tagihan.index')->with([
                'type' => 'success',
                'msg' => 'Item Tagihan diubah'
            ]);
        }else{
            return redirect()->route('tagihan.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }

    public function destroy(Tagihan $tagihan)
    {
        if($tagihan->transaksi->count() != 0){
            return redirect()->route('tagihan.index')->with([
                'type' => 'danger',
                'msg' => 'tidak dapat menghapus tagihan yang masih memiliki transaksi'
            ]);
        }
        $tagihan->siswa()->detach();
        if($tagihan->delete()){
            return redirect()->route('tagihan.index')->with([
                'type' => 'success',
                'msg' => 'tagihan telah dihapus'
            ]);
        }
    }
}
