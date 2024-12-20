<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item</title>
</head>
<body>
    <h1>Edit Menu Item</h1>
    <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label for="nama">Menu Name:</label>
        <input type="text" name="nama" id="nama" value="{{ $menu->nama }}" required>
        
        <label for="harga">Price:</label>
        <input type="number" name="harga" id="harga" value="{{ $menu->harga }}" required>
        
        <label for="deskripsi">Description:</label>
        <textarea name="deskripsi" id="deskripsi">{{ $menu->deskripsi }}</textarea>
        
        <label for="gambar">Image:</label>
        <input type="file" name="gambar" id="gambar" accept="image/*">
        
        <button type="submit">Update Menu Item</button>
    </form>
</body>
</html>
