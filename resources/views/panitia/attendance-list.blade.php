@extends('layouts.app')

@section('title', 'Daftar Absensi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="attendance-card">
        <h3 class="title">Daftar Absensi Hari Ini</h3>

        <!-- Download Button -->
        <div class="download-container">
            <a href="{{ route('panitia.attendance-list.download-pdf') }}" class="download-btn">
                <svg class="download-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download PDF
            </a>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <div class="search-input-wrapper">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="searchInput" placeholder="Cari berdasarkan nama peserta..." class="search-input">
            </div>
        </div>

        <div id="attendance-list">
            <!-- Loading message removed to prevent continuous display -->
        </div>
    </div>
</div>

<style>
/* Card utama */
.attendance-card {
    background-color: #ffffff;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Judul */
.attendance-card .title {
    text-align: center;
    font-size: 1.75rem;
    font-weight: bold;
    color: #1f2937;
    margin-bottom: 1.5rem;
}

/* Search Bar */
.search-container {
    margin-bottom: 1.5rem;
}

.search-input-wrapper {
    position: relative;
    max-width: 500px;
    margin: 0 auto;
}

.search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    width: 1.25rem;
    height: 1.25rem;
    color: #9ca3af;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    background-color: #f9fafb;
    color: #374151;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: #3b82f6;
    background-color: #ffffff;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.search-input::placeholder {
    color: #9ca3af;
}



/* Tabel */
.attendance-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.attendance-table thead {
    /* Gradasi header merah → hijau */
    background: linear-gradient( #22c55e);
    color: white;
}

.attendance-table th {
    padding: 0.75rem 1rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
}

.attendance-table tbody tr {
    background-color: #ffffff;
    transition: background-color 0.2s;
}

.attendance-table tbody tr:hover {
    background-color: #eff6ff;
}

.attendance-table td {
    padding: 0.75rem 1rem;
    color: #374151;
    vertical-align: middle;
}

/* Foto profil */
.attendance-table img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid #e5e7eb;
}

/* Status hijau untuk Present/Hadir */
.status-present {
    color: #ffffff;
    background-color: #22c55e;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-weight: 600;
    display: inline-block;
    font-size: 0.75rem;
}

/* Download Button */
.download-container {
    margin-bottom: 1.5rem;
    text-align: right;
}

.download-btn {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    background-color: #3b82f6;
    color: #ffffff;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    transition: background-color 0.2s;
}

.download-btn:hover {
    background-color: #2563eb;
}

.download-icon {
    width: 1.25rem;
    height: 1.25rem;
    margin-right: 0.5rem;
}
</style>

<script>
function loadTodayAttendances() {
    fetch('/panitia/attendances/today', {
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            // Store original data for search functionality
            originalData = data.data;
            renderTable(data.data);
        } else {
            document.getElementById('attendance-list').innerHTML = '<p style="text-align:center; color:red;">Gagal memuat data absensi.</p>';
        }
    })
    .catch(error => {
        console.error(error);
        document.getElementById('attendance-list').innerHTML = '<p style="text-align:center; color:red;">Terjadi kesalahan saat memuat data absensi.</p>';
    });
}

let originalData = [];

document.addEventListener('DOMContentLoaded', function() {
    loadTodayAttendances();

    // Search functionality
    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();

        if (searchTerm === '') {
            // Show all data if search is empty
            renderTable(originalData);
        } else {
            // Filter data based on search term (primarily by name)
            const filteredData = originalData.filter(item => {
                const name = item.peserta_name || '';
                return name.toLowerCase().includes(searchTerm);
            });
            renderTable(filteredData);
        }
    });
});

function renderTable(data) {
    let html = '<table class="attendance-table">';
    html += `
        <thead>
            <tr>
                <th>No</th>
                <th>Foto Profil</th>
                <th>Nama Peserta</th>
                <th>Waktu Scan</th>
                <th>Nomor Telepon</th>
                <th>Email</th>
                <th>Asal Gereja</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>`;

            if(data.length > 0){
                data.forEach((a, index) => {
                    let statusHtml = (a.status === 'present' || a.status === 'Present')
                                     ? `<span class="status-present">Hadir</span>`
                                     : a.status;
                    html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td><img src="${a.profile_image}" alt="Profile"></td>
                        <td>${a.peserta_name}</td>
                        <td>${a.scanned_at}</td>
                        <td>${a.phone || '-'}</td>
                        <td>${a.email}</td>
                        <td>${a.church_origin || '-'}</td>
                        <td>${statusHtml}</td>
                    </tr>`;
                });
            } else {
                html += `<tr><td colspan="8" style="text-align:center; padding:1rem; color:#9ca3af;">Tidak ada data yang sesuai dengan pencarian</td></tr>`;
            }

    html += '</tbody></table>';
    document.getElementById('attendance-list').innerHTML = html;
}
</script>
@endsection
