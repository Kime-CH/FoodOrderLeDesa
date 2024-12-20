<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Pesanan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Keranjang Pesanan</h1>
        @php
        $currentPath = Request::path(); // Ambil path lengkap
            if (strpos($currentPath, 'pesan/') === 0) {
        // Jika path dimulai dengan 'pesan/'
        $backUrl = '/' . preg_replace('/^pesan\//', '', $currentPath);
        $selectedRoom = ucfirst(preg_replace('/(\d+)/', ' $1', str_replace('pesan/', '', $currentPath)));
    } else {
        // Jika path bukan 'pesan', langsung kembalikan '/'
        $backUrl = '/';
        $selectedRoom = ucfirst(preg_replace('/(\d+)/', ' $1', $currentPath));
    }
    $isRoomMatched = in_array($selectedRoom, [
        'Cottage 1', 'Cottage 2', 'Cottage 3',
        'Joglo Desa', 'Joglo Lasmi', 'Joglo Wayang',
        'Villa', 'Flatroom 4', 'Flatroom 5',
        'Flatroom 6', 'Flatroom 7'
    ]);
@endphp

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('keranjang'))
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Ubah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('keranjang') as $id => $item)
                    @php
                        $menu = $menus->firstWhere('id', $id); // Mencari menu berdasarkan ID
                    @endphp
                        <tr>
                            <td>{{ $item['nama'] }}</td>
                            <td>Rp {{ number_format($item['harga'], 2, ',', '.') }}</td>
                            <td><p class="card-text">{{ $item['jumlah'] }}</p></td>
                            <td>
                                <div class="input-group mp-b">
                            @if($menu)
                                <form action="{{ route('keranjang.tambah', $menu->id) }}" method="POST">
                            @else
                                <p>Menu item not found.</p>
                            @endif
                                @csrf
                                <button type="submit" class="btn btn-primary">+</button>
                            </form>
                            @if($menu)
                                <form action="{{ route('keranjang.kurang', $menu->id) }}" method="POST">
                            @else
                                <p>Menu item not found.</p>
                            @endif
                                @csrf
                                <button type="submit" class="btn btn-primary">-</button>
                            </form>
                            </div>
                                <!--<div class="input-group mb-3">
                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity('{{ $id }}', -1)">-</button>
                                    <input type="text" class="form-control" value="{{ $item['jumlah'] }}" id="quantity-{{ $id }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity('{{ $id }}', 1)">+</button>
                                </div>-->
                            </td>
                            <td>
                                <form action="{{ route('keranjang.hapus', $id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!--Menampilkan Jumlah Pesanan-->
            <div class="mt-4">
            <h4>Total Pesanan: 
                @php
                    $total = 0;
                    if(session('keranjang')) {
                        foreach(session('keranjang') as $item) {
                            $total += $item['harga'] * $item['jumlah'];
                        }
                    }
                @endphp
                Rp {{ number_format($total, 2, ',', '.') }}
            </h4>
        </div>
        <a href="{{ $backUrl }}" class="btn btn-primary">Kembali ke Menu</a>

        <div class="form-group">
            <br>
    <label for="roomSelection">Kamar Anda Adalah :</label>
    <select class="form-control" id="roomSelection" name="roomSelection" {{ $isRoomMatched ? 'disabled' : '' }}>
        <option value="cottage1" {{ $selectedRoom === 'Cottage 1' ? 'selected' : '' }}>Cottage 1</option>
        <option value="cottag2" {{ $selectedRoom === 'Cottage 2' ? 'selected' : '' }}>Cottage 2</option>
        <option value="cottage3" {{ $selectedRoom === 'Cottage 3' ? 'selected' : '' }}>Cottage 3</option>
        <option value="jogloDesa" {{ $selectedRoom === 'Joglo Desa' ? 'selected' : '' }}>Joglo Desa</option>
        <option value="jogloLasmi" {{ $selectedRoom === 'Joglo Lasmi' ? 'selected' : '' }}>Joglo Lasmi</option>
        <option value="jogloWayang" {{ $selectedRoom === 'Joglo Wayang' ? 'selected' : '' }}>Joglo Wayang</option>
        <option value="villa" {{ $selectedRoom === 'Villa' ? 'selected' : '' }}>Villa</option>
        <option value="flatroom4" {{ $selectedRoom === 'Flatroom 4' ? 'selected' : '' }}>Flatroom 4</option>
        <option value="flatroom5" {{ $selectedRoom === 'Flatroom 5' ? 'selected' : '' }}>Flatroom 5</option>
        <option value="flatroom6" {{ $selectedRoom === 'Flatroom 6' ? 'selected' : '' }}>Flatroom 6</option>
        <option value="flatroom7" {{ $selectedRoom === 'Flatroom 7' ? 'selected' : '' }}>Flatroom 7</option>
    </select>
</div>
<button class="btn btn-success"> Lanjutkan Pembayaran</button>
        @else
            <p>Keranjang Anda kosong.</p>
            <a href="{{ $backUrl }}" class="btn btn-primary">Kembali ke Menu</a>
        @endif
    </div>

    <script>
    function updateQuantity(id, change) {
        const quantityInput = document.getElementById(`quantity-${id}`);
        let currentQuantity = parseInt(quantityInput.value);

        // Mengubah jumlah berdasarkan tombol yang ditekan
        if (change === 1) {
            currentQuantity++;
        } else if (change === -1 && currentQuantity > 1) {
            currentQuantity--;
        }

        // Memperbarui nilai input
        quantityInput.value = currentQuantity;

        // Mengirim permintaan untuk memperbarui jumlah di server
        fetch(`/keranjang/update/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ jumlah: currentQuantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Jumlah item berhasil diperbarui!');
            }
        })
        .catch(error => console.error('Error:', error));
    }
    </script>
</body>
</html>