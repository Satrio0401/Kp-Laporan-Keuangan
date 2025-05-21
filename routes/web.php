<?php

use Illuminate\Support\Facades\Route;

// Route::get('/Dashboard', function () {
//     return view('Dashboard.index');
// });
//Login
Route::get('/',[\App\Http\Controllers\LoginController::class,'index']);
Route::post('/Loginproses',[\App\Http\Controllers\LoginController::class,'loginproses']);

//Dashboard
Route::get('/Dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/chart-data', [App\Http\Controllers\DashboardController::class, 'getChartData']);
Route::get('/pie-chart-data', [App\Http\Controllers\DashboardController::class, 'getPieChartData']);



// Laporan Pembelian
Route::get('/LaporanPembelian', [\App\Http\Controllers\PembelianController::class, 'index']);

Route::get('/LaporanPembelian/tambahdata', [\App\Http\Controllers\PembelianController::class, 'tambahdata']);
Route::post('/LaporanPembelian/tambahdata/insertdata', [\App\Http\Controllers\PembelianController::class, 'insertdata']);

Route::get('/LaporanPembelian/editdata/{no_faktur}', [\App\Http\Controllers\PembelianController::class, 'editdata']);
Route::post('/LaporanPembelian/updatedata/{no_faktur}', [\App\Http\Controllers\PembelianController::class, 'updatedata']);

Route::get('/LaporanPembelian/delete/{no_faktur}', [\App\Http\Controllers\PembelianController::class, 'delete'])->name('laporanpembelian.delete');

// Route pencarian berdasarkan tanggal
Route::get('/LaporanPembelian/search', [\App\Http\Controllers\PembelianController::class, 'searchOrPdf'])->name('laporanpembelian.search');
Route::get('/LaporanPembelian/PDF', [\App\Http\Controllers\PembelianController::class, 'searchOrPdf'])->name('laporanpembelian.cetakpdf');


//Laporan Pengeluaran
// Laporan Pengeluaran
Route::get('/LaporanPengeluaran', [\App\Http\Controllers\PengeluaranController::class, 'index']);

Route::get('/LaporanPengeluaran/tambahdata', [\App\Http\Controllers\PengeluaranController::class, 'tambahdata']);
Route::post('/LaporanPengeluaran/tambahdata/insertdata', [\App\Http\Controllers\PengeluaranController::class, 'insertdata']);

Route::get('/LaporanPengeluaran/editdata/{kode_biaya}', [\App\Http\Controllers\PengeluaranController::class, 'editdata']);
Route::post('/LaporanPengeluaran/updatedata/{kode_biaya}', [\App\Http\Controllers\PengeluaranController::class, 'updatedata']);

Route::get('/LaporanPengeluaran/delete/{kode_biaya}', [\App\Http\Controllers\PengeluaranController::class, 'delete']);

// Route pencarian berdasarkan tanggal
Route::get('/LaporanPengeluaran/search', [\App\Http\Controllers\PengeluaranController::class, 'searchOrPdf'])->name('LaporanPengeluaran.search');
Route::get('/LaporanPengeluaran/PDF', [\App\Http\Controllers\PengeluaranController::class, 'searchOrPdf'])->name('LaporanPengeluaran.cetakpdf');



//Laporan Transaksi Penjualan
// Laporan Transaksi Penjualan
Route::get('/LaporanTransaksiPenjualan', [\App\Http\Controllers\TransaksipenjualanController::class, 'index']);

Route::get('/LaporanTransaksiPenjualan/tambahdata', [\App\Http\Controllers\TransaksipenjualanController::class, 'tambahdata']);
Route::post('/LaporanTransaksiPenjualan/tambahdata/insertdata', [\App\Http\Controllers\TransaksipenjualanController::class, 'insertdata']);

Route::get('/LaporanTransaksiPenjualan/editdata/{no_faktur}', [\App\Http\Controllers\TransaksipenjualanController::class, 'editdata']);
Route::post('/LaporanTransaksiPenjualan/updatedata/{no_faktur}', [\App\Http\Controllers\TransaksipenjualanController::class, 'updatedata']);

Route::get('/LaporanTransaksiPenjualan/delete/{no_faktur}', [\App\Http\Controllers\TransaksipenjualanController::class, 'delete']);

Route::get('/LaporanTransaksiPenjualan/detail/{no_faktur}', [\App\Http\Controllers\TransaksipenjualanController::class, 'detail'])->name('LaporanTransaksiPenjualan.detail');

// Route pencarian berdasarkan tanggal
Route::get('/LaporanTransaksiPenjualan/search', [\App\Http\Controllers\TransaksipenjualanController::class, 'searchOrPdf'])->name('LaporanTransaksiPenjualan.search');
Route::get('LaporanTransaksiPenjualan/PDF', [\App\Http\Controllers\TransaksipenjualanController::class, 'searchOrPdf'])->name('LaporanTransaksiPenjualan.cetakpdf');
Route::get('/generate-no-faktur', [\App\Http\Controllers\TransaksiPenjualanController::class, 'generateNoFaktur']);



//Laporan Retur Pembelian
Route::get('/LaporanReturPembelian', [\App\Http\Controllers\ReturPembelianController::class, 'index']);

Route::get('/LaporanReturPembelian/tambahdata', [\App\Http\Controllers\ReturPembelianController::class, 'tambahdata']);
Route::post('/LaporanReturPembelian/tambahdata/insertdata', [\App\Http\Controllers\ReturPembelianController::class, 'insertdata']);

Route::get('/LaporanReturPembelian/editdata/{no_faktur}', [\App\Http\Controllers\ReturPembelianController::class, 'editdata']);
Route::post('/LaporanReturPembelian/updatedata/{no_faktur}', [\App\Http\Controllers\ReturPembelianController::class, 'updatedata']);

Route::get('/LaporanReturPembelian/delete/{no_faktur}', [\App\Http\Controllers\ReturPembelianController::class, 'delete']);
Route::post('/LaporanReturPembelian/updateStatus/{no_faktur}', [\App\Http\Controllers\ReturPembelianController::class, 'updateStatus'])->name('LaporanReturPembelian.updateStatus');

Route::get('/LaporanReturPembelian/detail/{no_faktur}', [\App\Http\Controllers\ReturPembelianController::class, 'getDetailPembelian']);


Route::get('/LaporanReturPembelian/search', [\App\Http\Controllers\ReturPembelianController::class, 'searchOrPdf'])->name('LaporanReturPembelian.search');
Route::get('/LaporanReturPembelian/PDF', [\App\Http\Controllers\ReturPembelianController::class, 'searchOrPdf'])->name('LaporanReturPembelian.cetakpdf');





// Route::get('/LaporanReturPembelian/search', [\App\Http\Controllers\ReturPembelianController::class, 'search'])->name('laporanreturpembelian.search');

// Route pencarian berdasarkan tanggal
Route::get('/LaporanReturPembelian/search', [\App\Http\Controllers\ReturPembelianController::class, 'searchOrPdf'])->name('LaporanReturPembelian.search');
Route::get('/LaporanReturPembelian/PDF', [\App\Http\Controllers\ReturPembelianController::class, 'searchOrPdf'])->name('LaporanReturPembelian.cetakpdf');


// Laporan Retur Pemesanan
Route::get('/LaporanReturPemesanan', [\App\Http\Controllers\ReturPenjualanController::class, 'index'])->name('LaporanReturPemesanan.index');

Route::get('/LaporanReturPemesanan/tambahdata', [\App\Http\Controllers\ReturPenjualanController::class, 'tambahdata'])->name('LaporanReturPemesanan.tambahdata');
Route::post('/LaporanReturPemesanan/tambahdata/insertdata', [\App\Http\Controllers\ReturPenjualanController::class, 'insertdata'])->name('LaporanReturPemesanan.insertdata');

Route::get('/LaporanReturPemesanan/editdata/{id}', [\App\Http\Controllers\ReturPenjualanController::class, 'editdata'])->name('LaporanReturPemesanan.editdata');
Route::post('/LaporanReturPemesanan/updatedata/{id}', [\App\Http\Controllers\ReturPenjualanController::class, 'updatedata'])->name('LaporanReturPemesanan.updatedata');

Route::get('/LaporanReturPemesanan/delete/{id}', [\App\Http\Controllers\ReturPenjualanController::class, 'delete'])->name('LaporanReturPemesanan.delete');
// Tambahkan route ini
Route::get('/LaporanReturPemesanan/getMenu/{no_faktur}', [\App\Http\Controllers\ReturPenjualanController::class, 'getMenu'])->name('LaporanReturPemesanan.getMenu');
Route::post('/LaporanReturPemesanan/updateStatus/{id}', [\App\Http\Controllers\ReturPenjualanController::class, 'updateStatus'])->name('LaporanReturPemesanan.updateStatus');


// Route pencarian berdasarkan tanggal
Route::get('/LaporanReturPemesanan/search', [\App\Http\Controllers\ReturPenjualanController::class, 'searchOrPdf'])->name('LaporanReturPemesanan.search');
Route::get('/LaporanReturPemesanan/PDF', [\App\Http\Controllers\ReturPenjualanController::class, 'searchOrPdf'])->name('LaporanReturPemesanan.cetakpdf');



//Laporan Penjualan Per-Barang
Route::get('/LaporanPenjualanPerBarang',[\App\Http\Controllers\PenjualanPerBarangController::class,'index']);

Route::get('/LaporanPenjualanPerBarang/tambahdata',[\App\Http\Controllers\PenjualanPerBarangController::class,'tambahdata']);
Route::post('/LaporanPenjualanPerBarang/tambahdata/insertdata',[\App\Http\Controllers\PenjualanPerBarangController::class,'insertdata']);

Route::get('/LaporanPenjualanPerBarang/editdata/{no_faktur}',[\App\Http\Controllers\PenjualanPerBarangController::class,'editdata']);
Route::post('/LaporanPenjualanPerBarang/updatedata/{no_faktur}',[\App\Http\Controllers\PenjualanPerBarangController::class,'updatedata']);

Route::get('/LaporanPenjualanPerBarang/delete/{id}',[\App\Http\Controllers\PenjualanPerBarangController::class,'delete']);

// Route pencarian berdasarkan tanggal
Route::get('/LaporanPenjualanPerBarang/search', [\App\Http\Controllers\PenjualanPerBarangController::class, 'searchOrPdf'])->name('LaporanPenjualanPerBarang.search');
Route::get('/LaporanPenjualanPerBarang/PDF', [\App\Http\Controllers\PenjualanPerBarangController::class, 'searchOrPdf'])->name('LaporanPenjualanPerBarang.cetakpdf');


// Laporan Stok
Route::get('/LaporanStok', [\App\Http\Controllers\StokController::class, 'index']);

Route::get('/LaporanStok/tambahdata', [\App\Http\Controllers\StokController::class, 'tambahdata']);
Route::post('/LaporanStok/tambahdata/insertdata', [\App\Http\Controllers\StokController::class, 'insertdata']);

Route::get('/LaporanStok/editdata/{kode_barang}', [\App\Http\Controllers\StokController::class, 'editdata']);
Route::post('/LaporanStok/updatedata/{kode_barang}', [\App\Http\Controllers\StokController::class, 'updatedata']);

Route::get('/LaporanStok/delete/{id}', [\App\Http\Controllers\StokController::class, 'delete']);


Route::get('/LaporanStok/delete/{id}',[\App\Http\Controllers\StokController::class,'delete']);

// Route pencarian berdasarkan tanggal
Route::get('/LaporanStok/PDF', [\App\Http\Controllers\StokController::class, 'searchOrPdf'])->name('LaporanStok.cetakpdf');


//Laporan Barang ED
Route::get('/LaporanBarangED',[\App\Http\Controllers\BarangEDController::class,'index']);

Route::get('/LaporanBarangED/tambahdata',[\App\Http\Controllers\BarangEDController::class,'tambahdata']);
Route::post('/LaporanBarangED/tambahdata/insertdata',[\App\Http\Controllers\BarangEDController::class,'insertdata']);

Route::get('/LaporanBarangED/editdata/{id}',[\App\Http\Controllers\BarangEDController::class,'editdata']);
Route::post('/LaporanBarangED/updatedata/{id}',[\App\Http\Controllers\BarangEDController::class,'updatedata']);

Route::get('/LaporanBarangED/delete/{id}',[\App\Http\Controllers\BarangEDController::class,'delete']);

// Route pencarian berdasarkan tanggal
Route::get('/LaporanBarangED/search', [\App\Http\Controllers\BarangEDController::class, 'searchOrPdf'])->name('LaporanBarangED.search');
Route::get('/LaporanBarangED/PDF', [\App\Http\Controllers\BarangEDController::class, 'searchOrPdf'])->name('LaporanBarangED.cetakpdf');


//Supplier
Route::get('/DaftarSupplier',[\App\Http\Controllers\SupplierController::class,'index']);

Route::get('/DaftarSupplier/tambahdata',[\App\Http\Controllers\SupplierController::class,'tambahdata']);
Route::post('/DaftarSupplier/tambahdata/insertdata',[\App\Http\Controllers\SupplierController::class,'insertdata']);

Route::get('/DaftarSupplier/editdata/{kode_supplier}',[\App\Http\Controllers\SupplierController::class,'editdata']);
Route::post('/DaftarSupplier/updatedata/{kode_supplier}',[\App\Http\Controllers\SupplierController::class,'updatedata']);

Route::get('/DaftarSupplier/delete/{kode_supplier}',[\App\Http\Controllers\SupplierController::class,'delete']);

// Route pencarian berdasarkan tanggal
Route::get('/LaporanPengeluaran/search', [\App\Http\Controllers\PengeluaranController::class, 'searchOrPdf'])->name('LaporanPengeluaran.search');
Route::get('/LaporanPengeluaran/PDF', [\App\Http\Controllers\PengeluaranController::class, 'searchOrPdf'])->name('LaporanPengeluaran.cetakpdf');


//Daftar Barang
Route::get('/DaftarMenu',[\App\Http\Controllers\BarangController::class,'index']);

Route::get('/DaftarMenu/tambahdata',[\App\Http\Controllers\BarangController::class,'tambahdata']);
Route::post('/DaftarMenu/tambahdata/insertdata',[\App\Http\Controllers\BarangController::class,'insertdata']);

Route::get('/DaftarMenu/editdata/{id}',[\App\Http\Controllers\BarangController::class,'editdata']);
Route::post('/DaftarMenu/updatedata/{id}',[\App\Http\Controllers\BarangController::class,'updatedata']);

Route::get('/DaftarMenu/delete/{id}',[\App\Http\Controllers\BarangController::class,'delete']);

// Route pencarian berdasarkan tanggal
Route::get('/LaporanPengeluaran/search', [\App\Http\Controllers\PengeluaranController::class, 'searchOrPdf'])->name('LaporanPengeluaran.search');
Route::get('/LaporanPengeluaran/PDF', [\App\Http\Controllers\PengeluaranController::class, 'searchOrPdf'])->name('LaporanPengeluaran.cetakpdf');


// //Daftar Pengguna
// Route::get('/DaftarPengguna',[\App\Http\Controllers\DaftarPenggunaController::class,'index']);

// Route::get('/DaftarPengguna/tambahdata',[\App\Http\Controllers\DaftarPenggunaController::class,'tambahdata']);
// Route::post('/DaftarPengguna/tambahdata/insertdata',[\App\Http\Controllers\DaftarPenggunaController::class,'insertdata']);

// Route::get('/DaftarPengguna/editdata/{id}',[\App\Http\Controllers\DaftarPenggunaController::class,'editdata']);
// Route::post('/DaftarPengguna/updatedata/{id}',[\App\Http\Controllers\DaftarPenggunaController::class,'updatedata']);

// Route::get('/DaftarPengguna/delete/{id}',[\App\Http\Controllers\DaftarPenggunaController::class,'delete']);

