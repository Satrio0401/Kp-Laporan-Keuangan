<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        return view('Daftar Supplier.index', compact('supplier'));
    }

    public function tambahdata()
    {
        return view('Daftar Supplier.tambahdata');
    }

    public function insertdata(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kode_supplier' => 'required|string|max:10|unique:supplier,kode_supplier',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'email' => 'required|email',
            'alamat' => 'required|string|max:255',
        ]);

        // Menyimpan data supplier baru
        Supplier::create($validatedData);
        return redirect ('/DaftarSupplier')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function editdata($kode_supplier)
    {
        $supplier = Supplier::where('kode_supplier', $kode_supplier)->firstOrFail(); // Menggunakan kode_supplier
        return view('Daftar Supplier.editdata', compact('supplier'));
    }

    public function updatedata(Request $request, $kode_supplier)
{
    // Temukan supplier berdasarkan kode_supplier
    $supplier = Supplier::where('kode_supplier', $kode_supplier)->first();

    // Jika supplier ditemukan, lakukan update
    if ($supplier) {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric',
            'email' => 'required|email',
            'alamat' => 'required|string|max:255',
        ]);

        // Update data supplier
        $supplier->update($validatedData);


        return redirect('/DaftarSupplier')->with('success', 'Data supplier berhasil diupdate');
    } else {
        return redirect('/DaftarSupplier')->with('error', 'Supplier tidak ditemukan');
    }
}


    
    public function delete($kode_supplier)
    {
        $supplier = Supplier::where('kode_supplier', $kode_supplier)->firstOrFail();
        $supplier->delete();
        return redirect ('/DaftarSupplier')->with('success', 'Supplier berhasil dihapus.');
    }
}
