<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Menu Item</title>
</head>
<body>
    <h1>Create Menu Item</h1>
    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">Menu Name:</label>
        <input type="text" name="nama" id="name" required>
        
        <label for="price">Price:</label>
        <input type="number" name="harga" id="price" required>
        
        <label for="description">Description:</label>
        <textarea name="deskripsi" id="description"></textarea>
        
        <label for="tipe">Tipe:</label>
        <select name="tipe" id="tipe" required>
            <option value="makanan">Makanan</option>
            <option value="minuman">Minuman</option>
        </select>
        
        <label for="image">Image:</label>
        <input type="file" name="gambar" id="image" accept="image/*">
        
        <button type="submit">Create Menu Item</button>
    </form>
</body>
</html>
