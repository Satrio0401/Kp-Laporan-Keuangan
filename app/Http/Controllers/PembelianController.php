<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\ReturPembelian; // Sesuaikan dengan namespace yang benar
use Illuminate\Http\Request;
use DB; 
use Mpdf\Mpdf;
use Carbon\Carbon;

class PembelianController extends Controller
{
    public function index()
    {
        // Ambil semua data pembelian dengan relasi ke supplier
        $pembelian = Pembelian::with('supplier')
        ->orderBy('tanggal_pembelian', 'desc')  // Mengurutkan berdasarkan tanggal pembelian terbaru
        ->get();

        // Hitung total dari kolom total_harga
        $totalInvoice = $pembelian->sum('total_harga');

        // Kirim data ke view, termasuk total yang sudah dihitung
        return view('Laporan Pembelian.index', compact('pembelian', 'totalInvoice'));
    }

    public function tambahdata()
    {
        // Ambil semua data supplier
        $suppliers = Supplier::all(); // Pastikan model Supplier sudah ada
        return view('Laporan Pembelian.tambahdata', compact('suppliers'));
    }
    
    public function insertdata(Request $request)
    {
        $validatedData = $request->validate([
            'no_faktur' => 'required|string|max:50',
            'tanggal_pembelian' => 'required|date',
            'kode_supplier' => 'required|string|max:50', // Validasi kode_supplier
            'nama_barang' => 'required|string|max:100',
            'harga_satuan' => 'required|numeric',
            'jumlah' => 'required|integer',
            'Satuan' => 'required|string|max:20',
            // Total harga akan dihitung otomatis, jadi tidak perlu divalidasi
        ]);

        // Hitung total_harga
        $validatedData['total_harga'] = $request->input('harga_satuan') * $request->input('jumlah');

        // Menambahkan kode_supplier ke data yang akan disimpan
        $validatedData['kode_supplier'] = $request->input('kode_supplier');

        // Simpan data ke database
        Pembelian::create($validatedData);
        return redirect('/LaporanPembelian')->with('success', 'Data Berhasil Ditambah');
    }

    public function editdata($no_faktur)
    {
        $pembelian = Pembelian::with('supplier')->where('no_faktur', $no_faktur)->first();
        $suppliers = Supplier::all();
        return view('Laporan Pembelian.editdata', compact(['pembelian', 'suppliers']));
    }

    public function updatedata(Request $request, $no_faktur)
{
    // Validasi input
    $request->validate([
        'tanggal_pembelian' => 'required|date',
        'kode_supplier' => 'required|string',
        'nama_barang' => 'required|string',
        'harga_satuan' => 'required|numeric',
        'jumlah' => 'required|numeric',
        'total_harga' => 'required|numeric',
        'Satuan' => 'required|string|max:20',
    ]);

    // Cari data pembelian berdasarkan no_faktur
    $pembelian = Pembelian::where('no_faktur', $no_faktur)->first();

    // Pastikan data ditemukan
    if (!$pembelian) {
        return redirect('/LaporanPembelian')->with('error', 'Data tidak ditemukan.');
    }

    // Update data
    $pembelian->update($request->only([
        'tanggal_pembelian', 
        'kode_supplier', 
        'nama_barang', 
        'harga_satuan', 
        'jumlah', 
        'Satuan',
        'total_harga'
    ]));

    return redirect('/LaporanPembelian')->with('success', 'Data Berhasil Diubah');
}


    public function delete($no_faktur)
{
    // Mencari data retur berdasarkan no_faktur
    $returPembelian = ReturPembelian::where('no_faktur', $no_faktur)->first();
    

    if ($returPembelian) {
        return redirect('/LaporanPembelian')->with('error', 'Tidak bisa menghapus data pembelian ini karena sudah ada data retur yang terkait.');
    }

    // Mencari data pembelian berdasarkan no_faktur
    $pembelian = Pembelian::where('no_faktur', $no_faktur)->first();

    if (!$pembelian) {
        return redirect('/LaporanPembelian')->with('error', 'Data Tidak Ditemukan');
    }

    // Hapus data pembelian jika tidak ada retur
    $pembelian->delete();

    return redirect('/LaporanPembelian')->with('success', 'Data Berhasil Dihapus');
}

    public function searchOrPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query untuk filter berdasarkan tanggal dengan relasi supplier
        $query = Pembelian::with('supplier');

        if ($startDate) {
            $query->whereDate('tanggal_pembelian', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal_pembelian', '<=', $endDate);
        }

        // Ambil data pembelian berdasarkan filter
        $pembelian = $query->get();

        // Hitung total harga
        $totalInvoice = $pembelian->sum('total_harga');

        // Cek apakah ini permintaan untuk PDF atau untuk search
        if ($request->route()->getName() == 'laporanpembelian.cetakpdf') {
            $html = view('Laporan Pembelian.cetakpdf', compact('pembelian', 'totalInvoice'))->render();
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
            $mpdf->WriteHTML($html);
            return $mpdf->Output('Laporan_Pembelian.pdf', 'I');
        } else {
            return view('Laporan Pembelian.index', compact('pembelian', 'totalInvoice'));
        }
    } 
}
