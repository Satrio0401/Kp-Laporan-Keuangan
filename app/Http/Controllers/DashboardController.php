<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\ReturPembelian;
use App\Models\PenjualanPerBarang;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    

    public function getChartData(Request $request)
    {
        $year = $request->input('year', date('Y')); // Tahun default: tahun sekarang
        $currentMonth = date('m'); // Bulan sekarang

        // === Pemasukan dari TransaksiPenjualan ===
        $pemasukan = TransaksiPenjualan::selectRaw('MONTH(tanggal_pemesanan) as bulan, SUM(total_harga) as total')
            ->whereYear('tanggal_pemesanan', $year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // === Pengeluaran dari Pembelian ===
        $pengeluaranPembelian = Pembelian::selectRaw('MONTH(tanggal_pembelian) as bulan, SUM(total_harga) as total')
            ->whereYear('tanggal_pembelian', $year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // === Pengeluaran dari Pengeluaran ===
        $pengeluaranLainnya = Pengeluaran::selectRaw('MONTH(tanggal_pengeluaran) as bulan, SUM(total_pengeluaran) as total')
            ->whereYear('created_at', $year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Gabungkan semua pengeluaran
        $pengeluaran = [];
        for ($i = 1; $i <= 12; $i++) {
            $pengeluaran[$i] = ($pengeluaranPembelian[$i] ?? 0) + ($pengeluaranLainnya[$i] ?? 0);
        }

        // === Buat array lengkap untuk Chart ===
        $dataPemasukan = [];
        $dataPengeluaran = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataPemasukan[] = $pemasukan[$i] ?? 0;
            $dataPengeluaran[] = $pengeluaran[$i] ?? 0;
        }

        // === Total per Tahun & Bulan Ini ===
        $totalPemasukanTahun = array_sum($dataPemasukan);
        $totalPengeluaranTahun = array_sum($dataPengeluaran);
        $totalPemasukanBulan = TransaksiPenjualan::whereYear('tanggal_pemesanan', $year)
        ->whereMonth('tanggal_pemesanan', $currentMonth)
        ->sum('total_harga');
        $pengeluaranPembelianBulanIni = Pembelian::whereYear('tanggal_pembelian', $year)
        ->whereMonth('tanggal_pembelian', $currentMonth)
        ->sum('total_harga');
        $pengeluaranLainnyaBulanIni = Pengeluaran::whereYear('tanggal_pengeluaran', $year)
        ->whereMonth('tanggal_pengeluaran', $currentMonth)
        ->sum('total_pengeluaran');

        $totalPengeluaranBulan = $pengeluaranPembelianBulanIni + $pengeluaranLainnyaBulanIni;


        return response()->json([
            'pemasukan' => $dataPemasukan,
            'pengeluaran' => $dataPengeluaran,
            'totalPemasukanTahun' => $totalPemasukanTahun,
            'totalPengeluaranTahun' => $totalPengeluaranTahun,
            'totalPemasukanBulan' => $totalPemasukanBulan,
            'totalPengeluaranBulan' => $totalPengeluaranBulan
        ]);
    }

    public function index()
{
    $year = date('Y');
    $month = date('m');

    // Ambil 5 menu terlaris bulan ini
    $penjualanPerBarang = DB::table('penjualan_per_barang')
    ->join('menu', 'penjualan_per_barang.id_menu', '=', 'menu.id') // Ganti menu_id → id_menu
    ->join('transaksi_penjualan', 'penjualan_per_barang.no_faktur', '=', 'transaksi_penjualan.no_faktur')
    ->whereYear('transaksi_penjualan.created_at', $year)
    ->whereMonth('transaksi_penjualan.created_at', $month)
    ->select('menu.nama', DB::raw('SUM(penjualan_per_barang.jumlah) as total_terjual'))
    ->groupBy('menu.nama')
    ->orderByDesc('total_terjual')
    ->limit(5)
    ->get();


    return view('Dashboard.index', compact('penjualanPerBarang'));
}


}
