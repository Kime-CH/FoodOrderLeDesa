<?php

namespace App\Http\Controllers;

use App\Models\Menu; // Import the Menu model
use App\Models\Order; // Import the Order model
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        // Mengambil data keranjang dari session
        $keranjang = session()->get('keranjang', []);
        
        // Mengambil semua data menu dari database
        $menus = Menu::all(); // Pastikan Anda mengimpor model Menu
        
        // Mengirim data keranjang dan menu ke view
        return view('pesan', compact('keranjang', 'menus'));
    }

    public function tambah($id)
    {
        $menu = Menu::find($id);
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah']++;
        } else {
            $keranjang[$id] = [
                "nama" => $menu->nama,
                "harga" => $menu->harga,
                "jumlah" => 1,
                "gambar" => $menu->gambar,
            ];
        }

        session()->put('keranjang', $keranjang);

        // Flash a success message
        session()->flash('success', 'Makanan berhasil ditambahkan ke keranjang!');

        // Redirect to the current page
        return redirect()->to(url()->previous());
    }

    public function kurang($id)
    {
        $keranjang = session()->get('keranjang', []);

        // Cek jika item ada di keranjang
        if (isset($keranjang[$id])) {
            // Kurangi jumlah jika lebih dari 1
            if ($keranjang[$id]['jumlah'] > 1) {
                $keranjang[$id]['jumlah']--;
            } else {
                // Jika jumlahnya 1, Anda bisa menghapus item dari keranjang
                unset($keranjang[$id]);
            }
        }

        // Simpan kembali keranjang ke session
        session()->put('keranjang', $keranjang);

        // Flash a success message
        session()->flash('success', 'Jumlah makanan berhasil dikurangi!');

        // Redirect to the current page
        return redirect()->to(url()->previous());
    }

    public function update(Request $request, $id)
    {
        $keranjang = session()->get('keranjang', []);
    
        // Memperbarui jumlah item di keranjang
        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] = $request->jumlah; // Update jumlah
        }
    
        // Simpan kembali keranjang ke session
        session()->put('keranjang', $keranjang);
        return response()->json(['success' => true]);
    }

    public function hapus($id)
    {
        // Mengambil data keranjang dari session
        $keranjang = session()->get('keranjang', []);

        // Menghapus item dari keranjang
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
        }

        // Simpan kembali keranjang ke session
        session()->put('keranjang', $keranjang);
        return redirect()->route('pesan')->with('success', 'Item berhasil dihapus dari keranjang!');
    }

}
