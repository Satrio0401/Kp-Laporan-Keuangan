<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier'; // Pastikan nama tabel benar
    protected $primaryKey = 'kode_supplier'; // Ganti primary key menjadi kode_supplier
    public $incrementing = false; // Pastikan ini false karena kode_supplier bukan auto increment
    protected $fillable = [
        'kode_supplier', // Pastikan kolom ini ada dalam fillable
        'nama',
        'no_hp',
        'email',
        'alamat'
    ];


    // Definisikan relasi jika ada
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'kode_supplier'); // Sesuaikan dengan nama kolom relasi di tabel pembelian
    }
}
