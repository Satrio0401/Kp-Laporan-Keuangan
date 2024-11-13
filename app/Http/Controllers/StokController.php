<?php

namespace App\Http\Controllers;

use App\Models\LaporanStok; // Pastikan ini menggunakan model yang tepat
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $stoks = LaporanStok::all(); // Mengambil semua data dari model LaporanStok
        return view('Laporan Stok.index', compact('stoks')); // Menggunakan variabel dengan huruf kecil untuk konvensi
    }

    public function tambahdata()
    {
        return view('Laporan Stok.tambahdata');
    }

    public function insertdata(Request $request)
    {
        // Validasi input sebelum menyimpan
        $request->validate([
            'kode_barang' => 'required|string|max:50|unique:laporan_stok,kode_barang',
            'nama_barang' => 'required|string|max:100',
            'jumlah_tersedia' => 'required|integer|min:0',
        ]);

        // Membuat data baru di tabel laporan_stok
        LaporanStok::create($request->all());
        return redirect('/LaporanStok')->with('success', 'Data berhasil ditambahkan!'); // Pesan sukses
    }

    public function editdata($kode_barang) // Ubah parameter menjadi kode_barang
    {
        $stoks = LaporanStok::where('kode_barang', $kode_barang)->first(); // Mencari data berdasarkan kode_barang
        if (!$stoks) {
            return redirect('/LaporanStok')->with('error', 'Data tidak ditemukan!'); // Penanganan jika data tidak ditemukan
        }
        return view('Laporan Stok.editdata', compact('stoks')); // Menggunakan variabel dengan huruf kecil
    }

    public function updatedata(Request $request, $kode_barang) // Ubah parameter menjadi kode_barang
    {
        $stoks = LaporanStok::where('kode_barang', $kode_barang)->first(); // Mencari data yang akan diperbarui

        if (!$stoks) {
            return redirect('/LaporanStok')->with('error', 'Data tidak ditemukan!'); // Penanganan jika data tidak ditemukan
        }

        // Validasi input sebelum memperbarui
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'jumlah_tersedia' => 'required|integer|min:0',
        ]);

        // Memperbarui data
        $stoks->update($request->only(['nama_barang', 'jumlah_tersedia'])); // Mengupdate hanya kolom yang relevan
        return redirect('/LaporanStok')->with('success', 'Data berhasil diperbarui!'); // Pesan sukses
    }

    public function delete($kode_barang) // Ubah parameter menjadi kode_barang
    {
        $stoks = LaporanStok::where('kode_barang', $kode_barang)->first(); // Mencari data berdasarkan kode_barang

        if (!$stoks) {
            return redirect('/LaporanStok')->with('error', 'Data tidak ditemukan!'); // Penanganan jika data tidak ditemukan
        }

        $stoks->delete(); // Menghapus data
        return redirect('/LaporanStok')->with('success', 'Data berhasil dihapus!'); // Mengarahkan kembali dengan pesan sukses
    }

    
    public function searchOrPdf(Request $request)
    {
        $query = LaporanStok::query();
        // Ambil data pembelian berdasarkan filter
        $stoks = $query->get();

        // Cek apakah ini permintaan untuk PDF atau untuk tampilan pencarian
        if ($request->route()->getName() == 'LaporanStok.cetakpdf') {
            $html = view('Laporan Stok.cetakpdf', compact('stoks'))->render();
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
            $mpdf->WriteHTML($html);
            return $mpdf->Output('Laporan_Stok.pdf', 'I');
        } else {
            return view('Laporan Stok.index', compact('stoks'));
        }
    }

}

