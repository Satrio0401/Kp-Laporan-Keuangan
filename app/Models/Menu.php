<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'Menu'; // Tabel yang digunakan oleh model ini

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'nama',
        'harga',
        'kategori',
    ];
}
