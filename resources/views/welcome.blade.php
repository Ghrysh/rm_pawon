<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Makan Pawon Kang Bima</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="mobile-container welcome-container">
        
        <div class="logo-container">
            <img src="{{ asset('assets/logo_rm.png') }}" alt="Logo Pawon Kang Bima">
        </div>

        <div class="card">
            <h1>Selamat Datang</h1>
            <p class="subtitle">Silahkan masukan nama anda untuk melakukan pemesanan</p>

            <form action="{{ route('start') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukan Nama Anda" required>
                </div>

                <button type="submit" class="btn-submit">Simpan</button>
            </form>
        </div>

    </div>
</body>
</html>
