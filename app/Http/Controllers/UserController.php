<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //

    public function index()
    {
        $users = User::orderBy('created_at','desc')->paginate(5);
        return view('users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('users.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|in:Admin,TU,Pegawai'
        ]);

        if(User::create($request->input())){
            return redirect()->route('user.index')->with([
                'type' => 'success',
                'msg' => 'Pengguna ditambahkan'
            ]);
        }else{
            return redirect()->route('user.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }

    public function edit(User $user)
    {
        return view('users.form', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|confirmed|min:8',
            'role' => 'required|in:Admin,TU,Pegawai'
        ]);

        if($request->password != null){
            $user->fill($request->input());
        }else{
            $user->fill($request->except('password'));
        }

        if($user->save()){
            return redirect()->route('user.index')->with([
                'type' => 'success',
                'msg' => 'Pengguna diubah'
            ]);
        }else{
            return redirect()->route('user.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }

    public function destroy(User $user)
    {
        if($user->delete()){
            return redirect()->route('user.index')->with([
                'type' => 'success',
                'msg' => 'Pengguna dihapus'
            ]);
        }else{
            return redirect()->route('user.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }
}
