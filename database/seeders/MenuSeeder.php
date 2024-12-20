<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua data sebelumnya
        Menu::truncate();

        // Tambahkan data baru
        Menu::create([
            'nama' => 'Nasi Goreng',
            'harga' => 20000,
            'tipe' => 'makanan',
            'deskripsi' => 'Nasi goreng spesial dengan telur dan sayuran.',
            'gambar' => 'https://asset.kompas.com/crops/U6YxhTLF-vrjgM8PN3RYTHlIxfM=/84x60:882x592/1200x800/data/photo/2021/11/17/61949959e07d3.jpg',
        ]);

        Menu::create([
            'nama' => 'Es Teh Manis',
            'harga' => 5000,
            'tipe' => 'minuman',
            'deskripsi' => 'Minuman teh manis yang menyegarkan.',
            'gambar' => 'https://asset.kompas.com/crops/-EW4dZIFD3U055K4qtHqSgUg_hM=/92x67:892x600/1200x800/data/photo/2023/08/23/64e59deb79bfb.jpg',
        ]);

        // Tambahkan menu lainnya sesuai kebutuhan
    }
}