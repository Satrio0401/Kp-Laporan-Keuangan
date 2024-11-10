<?php
namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        $Pengeluarans = Pengeluaran::all();
        return view('Laporan Pengeluaran.index', compact('Pengeluarans'));
    }

    public function tambahdata()
    {
        return view('Laporan Pengeluaran.tambahdata');
    }

    public function insertdata(Request $request)
    {
        // Validasi data jika diperlukan
        $request->validate([
            'kode_biaya' => 'required|string',
            'tanggal_pengeluaran' => 'required|date',
            'biaya_untuk' => 'required|string',
            'total_pengeluaran' => 'required|numeric', // Ubah ke total_pengeluaran
        ]);

        Pengeluaran::create([
            'kode_biaya' => $request->input('kode_biaya'),
            'tanggal_pengeluaran' => $request->input('tanggal_pengeluaran'),
            'biaya_untuk' => $request->input('biaya_untuk'),
            'total_pengeluaran' => $request->input('total_pengeluaran'), // Simpan total_pengeluaran
        ]);

        return redirect('/LaporanPengeluaran')->with('success', 'Data pengeluaran berhasil ditambahkan!');
    }

    public function updatedata(Request $request, $kode_biaya)
    {
        $Pengeluarans = Pengeluaran::find($kode_biaya);

        // Validasi data jika diperlukan
        $request->validate([
            'kode_biaya' => 'required|string',
            'tanggal_pengeluaran' => 'required|date',
            'biaya_untuk' => 'required|string',
            'total_pengeluaran' => 'required|numeric', // Ubah ke total_pengeluaran
        ]);

        $Pengeluarans->update([
            'kode_biaya' => $request->input('kode_biaya'),
            'tanggal_pengeluaran' => $request->input('tanggal_pengeluaran'),
            'biaya_untuk' => $request->input('biaya_untuk'),
            'total_pengeluaran' => $request->input('total_pengeluaran'), // Simpan total_pengeluaran
        ]);

        return redirect('/LaporanPengeluaran')->with('success', 'Data pengeluaran berhasil diperbarui!');
    }

    public function editdata($kode_biaya)
    {
        $Pengeluarans = Pengeluaran::where('kode_biaya', $kode_biaya)->first();

        // Cek apakah data ditemukan
        if (!$Pengeluarans) {
            return redirect('/LaporanPengeluaran')->with('error', 'Data pengeluaran tidak ditemukan!');
        }

        return view('Laporan Pengeluaran.editdata', compact('Pengeluarans'));
    }

    public function delete($kode_biaya)
    {
        $Pengeluarans = Pengeluaran::find($kode_biaya);
        $Pengeluarans->delete();
        return redirect('/LaporanPengeluaran')->with('success', 'Data Berhasil Dihapus');
    }

    public function searchOrPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query untuk filter berdasarkan tanggal pengeluaran
        $query = Pengeluaran::query();

        if ($startDate) {
            $query->whereDate('tanggal_pengeluaran', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal_pengeluaran', '<=', $endDate);
        }

        // Ambil data pengeluaran berdasarkan filter
        $Pengeluarans = $query->get();

        // Hitung total pengeluaran
        $totalBiaya = $Pengeluarans->sum('total_pengeluaran'); // Ganti 'jumlah' dengan 'total_pengeluaran'

        // Cek apakah ini permintaan untuk PDF atau untuk search
        if ($request->route()->getName() == 'LaporanPengeluaran.cetakpdf') {
            // Jika untuk PDF, render view ke HTML dan buat PDF
            $html = view('Laporan Pengeluaran.cetakpdf', compact('Pengeluarans', 'totalBiaya'))->render();
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
            $mpdf->WriteHTML($html);
            return $mpdf->Output('Laporan Pengeluaran.pdf', 'I'); // Menampilkan PDF di browser
        } else {
            // Jika untuk search, kembali ke view pencarian
            return view('Laporan Pengeluaran.index', compact('Pengeluarans', 'totalBiaya'));
        }
    }
}
