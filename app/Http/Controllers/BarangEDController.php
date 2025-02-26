<?php

namespace App\Http\Controllers;

use App\Models\BarangED;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Carbon\Carbon;

class BarangEDController extends Controller
{
    // Menampilkan semua data barang
    public function index()
    {
        $barangeds = BarangED::orderBy('tanggal_kadaluarsa', 'asc')->get();
    
        foreach ($barangeds as $barang) {
            $tanggalKadaluarsa = Carbon::parse($barang->tanggal_kadaluarsa);
            $hariIni = Carbon::now();
            $selisihHari = $hariIni->diffInDays($tanggalKadaluarsa, false);
    
            if ($selisihHari < 0) {
                $barang->status_warna = 'expired'; // Merah (Sudah kedaluwarsa)
            } elseif ($selisihHari <= 7) {
                $barang->status_warna = 'warning'; // Kuning (H-7 sebelum kedaluwarsa)
            } else {
                $barang->status_warna = ''; // Normal (tidak ada warna khusus)
            }
        }
    
        return view('Laporan Barang ED.index', compact('barangeds'));
    }

    // Menampilkan form untuk menambah data barang
    public function tambahdata()
    {
        return view('Laporan Barang ED.tambahdata');
    }

    // Menyimpan data barang ke database
    public function insertdata(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'lot' => 'nullable|string|max:255', // lot akan diisi otomatis
            'tanggal_kadaluarsa' => 'required|date',
            'jumlah_barang' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        // Menyimpan data barang ke database
        BarangED::create($request->all());

        // Redirect dengan pesan sukses
        return redirect('/LaporanBarangED')->with('success', 'Data Berhasil Ditambahkan');
    }

    // Menampilkan form untuk mengedit data barang
    public function editdata($id)
    {
        $barangeds = BarangED::find($id);
        return view('Laporan Barang ED.editdata', compact('barangeds'));
    }

    // Mengupdate data barang
    public function updatedata(Request $request, $id)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'lot' => 'nullable|string|max:255',
            'tanggal_kadaluarsa' => 'required|date',
            'jumlah_barang' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        $barangeds = BarangED::find($id);
        $barangeds->update($request->all());

        return redirect('/LaporanBarangED')->with('success', 'Data Berhasil Diubah');
    }

    // Menghapus data barang
    public function delete($id)
    {
        $barangeds = BarangED::find($id);
        $barangeds->delete();
        return redirect('/LaporanBarangED')->with('success', 'Data Berhasil Dihapus');
    }

    // // Fungsi untuk pencarian berdasarkan tanggal
    // public function search(Request $request)
    // {
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');

    //     $query = BarangED::query();

    //     if ($startDate) {
    //         $query->whereDate('tanggal_kadaluarsa', '>=', $startDate);
    //     }

    //     if ($endDate) {
    //         $query->whereDate('tanggal_kadaluarsa', '<=', $endDate);
    //     }

    //     $barangeds = $query->get();
    //     $totalPersediaan = $barangeds->sum('jumlah_barang');

    //     return view('Laporan Barang ED.index', compact('barangeds', 'totalPersediaan'));
    // }

    // Fungsi untuk mencetak laporan dalam format PDF
    // public function cetakpdf(Request $request)
    // {
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');

    //     $query = BarangED::query();

    //     if ($startDate) {
    //         $query->whereDate('tanggal_kadaluarsa', '>=', $startDate);
    //     }

    //     if ($endDate) {
    //         $query->whereDate('tanggal_kadaluarsa', '<=', $endDate);
    //     }

    //     $barangeds = $query->get();
    //     $totalPersediaan = $barangeds->sum('jumlah_barang');

    //     $html = view('Laporan Barang ED.cetakpdf', compact('barangeds', 'totalPersediaan'))->render();

    //     $mpdf = new Mpdf(['mode' => 'utf-8']);
    //     $mpdf->WriteHTML($html);
    //     return $mpdf->Output('Laporan Barang ED.pdf', 'I');
    // }

    public function searchOrPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = BarangED::query();

        if ($startDate) {
            $query->whereDate('tanggal_kadaluarsa', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal_kadaluarsa', '<=', $endDate);
        }

        $barangeds = $query->get();

        // Cek apakah ini permintaan untuk PDF atau untuk search
        if ($request->route()->getName() == 'LaporanBarangED.cetakpdf') {
            $html = view('Laporan Barang ED.cetakpdf', compact('barangeds'))->render();
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
            $mpdf->WriteHTML($html);
            return $mpdf->Output('Laporan Barang ED.pdf', 'I');
        } else {
            return view('Laporan Pembelian.index', compact('barangeds'));
        }
    }
}
