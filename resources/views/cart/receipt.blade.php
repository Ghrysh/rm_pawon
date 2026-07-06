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
        
        <h1 style="text-align: center; font-size: 1.8rem; font-weight: 800; margin-bottom: 0.5rem; color: #fff;">Pesanan Anda</h1>
        @if($order->status == 'menunggu_pembayaran')
        <div id="countdown-timer" style="text-align: center; margin-bottom: 1.5rem;">
            <div style="font-size: 1.1rem; font-weight: 700; color: #ffeb3b;">Batas Waktu Pembayaran</div>
            <div style="font-size: 1.8rem; font-weight: 800; margin: 0.3rem 0; color: #ffeb3b;"><span id="timerDisplay">--:--</span></div>
            <div style="font-size: 0.9rem; font-weight: 600; color: #ffffff;">Segera lakukan pembayaran ke kasir</div>
        </div>
        @elseif($order->status == 'diproses')
        <div style="text-align: center; color: #4caf50; margin-bottom: 1.5rem;">
            <div style="font-size: 1.3rem; font-weight: 800;">Pembayaran Berhasil</div>
            <div style="font-size: 0.95rem; font-weight: 600; margin-top: 0.3rem; color: #ddd;">Pesanan anda sedang di proses</div>
        </div>
        @elseif($order->status == 'selesai')
        <div style="text-align: center; color: #4caf50; margin-bottom: 1.5rem;">
            <div style="font-size: 1.3rem; font-weight: 800;">Pesanan Telah Selesai</div>
            <div style="font-size: 0.95rem; font-weight: 600; margin-top: 0.3rem; color: #ddd;">Terima kasih atas pesanan Anda</div>
        </div>
        @endif

        <div id="receipt-card" style="background: #e5e5e5; border-radius: 12px; padding: 1.5rem; color: #000; box-shadow: 0 10px 25px rgba(0,0,0,0.4);">
            <div style="text-align: center; margin-bottom: 1.5rem; border-bottom: 2px dashed #999; padding-bottom: 1rem;">
                <h2 style="margin: 0; font-size: 1.3rem; font-weight: 800; color: #111;">Pawon Kang Bima</h2>
                <p style="margin: 0.2rem 0 0 0; font-size: 0.8rem; color: #555;">Jl. Raya Ciwidey - Patengan, Patengan,<br>Kec. Ciwidey, Kabupaten Bandung, Jawa Barat 40973</p>
            </div>
            
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
                    <td style="padding-bottom: 0.3rem; text-align: right;">{{ $order->created_at->format('d - M - Y H:i:s') }}</td>
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
                    <td style="padding-bottom: 0.8rem;">
                        <div style="font-size: 0.95rem;">{{ $item->menu->name }}</div>
                        @if($item->catatan)
                        <div style="font-size: 0.75rem; color: #666; margin-top: 0.2rem;">Catatan: {{ $item->catatan }}</div>
                        @endif
                    </td>
                    <td style="padding-bottom: 0.8rem; text-align: right;">
                        <div style="font-size: 0.95rem;">{{ number_format($item->qty * $item->price, 0, ',', '.') }}</div>
                        <div style="font-size: 0.8rem; color: #555; margin-top: 0.2rem;">x{{ $item->qty }}</div>
                    </td>
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

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
            <p style="font-size: 0.8rem; color: #fff; text-align: left; flex: 1; margin: 0;">
                Jika status belum berubah otomatis, mohon untuk refresh halaman.
            </p>
            @if($order->status == 'menunggu_pembayaran')
            <button disabled style="background: #999; color: #ccc; border: none; padding: 0.6rem 1rem; border-radius: 8px; font-weight: 700; cursor: not-allowed; display: flex; align-items: center; gap: 0.5rem; margin-left: 1rem;">
                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                PDF
            </button>
            @else
            <button onclick="downloadPDF()" style="background: #e74c3c; color: #fff; border: none; padding: 0.6rem 1rem; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; margin-left: 1rem;">
                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                PDF
            </button>
            @endif
        </div>

        <form id="resetForm" action="{{ route('receipt.reset') }}" method="POST" style="margin-top: 2rem; text-align: center;">
            @csrf
            <button type="submit" class="btn-oke" style="width: 60%; font-size: 1rem; padding: 0.8rem;">Pesan Lagi</button>
        </form>

    </div>

    <!-- html2pdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        function downloadPDF() {
            const element = document.getElementById('receipt-card');
            
            // Temporary hide box-shadow and radius for the PDF generation so it looks like plain paper
            const originalShadow = element.style.boxShadow;
            const originalRadius = element.style.borderRadius;
            const originalBg = element.style.background;
            
            element.style.boxShadow = 'none';
            element.style.borderRadius = '0';
            element.style.background = '#ffffff';

            // Calculate dynamic height based on the content (1px = 0.264583mm approx)
            // We use Math.max to ensure a minimum height of 250mm, and add 20mm padding for safety
            const elementHeightMm = element.offsetHeight * 0.264583;
            const pdfHeight = Math.max(250, elementHeightMm + 20);

            const opt = {
                margin:       5,
                filename:     'Struk_Pesanan_{{ $order->nama_pl }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { 
                    scale: 2, 
                    useCORS: true, 
                    scrollY: 0, 
                    windowHeight: element.scrollHeight 
                },
                jsPDF:        { unit: 'mm', format: [80, pdfHeight], orientation: 'portrait' }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save().then(() => {
                // Restore styles
                element.style.boxShadow = originalShadow;
                element.style.borderRadius = originalRadius;
                element.style.background = originalBg;
            });
        }

        @if($order->status == 'menunggu_pembayaran')
        // Set order time from PHP using unix timestamp to avoid timezone issues
        const orderTime = {{ $order->created_at->timestamp * 1000 }};
        const maxTime = 40 * 60 * 1000; // 40 minutes in ms

        function updateTimer() {
            const now = new Date().getTime();
            const elapsed = now - orderTime;
            const remaining = maxTime - elapsed;

            if (remaining <= 0) {
                document.getElementById('timerDisplay').innerText = "00:00";
                // Session expired, redirect to reset session and name
                window.location.href = "{{ route('start.reset') }}"; // We need to create this route
                return;
            }

            const minutes = Math.floor((remaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((remaining % (1000 * 60)) / 1000);

            document.getElementById('timerDisplay').innerText = 
                (minutes < 10 ? "0" + minutes : minutes) + ":" + 
                (seconds < 10 ? "0" + seconds : seconds);
        }

        setInterval(updateTimer, 1000);
        updateTimer();
        @endif

        // Auto refresh checking
        let currentStatus = "{{ $order->status }}";
        
        setInterval(() => {
            fetch("{{ route('api.order.status', $order->id) }}")
                .then(response => response.json())
                .then(data => {
                    if (data.status && data.status !== currentStatus) {
                        window.location.reload();
                    }
                })
                .catch(err => console.log('Error checking status:', err));
        }, 5000); // check every 5 seconds
    </script>
</body>
</html>
