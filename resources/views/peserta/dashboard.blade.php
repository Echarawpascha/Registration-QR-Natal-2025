@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* === GLOBAL STYLE === */
    body {
        background: linear-gradient(135deg, #0a0f2c, #16234f);
        font-family: 'Poppins', sans-serif;
        color: #fff;
        margin: 0;
        padding: 40px;
        display: flex;
        justify-content: center;
    }

    .dashboard-container {
        max-width: 1200px;
        width: 100%;
    }

    h1, h3, p {
        margin: 0;
    }

    /* === BENTO GRID === */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        grid-template-rows: masonry;
        gap: 20px;
        margin-top: 40px;
    }

    /* === CARD STYLING === */
    .bento-card {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 22px;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .bento-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4);
    }

    /* === ITEM SPAN === */
    .header-card {
        grid-column: span 6;
        text-align: center;
        background: rgba(255, 255, 255, 0.12);
        border-radius: 25px;
        padding: 40px 20px;
    }

    .barcode-card {
        grid-column: span 3;
        grid-row: span 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .barcode-card svg {
        background: #fff;
        padding: 20px;
        border-radius: 15px;
        width: 220px;
        height: 220px;
    }

    .map-card {
        grid-column: span 3;
    }

    .map-card img {
        width: 100%;
        border-radius: 15px;
        object-fit: cover;
        margin-top: 10px;
    }

    .status-card {
        grid-column: span 3;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
    }

    .status-box {
        margin-top: 10px;
        border-radius: 12px;
        padding: 18px;
        font-weight: 500;
    }

    .status-verified {
        color: #00ff8c;
        border: 1px solid #00ff8c;
        background: rgba(0, 255, 140, 0.1);
    }

    .status-pending {
        color: #ffc107;
        border: 1px solid #ffc107;
        background: rgba(255, 193, 7, 0.1);
    }

    .info-card {
        grid-column: span 3;
    }

    .info-card p {
        line-height: 1.6;
    }

    /* === RESPONSIVE === */
    @media (max-width: 992px) {
        .bento-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .header-card {
            grid-column: span 2;
        }
        .barcode-card,
        .map-card,
        .status-card,
        .info-card {
            grid-column: span 2;
        }
        .barcode-card svg {
            width: 180px;
            height: 180px;
        }
    }

    @media (max-width: 600px) {
        body {
            padding: 20px;
        }
        .bento-grid {
            grid-template-columns: 1fr;
        }
        .header-card,
        .barcode-card,
        .map-card,
        .status-card,
        .info-card {
            grid-column: span 1;
        }
    }
</style>

<div class="dashboard-container">
    {{-- Header --}}
    <div class="bento-grid">
        <div class="bento-card header-card">
            <h1>Selamat Datang, {{ $peserta->name }}</h1>
            <p style="opacity: 0.8;">Email: {{ $peserta->email }} | Telepon: {{ $peserta->phone }}</p>
            <p style="opacity: 0.8;">Alamat: {{ $peserta->address }}</p>
        </div>

        {{-- Barcode --}}
        <div class="bento-card barcode-card">
            <h3>🎟 Barcode Anda</h3>
            <div>{!! DNS2D::getBarcodeSVG($peserta->barcode, 'QRCODE', 5, 5) !!}</div>
            <p style="margin-top: 15px;">Kode: <strong>{{ $peserta->barcode }}</strong></p>
        </div>

        {{-- Map --}}
        <div class="bento-card map-card">
            <h3>📍 Lokasi Acara</h3>
            <img src="{{ asset('denah.png') }}" alt="Peta Lokasi">
            <p style="margin-top: 8px;">Gereja Bethel - Lengkong Besar</p>
        </div>

        {{-- Status --}}
        <div class="bento-card status-card">
            <h3>🔐 Status Verifikasi</h3>
            @if($peserta->is_confirmed)
                <div class="status-box status-verified">
                    ✅ Barcode Sudah Diverifikasi<br>
                    Anda dapat masuk ke acara.
                </div>
            @else
                <div class="status-box status-pending">
                    ⏳ Menunggu Verifikasi<br>
                    Tunjukkan barcode ini ke panitia.
                </div>
            @endif
        </div>

        {{-- Info Tambahan --}}
        <div class="bento-card info-card">
            <h3>ℹ️ Informasi Penting</h3>
            <p>
                Pastikan Anda hadir tepat waktu dan membawa tanda pengenal.
                Simpan barcode Anda dengan baik, karena akan digunakan untuk absensi masuk acara.
                Jika mengalami kendala, hubungi panitia melalui meja registrasi.
            </p>
        </div>
    </div>
</div>
@endsection
