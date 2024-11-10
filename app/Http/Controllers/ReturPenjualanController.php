<?php

namespace App\Http\Controllers;

use App\Models\ReturPemesanan;
use App\Models\TransaksiPenjualan;
use App\Models\Menu; // Pastikan model Menu sudah ada
use Illuminate\Http\Request;

class ReturPenjualanController extends Controller
{
    public function index()
    {
        // Mengambil semua data retur_pemesanan dengan data transaksi_penjualan terkait
        $returPemesanan = ReturPemesanan::with('transaksiPenjualan')->paginate(10); // Pagination
        return view('Laporan Retur Pemesanan.index', compact('returPemesanan'));
    }

    public function tambahdata()
    {
        // Ambil semua data dari tabel transaksi_penjualan dan menu
        $transaksiPenjualan = TransaksiPenjualan::all();
        $menu = Menu::all(); // Ambil semua data dari tabel menu
        return view('Laporan Retur Pemesanan.tambahdata', compact('transaksiPenjualan', 'menu'));
    }

    public function insertdata(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'no_faktur' => 'required|string|exists:transaksi_penjualan,no_faktur',
            'tanggal_retur' => 'required|date',
            'id_menu' => 'required|exists:menu,id',
            'jumlah_dikembalikan' => 'required|integer',
            'alasan' => 'required|string',
        ]);

        // Ambil harga satuan dari menu berdasarkan id_menu
        $menu = Menu::findOrFail($request->id_menu); // Using findOrFail for better error handling
        $total_harga = $menu->harga * $request->jumlah_dikembalikan; // Hitung total harga

        // Siapkan data untuk disimpan
        $data = [
            'no_faktur' => $request->no_faktur,
            'tanggal_retur' => $request->tanggal_retur,
            'id_menu' => $request->id_menu,
            'jumlah_dikembalikan' => $request->jumlah_dikembalikan,
            'alasan' => $request->alasan,
            'total_harga' => $total_harga, // Tambahkan total_harga
            'status' => 'pending' // Status default
        ];

        // Simpan data baru ke tabel retur_pemesanan
        ReturPemesanan::create($data);

        return redirect('/LaporanReturPemesanan')->with('success', 'Data retur pemesanan berhasil ditambahkan!');
    }

    public function editdata($id) // Menggunakan id sebagai parameter
    {
        $returPemesanan = ReturPemesanan::findOrFail($id); // Mengambil data berdasarkan id
        $transaksiPenjualan = TransaksiPenjualan::all(); // Ambil semua data dari tabel transaksi_penjualan
        $menus = Menu::all(); // Ambil semua data dari tabel menu
        return view('Laporan Retur Pemesanan.editdata', compact('returPemesanan', 'transaksiPenjualan', 'menus'));
    }

    public function updatedata(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'tanggal_retur' => 'required|date',
            'jumlah_dikembalikan' => 'required|integer',
            'id_menu' => 'required|exists:menu,id', // Validasi id_menu harus ada di tabel menu
        ]);
    
        // Temukan data berdasarkan id
        $returPemesanan = ReturPemesanan::findOrFail($id);
    
        // Update data
        $returPemesanan->tanggal_retur = $request->input('tanggal_retur');
        $returPemesanan->id_menu = $request->input('id_menu');
        $returPemesanan->jumlah_dikembalikan = $request->input('jumlah_dikembalikan');
        $returPemesanan->alasan = $request->input('alasan'); // Pastikan ini sesuai jika Anda ingin mengizinkan alasan untuk diupdate
        $returPemesanan->save();
    
        return redirect()->route('LaporanReturPemesanan.index')->with('success', 'Data berhasil diperbarui!');
    }
    
    

    public function delete($id) // Menggunakan id sebagai parameter
    {
        $returPemesanan = ReturPemesanan::findOrFail($id); // Mengambil data berdasarkan id
        $returPemesanan->delete();
        return redirect('/LaporanReturPemesanan')->with('success', 'Data berhasil dihapus!');
    }

    public function updateStatus(Request $request, $id) // Menggunakan id sebagai parameter
    {
        $request->validate([
            'status' => 'required|string|in:diterima,ditolak',
        ]);

        $returPemesanan = ReturPemesanan::findOrFail($id); // Mengambil data berdasarkan id
        $returPemesanan->status = $request->input('status');
        $returPemesanan->save();

        return redirect('/LaporanReturPemesanan')->with('success', 'Status berhasil diperbarui!');
    }

    public function searchOrPdf(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Query untuk filter berdasarkan tanggal retur dengan relasi transaksi_penjualan
    $query = ReturPemesanan::with('transaksiPenjualan');

    if ($startDate) {
        $query->whereDate('tanggal_retur', '>=', $startDate);
    }

    if ($endDate) {
        $query->whereDate('tanggal_retur', '<=', $endDate);
    }

    // Ambil data retur pemesanan berdasarkan filter
    $returPemesanan = $query->get();

    // Hitung total jumlah yang dikembalikan
    $totalJumlahDikembalikan = $returPemesanan->sum('jumlah_dikembalikan');

    // Cek apakah ini permintaan untuk PDF atau untuk search
    if ($request->route()->getName() == 'laporanreturpemesanan.cetakpdf') {
        $html = view('Laporan Retur Pemesanan.cetakpdf', compact('returPemesanan', 'totalJumlahDikembalikan'))->render();
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $mpdf->WriteHTML($html);
        return $mpdf->Output('Laporan_Retur_Pemesanan.pdf', 'I');
    } else {
        return view('Laporan Retur Pemesanan.index', compact('returPemesanan', 'totalJumlahDikembalikan'));
    }
}

}
