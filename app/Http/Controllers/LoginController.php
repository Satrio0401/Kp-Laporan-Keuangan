<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function index()
    {
        return view("Login.index");
    }

    public function loginproses(Request $request)
    {
        if(Auth::attempt($request->only('name','password'))){
            return redirect('/LaporanPembelian')->with('success','Welcome Admin');
        }

        return redirect('/')->with('gagal','Username atau Password Salah');
    }
}
