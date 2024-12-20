<?php

namespace App\Http\Controllers;

use App\Models\Order; // Import the Order model
use App\Models\Menu; // Import the Menu model
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        // Retrieve orders from the database
        $orders = Order::all(); // Assuming you have an Order model

        // Retrieve menu items from the database
        $menus = Menu::all(); // Assuming you have a Menu model

        // Send orders and menu data to the view
        return view('admin', compact('orders', 'menus'));
    }

    public function createMenu()
    {
        // Show the form for creating a new menu item
        return view('menu.create'); // Create a new Blade view for the form
    }

    public function storeMenu(Request $request)
    {
        // Log the incoming request data for debugging
        \Log::info('Incoming request data:', $request->all());

        // Validate the request data
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ]);

        // Handle file upload if an image is provided
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('menu_images', 'public');
        } else {
            $imagePath = 'default_image_path.jpg'; // Provide a default image path if no image is uploaded
        }

        // Create a new menu item
        Menu::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
            'gambar' => $imagePath,
        ]);

        // Redirect back to the admin dashboard with a success message
        return redirect()->route('admin')->with('success', 'Menu item created successfully.');
    }

    public function editMenu($id)
    {
        // Retrieve the menu item by ID
        $menu = Menu::findOrFail($id);

        // Show the form for editing the menu item
        return view('menu.edit', compact('menu')); // Create a new Blade view for the edit form
    }

    public function updateMenu(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ]);

        // Retrieve the menu item by ID
        $menu = Menu::findOrFail($id);

        // Handle file upload if an image is provided
        if ($request->hasFile('gambar')) {
            // Delete the old image if it exists
            if ($menu->gambar) {
                Storage::disk('public')->delete($menu->gambar);
            }
            $imagePath = $request->file('gambar')->store('menu_images', 'public');
        } else {
            $imagePath = $menu->gambar; // Keep the old image if no new image is uploaded
        }

        // Update the menu item
        $menu->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar' => $imagePath,
        ]);

        // Redirect back to the admin dashboard with a success message
        return redirect()->route('admin')->with('success', 'Menu item updated successfully.');
    }

    public function destroyMenu($id)
    {
        // Retrieve the menu item by ID
        $menu = Menu::findOrFail($id);

        // Delete the menu item
        $menu->delete();

        // Redirect back to the admin dashboard with a success message
        return redirect()->route('admin')->with('success', 'Menu item deleted successfully.');
    }
}
