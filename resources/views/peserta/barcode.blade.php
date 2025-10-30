@extends('layouts.app')

@section('title', 'Barcode Peserta')

@section('content')
    <h3>Barcode Anda untuk Absensi:</h3>

    {!! DNS2D::getBarcodeSVG($peserta->barcode, 'QRCODE', 4, 4) !!}

    <p>Kode Barcode: {{ $peserta->barcode }}</p>

    <h3>Status Verifikasi:</h3>
    @if($peserta->is_confirmed)
        <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 20px;">
            <h4>✅ Barcode Sudah Diverifikasi</h4>
            <p>Barcode Anda sudah discan oleh panitia. Anda dapat masuk ke acara.</p>
        </div>
    @else
        <div style="color: orange; padding: 10px; border: 1px solid orange; margin-bottom: 20px;">
            <h4>⏳ Menunggu Verifikasi</h4>
            <p>Barcode Anda belum discan oleh panitia. Tunjukkan barcode ini kepada panitia di pintu masuk.</p>
        </div>
    @endif
@endsection
