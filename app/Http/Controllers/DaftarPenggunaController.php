<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DaftarPenggunaController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('Daftar Pengguna.index',compact(['users']));
    }

    public function tambahdata()
    {
        return view('Daftar Pengguna.tambahdata');
    }

    public function insertdata(Request $request)
    {
        User::create($request->all());
        return redirect('/DaftarPengguna');
    }

    public function editdata($id)
    {
        $users = Penggunas::find($id);
        return view('Daftar Pengguna.editdata',compact(['users']));
    }

    public function updatedata(Request $request, $id)
    {
        $users = User::find($id);
        $users->update($request->all());
        return redirect('/DaftarPengguna');
    }

    public function delete($id)
    {
        $users = Pengguna::find($id);
        $users->delete();
        return redirect('/DaftarPengguna');
    }
}
