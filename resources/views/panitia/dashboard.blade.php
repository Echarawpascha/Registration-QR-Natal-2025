@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Selamat datang, {{ $panitia->name }}</h1>

    <p>Email: {{ $panitia->email }}</p>
    <p>Telepon: {{ $panitia->phone }}</p>
    <p>Alamat: {{ $panitia->address }}</p>
    <p>Status: {{ $panitia->approval_status }}</p>

    <h3>Barcode Scanner untuk Absensi</h3>

    <div id="reader" style="width: 300px; height: 300px;"></div>
    <button id="startScan">Mulai Scan</button>
    <button id="stopScan" style="display:none;">Stop Scan</button>

    <div id="result" style="margin-top: 20px;"></div>

    <h3>Daftar Absensi Hari Ini</h3>
    <div id="attendance-list" style="margin-top: 20px;">
        <p>Loading...</p>
    </div>

    <script>
        function loadTodayAttendances() {
            fetch('/panitia/attendances/today', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let html = '<table border="1" style="width:100%; border-collapse: collapse;">';
                    html += '<tr><th>Nama Peserta</th><th>Waktu Scan</th><th>Status</th></tr>';

                    if (data.data.length > 0) {
                        data.data.forEach(attendance => {
                            html += `<tr>
                                <td>${attendance.peserta_name}</td>
                                <td>${attendance.scanned_at}</td>
                                <td>${attendance.status}</td>
                            </tr>`;
                        });
                    } else {
                        html += '<tr><td colspan="3" style="text-align:center;">Belum ada absensi hari ini</td></tr>';
                    }

                    html += '</table>';
                    document.getElementById('attendance-list').innerHTML = html;
                }
            })
            .catch(error => {
                console.error('Error loading attendances:', error);
            });
        }

        // Load attendances on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadTodayAttendances();
        });
        let html5QrcodeScanner;

        document.getElementById('startScan').addEventListener('click', function() {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", { fps: 10, qrbox: 250 });

            html5QrcodeScanner.render(onScanSuccess, onScanError);
            this.style.display = 'none';
            document.getElementById('stopScan').style.display = 'inline';
        });

        document.getElementById('stopScan').addEventListener('click', function() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().then(() => {
                    console.log("Scanner stopped");
                }).catch((err) => {
                    console.log("Error stopping scanner", err);
                });
            }
            this.style.display = 'none';
            document.getElementById('startScan').style.display = 'inline';
        });

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);

            // Send barcode to server
            fetch('/panitia/scan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ barcode: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('result').innerHTML = `
                        <div style="color:green;">
                            <h4>✅ Absensi Berhasil!</h4>
                            <p><strong>Peserta:</strong> ${data.data.peserta}</p>
                            <p><strong>Waktu Scan:</strong> ${data.data.scanned_at}</p>
                        </div>
                    `;
                    // Refresh attendance list
                    loadTodayAttendances();
                } else {
                    document.getElementById('result').innerHTML = `
                        <div style="color:red;">
                            <h4>❌ Error:</h4>
                            <p>${data.message}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('result').innerHTML = `
                    <div style="color:red;">
                        <h4>❌ Error:</h4>
                        <p>Terjadi kesalahan saat memproses barcode.</p>
                    </div>
                `;
            });
        }

        function onScanError(errorMessage) {
            console.warn(`Code scan error = ${errorMessage}`);
        }
    </script>

    <h3>Barcode Anda:</h3>
    {!! DNS2D::getBarcodeSVG($panitia->barcode, 'QRCODE', 4, 4) !!}
    <p>Kode Barcode: {{ $panitia->barcode }}</p>
@endsection
