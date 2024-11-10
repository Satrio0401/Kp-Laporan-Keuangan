<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Menampilkan daftar menu
    public function index()
    {
        $menu = Menu::all(); // Ambil semua data menu
        return view('Daftar Barang.index', compact('menu')); // Kirim data ke view
    }

    // Menampilkan form tambah menu
    public function tambahdata()
    {
        return view('Daftar Barang.tambahdata'); // Tampilkan form tambah data
    }

    // Menginsert data menu
    public function insertdata(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        // Buat menu baru
        Menu::create($validatedData);

        // Redirect kembali ke daftar menu dengan pesan sukses
        return redirect('/DaftarMenu')->with('success', 'Data Berhasil Ditambah');
    }

    // Menampilkan form edit menu
    public function editdata($id)
    {
        $menu = Menu::findOrFail($id); // Temukan menu berdasarkan ID
        return view('Daftar Barang.editdata', compact('menu')); // Kirim data ke view
    }

    // Mengupdate data menu
    public function updatedata(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $menu = Menu::findOrFail($id); // Temukan menu berdasarkan ID
        $menu->update($validatedData); // Update data menu

        // Redirect kembali ke daftar menu dengan pesan sukses
        return redirect('/DaftarMenu')->with('success', 'Data Berhasil Diubah');
    }

    // Menghapus data menu
    public function delete($id)
    {
        $menu = Menu::findOrFail($id); // Temukan menu berdasarkan ID
        $menu->delete(); // Hapus menu

        // Redirect kembali ke daftar menu dengan pesan sukses
        return redirect('/DaftarMenu')->with('success', 'Data Berhasil Dihapus');
    }
}
