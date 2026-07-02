<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Anda - Rumah Makan Pawon Kang Bima</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="mobile-container" style="padding: 3rem 1.5rem 2rem 1.5rem; justify-content: center; min-height: 100vh;">
        
        <h1 style="text-align: center; font-size: 1.8rem; font-weight: 800; margin-bottom: 2rem; color: #fff;">Pesanan Anda</h1>

        <div style="background: #e5e5e5; border-radius: 12px; padding: 1.5rem; color: #000; box-shadow: 0 10px 25px rgba(0,0,0,0.4);">
            <table style="width: 100%; font-size: 0.85rem; font-weight: 700; margin-bottom: 1rem;">
                <tr>
                    <td style="padding-bottom: 0.3rem;">Nama</td>
                    <td style="padding-bottom: 0.3rem; text-align: right;">{{ $order->nama_pl }}</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 0.3rem;">Meja</td>
                    <td style="padding-bottom: 0.3rem; text-align: right;">{{ $order->no_meja }}</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 0.3rem;">Waktu Pesan</td>
                    <td style="padding-bottom: 0.3rem; text-align: right;">{{ $order->created_at->format('d - M - Y H:i') }}</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 0.3rem;">Status</td>
                    <td style="padding-bottom: 0.3rem; text-align: right; color: #777;">
                        {{ $order->status == 'menunggu_pembayaran' ? 'Menunggu Pembayaran' : ($order->status == 'diproses' ? 'Di Proses' : 'Selesai') }}
                    </td>
                </tr>
            </table>

            <table style="width: 100%; font-size: 0.85rem; font-weight: 700; margin-bottom: 1.5rem;">
                @php 
                    $totalQty = 0;
                @endphp
                @foreach($order->items as $item)
                @php 
                    $totalQty += $item->qty;
                @endphp
                <tr>
                    <td style="padding-bottom: 0.3rem;">{{ $item->qty }} {{ $item->menu->name }}</td>
                    <td style="padding-bottom: 0.3rem; text-align: right;">{{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </table>

            <hr style="border: none; border-top: 1px dashed #999; margin: 1rem 0;">

            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-weight: 700; font-size: 0.85rem;">
                <span>Sub Total</span>
                <span>( {{ $totalQty }} Item )</span>
            </div>

            <hr style="border: none; border-top: 1px dashed #999; margin: 0.5rem 0 1rem 0;">

            <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; font-weight: 800; font-size: 0.95rem;">
                <span>TOTAL</span>
                <span>{{ number_format($order->total_harga, 0, ',', '.') }}</span>
            </div>

            <div style="text-align: center; font-weight: 800; font-size: 1.1rem; color: #000;">
                - Terima Kasih -
            </div>
        </div>

        <form action="{{ route('receipt.reset') }}" method="POST" style="margin-top: 3rem; text-align: center;">
            @csrf
            <button type="submit" class="btn-oke" style="width: 60%; font-size: 1rem; padding: 0.8rem;">Pesan Lagi</button>
        </form>

    </div>
</body>
</html>
