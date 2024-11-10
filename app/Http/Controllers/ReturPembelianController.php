<?php

namespace App\Http\Controllers;

use App\Models\ReturPembelian;
use App\Models\Pembelian; //Pastikan model Pembelian sudah ada
use App\Models\Supplier;
use Illuminate\Http\Request;

class ReturPembelianController extends Controller
{
    public function index()
    {
        // Mengambil semua ReturPembelian dengan data Pembelian terkait
        $returPembelian = ReturPembelian::with('pembelian','supplier')->get();
        return view('Laporan Retur Pembelian.index', compact('returPembelian')); // Pastikan path view benar
    }

    public function tambahdata()
    {
        $pembelian = Pembelian::all(); // Ambil semua data dari tabel pembelian
        return view('Laporan Retur Pembelian.tambahdata', compact('pembelian'));
    }

    public function getDetailPembelian($no_faktur)
{
    // Mengambil data pembelian berdasarkan no_faktur dengan relasi supplier
    $pembelian = Pembelian::with('supplier')
    ->where('no_faktur', $no_faktur)
    ->first(['kode_supplier', 'nama_barang', 'jumlah']);

    if ($pembelian) {
        return response()->json([
            'kode_supplier' => $pembelian->kode_supplier,
            'nama_supplier' => $pembelian->supplier->nama, // Ambil nama_supplier dari relasi
            'nama_barang' => $pembelian->nama_barang,
            'jumlah' => $pembelian->jumlah ?? 0,
        ]);
    }

    return response()->json(null);
}


public function insertdata(Request $request)
{
    // Validasi input dari form
    $request->validate([
        'no_faktur' => 'required|string',
        'tanggal_retur' => 'required|date',
        'jumlah_dikembalikan' => 'required|integer',
        'alasan' => 'required|string',
    ]);

    // Ambil data dari tabel pembelian berdasarkan no_faktur dengan relasi supplier
    $pembelian = Pembelian::with('supplier')->where('no_faktur', $request->no_faktur)->first();

    if (!$pembelian) {
        return redirect()->back()->withErrors(['no_faktur' => 'Nomor faktur tidak ditemukan.']);
    }

    // Mengambil data yang dibutuhkan
    $kode_supplier = $pembelian->kode_supplier; // Ambil kode_supplier
    $nama_supplier = $pembelian->supplier->nama; // Ambil nama_supplier dari relasi
    $nama_barang = $pembelian->nama_barang; // Ambil nama_barang

    // Siapkan data untuk disimpan
    $data = [
        'no_faktur' => $request->no_faktur,
        'tanggal_retur' => $request->tanggal_retur,
        'kode_supplier' => $kode_supplier,
        'nama' => $nama_supplier, // Simpan nama_supplier
        'nama_barang' => $nama_barang,
        'jumlah_dikembalikan' => $request->jumlah_dikembalikan,
        'alasan' => $request->alasan,
        'status' => 'Pending' // Status default
    ];

    // Simpan data baru ke tabel retur_pembelian
    ReturPembelian::create($data);

    // Redirect kembali ke halaman laporan dengan pesan sukses
    return redirect('/LaporanReturPembelian')->with('success', 'Data retur pembelian berhasil ditambahkan!');
}


    public function editdata($no_faktur)
    {
        $returPembelian = ReturPembelian::where('no_faktur', $no_faktur)->first();
        $pembelians = Pembelian::all(); // Ambil semua data dari tabel pembelian
        return view('Laporan Retur Pembelian.editdata', compact('returPembelian', 'pembelians'));
    }

    public function updatedata(Request $request, $no_faktur)
    {
        // Validasi input dari form edit
        $request->validate([
            'tanggal_retur' => 'required|date',
            'jumlah_dikembalikan' => 'required|integer',
            'alasan' => 'required|string',
        ]);

        $returPembelian = ReturPembelian::where('no_faktur', $no_faktur)->first();

        if (!$returPembelian) {
            return redirect()->back()->withErrors(['no_faktur' => 'Data retur tidak ditemukan.']);
        }

        // Update data
        $returPembelian->update($request->only(['tanggal_retur', 'jumlah_dikembalikan', 'alasan']));

        return redirect('/LaporanReturPembelian')->with('success', 'Data retur pembelian berhasil diperbarui!');
    }

    public function delete($no_faktur)
    {
        $returPembelian = ReturPembelian::where('no_faktur', $no_faktur)->first();

        if (!$returPembelian) {
            return redirect('/LaporanReturPembelian')->withErrors(['no_faktur' => 'Data retur tidak ditemukan.']);
        }

        $returPembelian->delete();
        return redirect('/LaporanReturPembelian')->with('success', 'Data retur pembelian berhasil dihapus!');
    }

    public function updateStatus(Request $request, $noFaktur)
    {
        $request->validate([
            'status' => 'required|string|in:diterima,ditolak',
        ]);

        // Cari data ReturPembelian berdasarkan no_faktur
        $returPembelian = ReturPembelian::where('no_faktur', $noFaktur)->first();

        if ($returPembelian) {
            $returPembelian->status = $request->input('status');
            $returPembelian->save();

            return redirect('/LaporanReturPembelian')->with('success', 'Status berhasil diperbarui!');
        } else {
            return redirect('/LaporanReturPembelian')->with('error', 'Data tidak ditemukan.');
        }
    }

    public function getPembelianDetails($no_faktur)
    {
        // Mengambil data pembelian berdasarkan no_faktur
        $pembelian = Pembelian::where('no_faktur', $no_faktur)->first(['kode_supplier as nama_supplier', 'nama_barang']);
        
        // Mengembalikan data dalam format JSON
        return response()->json($pembelian);
    }

    public function searchOrPdf(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Query untuk filter berdasarkan tanggal retur dengan relasi supplier
    $query = ReturPembelian::with('supplier');

    if ($startDate) {
        $query->whereDate('tanggal_retur', '>=', $startDate);
    }

    if ($endDate) {
        $query->whereDate('tanggal_retur', '<=', $endDate);
    }

    // Ambil data retur pembelian berdasarkan filter
    $returPembelian = $query->get();

    // Hitung total jumlah yang dikembalikan
    $totalJumlah = $returPembelian->sum(function($item) {
        return $item->jumlah_dikembalikan * ($item->pembelian->harga_satuan ?? 0);
    });

    // Cek apakah ini permintaan untuk PDF atau untuk search
    if ($request->route()->getName() == 'LaporanReturPembelian.cetakpdf') {
        $html = view('Laporan Retur Pembelian.cetakpdf', compact('returPembelian', 'totalJumlah'))->render();
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $mpdf->WriteHTML($html);
        return $mpdf->Output('Laporan_Retur_Pembelian.pdf', 'I');
    } else {
        return view('Laporan Retur Pembelian.index', compact('returPembelian', 'totalJumlah'));
    }
}




}
