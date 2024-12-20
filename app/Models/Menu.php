<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',        // Updated to match migration
        'harga',       // Updated to match migration
        'tipe',        // Updated to match migration
        'deskripsi',   // Updated to match migration
        'gambar',      // Updated to match migration
    ];
}
