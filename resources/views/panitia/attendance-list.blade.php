@extends('layouts.panitia')

@section('title', 'Daftar Absensi')

@section('content')
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
    </script>
@endsection
