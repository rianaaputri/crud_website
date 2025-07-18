<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Penjual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">
<div class="container mt-5">
    <div class="card p-4">
        <h4 class="mb-4">Form Pendaftaran Penjual</h4>

        <form action="{{ route('customer.seller.register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="store_name" class="form-label">Nama Toko</label>
                <input type="text" name="store_name" id="store_name" class="form-control" placeholder = "Nama Toko Anda" required>
            </div>

            <div class="mb-3">
                <label for="store_description" class="form-label">Deskripsi Toko</label>
                <textarea name="store_description" id="store_description" class="form-control" rows="4" required placeholder="Deskripsi Singkat tentang toko yang anda buat"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Aktifkan Sebagai Penjual</button>
            <a href="{{ route('customer.profile') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
</body>
</html>
