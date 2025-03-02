<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BarangED extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'baranged';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'kode_barang',
        'lot',
        'nama_barang',
        'jumlah_barang',
        'tanggal_kadaluarsa',
        'tanggal_masuk',
    ];

    // Menentukan primary key
    protected $primaryKey = 'kode_barang';

    // Menentukan apakah primary key adalah string
    protected $keyType = 'string';

    // Menentukan apakah kolom timestamps diaktifkan
    public $timestamps = true;

    // Menambahkan atribut status_exp agar bisa dipanggil langsung di Blade
    protected $appends = ['status_exp'];

    public function getStatusExpAttribute()
    {
        $today = Carbon::now()->startOfDay(); // Hanya cek berdasarkan tanggal (tanpa jam)
        $tanggalExp = Carbon::parse($this->tanggal_kadaluarsa)->startOfDay(); // Ambil tanggal kadaluarsa
        $hMin7 = $tanggalExp->copy()->subDays(7); // Hitung H-7 sebelum expired

        // Jika hari ini sudah mencapai tanggal kadaluarsa → Expired
        if ($today->equalTo($tanggalExp) || $today->greaterThan($tanggalExp)) {
            return '<span class="badge bg-danger">Expired</span>';
        }
    
        // Jika hari ini berada dalam rentang H-7 hingga sehari sebelum tanggal kadaluarsa → Hampir Expired
        if ($today->greaterThanOrEqualTo($hMin7) && $today->lessThan($tanggalExp)) {
            return '<span class="badge bg-warning">Hampir Expired</span>';
        }
    
        // Jika masih lebih dari H-7 sebelum expired → Aman
        return '<span class="badge bg-success">Aman</span>';
    }
    
    


    

    // Event untuk generate lot otomatis
    public static function boot()
    {
        parent::boot();

        static::creating(function ($barangED) {
            // Ambil tanggal yang dimasukkan oleh pengguna
            $tanggalMasuk = Carbon::parse($barangED->tanggal_masuk)->format('Ymd');

            // Cek jumlah data yang sudah ada untuk tanggal tersebut
            $count = BarangED::where('lot', 'like', 'Batch_' . $tanggalMasuk . '%')->count();

            // Generate kode lot dengan menambahkan urutan angka, mulai dari 001
            $barangED->lot = 'Batch_' . $tanggalMasuk . '_' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        });
    }
}
