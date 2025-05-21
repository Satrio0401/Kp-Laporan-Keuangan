<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPenjualan;
use App\Models\PenjualanPerBarang;
use Illuminate\Http\Request;
use App\Models\Menu; 
use Illuminate\Support\Facades\DB;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        $transaksiPenjualan = TransaksiPenjualan::with(['penjualanPerBarang.menu'])->get();
        return view('Laporan Transaksi Penjualan.index', compact('transaksiPenjualan'));
    }

    public function tambahdata()
    {
        $menu = Menu::all(); // Ambil semua menu
        return view('Laporan Transaksi Penjualan.tambahdata', compact('menu'));
    }

    public function insertdata(Request $request)
    {
        // dd($request->all());

        // Validasi input
        $request->validate([
            'no_faktur' => 'required|string|max:50',
            'nama_pelanggan' => 'required|string|max:100',
            'tanggal_pemesanan' => 'required|date',
            'total_harga' => 'required|numeric',
            'menu_id' => 'required|array',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        // Simpan data transaksi penjualan
        $transaksi = TransaksiPenjualan::create([
            'no_faktur' => $request->no_faktur,
            'nama_pelanggan' => $request->nama_pelanggan,
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'total_harga' => $request->total_harga,
        ]);

        // Simpan data penjualan per barang
        $data = [];
        foreach ($request->menu_id as $index => $menuId) {
            $menu = Menu::find($menuId);
            $subtotal = $request->jumlah[$index] * $menu->harga; // Hitung subtotal

            $data[] = [
                'no_faktur' => $request->no_faktur,
                'id_menu' => $menuId,
                'jumlah' => $request->jumlah[$index],
                'harga' => $menu->harga,
                'subtotal' => $subtotal,
            ];
        }

        PenjualanPerBarang::insert($data); // Simpan data penjualan per barang
        return redirect('/LaporanTransaksiPenjualan')->with('success', 'Data berhasil ditambahkan.');
    }

    public function editdata($noFaktur)
    {
        // Mengambil transaksi berdasarkan no_faktur
        $transaksiPenjualan = TransaksiPenjualan::with('penjualanPerBarang.menu')->where('no_faktur', $noFaktur)->first();

        // Cek apakah transaksi ditemukan
        if (!$transaksiPenjualan) {
            return redirect('/LaporanTransaksiPenjualan')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Ambil semua menu (jika diperlukan untuk pemilihan menu baru)
        $menu = Menu::all();

        return view('Laporan Transaksi Penjualan.editdata', compact('transaksiPenjualan', 'menu'));
    }

    public function updatedata(Request $request, $noFaktur)
{
    // Cari transaksi berdasarkan no_faktur
    $transaksiPenjualan = TransaksiPenjualan::where('no_faktur', $noFaktur)->first();
    
    // Validasi input
    $request->validate([
        'no_faktur' => 'required|string|max:50',
        'nama_pelanggan' => 'required|string|max:100',
        'tanggal_pemesanan' => 'required|date',
        'total_harga' => 'required|numeric',
        'menu_id' => 'required|array',
        'jumlah' => 'required|array',
    ]);

    // Update transaksi penjualan
    $transaksiPenjualan->update($request->only('no_faktur', 'nama_pelanggan', 'tanggal_pemesanan', 'total_harga'));

    // Hapus semua data penjualan per barang yang terkait dengan transaksi ini
    PenjualanPerBarang::where('no_faktur', $noFaktur)->delete();

    // Simpan data penjualan per barang yang baru
    $data = [];
    foreach ($request->menu_id as $index => $menuId) {
        $menu = Menu::find($menuId);
        $subtotal = $request->jumlah[$index] * $menu->harga;

        $data[] = [
            'no_faktur' => $noFaktur,
            'id_menu' => $menuId,
            'jumlah' => $request->jumlah[$index],
            'harga' => $menu->harga,
            'subtotal' => $subtotal,
        ];
    }
    PenjualanPerBarang::insert($data);

    return redirect('/LaporanTransaksiPenjualan')->with('success', 'Data berhasil diperbarui.');
}


    public function delete($noFaktur)
{
    $transaksi = TransaksiPenjualan::where('no_faktur', $noFaktur)->first();

    // Cek apakah transaksi ditemukan
    if (!$transaksi) {
        return redirect('/LaporanTransaksiPenjualan')->with('error', 'Transaksi tidak ditemukan.');
    }

    // Hapus transaksi dan semua yang terkait
    $transaksi->delete();

    return redirect('/LaporanTransaksiPenjualan')->with('success', 'Data berhasil dihapus.');
}


    public function detail($noFaktur)
    {
        // Mencari transaksi berdasarkan no faktur dan memuat relasi
        $transaksi = TransaksiPenjualan::with('penjualanPerBarang.menu')->where('no_faktur', $noFaktur)->first();
        
        // Cek apakah transaksi ditemukan
        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Mengembalikan detail transaksi sebagai respons JSON
        return response()->json($transaksi);
    }

    public function searchOrPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Query untuk filter berdasarkan tanggal pemesanan
        $query = TransaksiPenjualan::query();
    
        if ($startDate) {
            $query->whereDate('tanggal_pemesanan', '>=', $startDate);
        }
    
        if ($endDate) {
            $query->whereDate('tanggal_pemesanan', '<=', $endDate);
        }
    
        // Ambil data penjualan berdasarkan filter
        $transaksiPenjualan = $query->get();
    
        // Hitung total faktur
        $totalInvoice = $transaksiPenjualan->sum('total_harga');
    
        // Cek apakah ini permintaan untuk PDF atau untuk search
        if ($request->route()->getName() == 'LaporanTransaksiPenjualan.cetakpdf') {
            // Jika untuk PDF, render view ke HTML dan buat PDF
            $html = view('Laporan Transaksi Penjualan.cetakpdf', compact('transaksiPenjualan', 'totalInvoice'))->render();
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
            $mpdf->WriteHTML($html);
            return $mpdf->Output('Laporan Transaksi Penjualan.pdf', 'I'); // Menampilkan PDF di browser
        } else {
            // Jika untuk search, kembali ke view pencarian
            return view('Laporan Transaksi Penjualan.index', compact('transaksiPenjualan', 'totalInvoice'));
        }
    }

    public function generateNoFaktur(Request $request)
{
    $tanggal = $request->tanggal_pemesanan; // nama field dari form

    $tanggalFormat = str_replace('-', '', $tanggal); // jadi format: YYYYMMDD

    // Hitung jumlah faktur di tanggal tersebut
    $count = TransaksiPenjualan::whereDate('tanggal_pemesanan', $tanggal)->count() + 1;

    $noUrut = str_pad($count, 3, '0', STR_PAD_LEFT);
    $noFaktur = 'FJ-' . $tanggalFormat . '-' . $noUrut;

    return response()->json(['no_faktur' => $noFaktur]);
}

}
