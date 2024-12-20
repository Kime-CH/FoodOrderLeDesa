<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Makanan dan Minuman</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="container mt-5">
        <h1>Daftar Menu Makanan dan Minuman</h1>
        <div class="row">
            @foreach($menus as $menu)
                <div class="col-md-4">
                    <div class="card mb-4">
<img src="{{ asset('storage/' . $menu->gambar) }}" class="card-img-top" alt="{{ $menu->nama }}" style='max-height: 200px;object-fit: cover;'>
                        <div class="card-body">
                            <h5 class="card-title">{{ $menu->nama }}</h5>
                            <p class="card-text">{{ $menu->deskripsi }}</p>
                            <p class="card-text">Harga: Rp {{ number_format($menu->harga, 2, ',', '.') }}</p>
                            <form action="{{ route('keranjang.tambah', $menu->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Menampilkan Total Pesanan -->
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

        <!-- Move the button here -->
        @php
    $currentPath = request()->path();
    $redirectPath = "/pesan/{$currentPath}";
@endphp
        <div class="mb-3">
        <a href="#" id="cekKeranjang" class="btn btn-warning">Cek Keranjang</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    document.getElementById('cekKeranjang').addEventListener('click', function() {
        window.location.href = '{{ $redirectPath }}';
    });
</script>
</body>
</html>