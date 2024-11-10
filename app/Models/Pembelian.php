<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian'; 

    // Mengatur no_faktur sebagai primary key
    protected $primaryKey = 'no_faktur'; // Uncomment dan gunakan ini
    public $incrementing = false; // Tidak auto-increment
    protected $keyType = 'string'; // Ubah ke string jika no_faktur adalah string

    // Tambahkan kode_supplier ke dalam $fillable
    protected $fillable = [
        'no_faktur', 
        'tanggal_pembelian', 
        'kode_supplier', // Tambahkan kode_supplier di sini
        'nama_barang', 
        'harga_satuan', 
        'jumlah', 
        'Satuan',
        'total_harga'
    ];

    // Relasi dengan model Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode_supplier');
    }
}
