<?php

namespace App\Http\Controllers;

use App\Models\PenjualanPerBarang;
use App\Models\Menu;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;

class PenjualanPerBarangController extends Controller
{
    public function index()
    {
        $penjualanPerBarang = PenjualanPerBarang::with(['menu', 'transaksiPenjualan'])->get();
        return view('Laporan Penjualan Per-Barang.index', compact('penjualanPerBarang'));
    }

    public function tambahdata()
    {
        $menu = Menu::all();
        return view('Laporan Penjualan Per-Barang.tambahdata', compact('menu'));
    }

    public function insertdata(Request $request)
    {
        $request->validate([
            'no_faktur' => 'required|string|max:50',
            'nama_pelanggan' => 'required|string|max:100',
            'tanggal_pemesanan' => 'required|date',
            'total_harga' => 'required|numeric',
            'menu_id' => 'required|array',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        $transaksi = TransaksiPenjualan::create([
            'no_faktur' => $request->no_faktur,
            'nama_pelanggan' => $request->nama_pelanggan,
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'total_harga' => $request->total_harga,
        ]);

        $data = [];
        foreach ($request->menu_id as $index => $menuId) {
            $menu = Menu::find($menuId);
            $subtotal = $request->jumlah[$index] * $menu->harga;

            $data[] = [
                'no_faktur' => $request->no_faktur,
                'id_menu' => $menuId,
                'jumlah' => $request->jumlah[$index],
                'harga' => $menu->harga,
                'subtotal' => $subtotal,
            ];
        }

        PenjualanPerBarang::insert($data);
        return redirect('/LaporanPenjualanPerBarang')->with('success', 'Data berhasil ditambahkan.');
    }

    public function editdata($noFaktur)
    {
        $transaksiPenjualan = TransaksiPenjualan::with('penjualanPerBarang.menu')->where('no_faktur', $noFaktur)->first();

        if (!$transaksiPenjualan) {
            return redirect('/LaporanPenjualanPerBarang')->with('error', 'Transaksi tidak ditemukan.');
        }

        $menu = Menu::all();
        return view('Laporan Penjualan Per-Barang.editdata', compact('transaksiPenjualan', 'menu'));
    }

    public function updatedata(Request $request, $noFaktur)
    {
        $transaksiPenjualan = TransaksiPenjualan::where('no_faktur', $noFaktur)->first();

        $request->validate([
            'no_faktur' => 'required|string|max:50',
            'nama_pelanggan' => 'required|string|max:100',
            'tanggal_pemesanan' => 'required|date',
            'total_harga' => 'required|numeric',
            'menu_id' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        $transaksiPenjualan->update($request->only('no_faktur', 'nama_pelanggan', 'tanggal_pemesanan', 'total_harga'));

        PenjualanPerBarang::where('no_faktur', $noFaktur)->delete();

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

        return redirect('/LaporanPenjualanPerBarang')->with('success', 'Data berhasil diperbarui.');
    }

    public function searchOrPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = PenjualanPerBarang::query()
            ->join('transaksi_penjualan', 'transaksi_penjualan.no_faktur', '=', 'penjualan_per_barang.no_faktur')
            ->select('penjualan_per_barang.*', 'transaksi_penjualan.tanggal_pemesanan');

        if ($startDate) {
            $query->whereDate('transaksi_penjualan.tanggal_pemesanan', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaksi_penjualan.tanggal_pemesanan', '<=', $endDate);
        }

        $penjualanPerBarang = $query->get();
        $totalAmountPaid = $penjualanPerBarang->sum('subtotal');

        if ($request->route()->getName() == 'LaporanPenjualanPerBarang.cetakpdf') {
            $html = view('Laporan Penjualan Per-Barang.cetakpdf', compact('penjualanPerBarang','totalAmountPaid'))->render();
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
            $mpdf->WriteHTML($html);
            return $mpdf->Output('Laporan_Penjualan.pdf', 'I');
        } else {
            return view('Laporan Penjualan Per-Barang.index', compact('penjualanPerBarang','totalAmountPaid'));
        }
    }
}
