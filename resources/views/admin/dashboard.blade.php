@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Selamat datang, {{ $admin->name }}</p>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="section">
        <h2>Panitia Menunggu Persetujuan</h2>
        @if($pendingPanitias->count() > 0)
            @foreach($pendingPanitias as $panitia)
                <div class="panitia-card pending">
                    <h3>{{ $panitia->name }}</h3>
                    <p>Email: {{ $panitia->email }}</p>
                    <p>Telepon: {{ $panitia->phone }}</p>
                    <p>Alamat: {{ $panitia->address }}</p>
                    <p>Status: {{ $panitia->approval_status }}</p>
                    <form method="POST" action="{{ route('admin.approve-panitia', $panitia->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="approve">Setujui</button>
                    </form>
                    <form method="POST" action="{{ route('admin.reject-panitia', $panitia->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="reject">Tolak</button>
                    </form>
                </div>
            @endforeach
        @else
            <p>Tidak ada panitia yang menunggu persetujuan.</p>
        @endif
    </div>

    <div class="section">
        <h2>Panitia yang Sudah Disetujui</h2>
        @if($approvedPanitias->count() > 0)
            @foreach($approvedPanitias as $panitia)
                <div class="panitia-card approved">
                    <h3>{{ $panitia->name }}</h3>
                    <p>Email: {{ $panitia->email }}</p>
                    <p>Telepon: {{ $panitia->phone }}</p>
                    <p>Alamat: {{ $panitia->address }}</p>
                    <p>Status: {{ $panitia->approval_status }}</p>
                </div>
            @endforeach
        @else
            <p>Belum ada panitia yang disetujui.</p>
        @endif
    </div>

    <style>
        .section { margin-bottom: 30px; }
        .panitia-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; }
        .pending { background-color: #fff3cd; }
        .approved { background-color: #d4edda; }
        .rejected { background-color: #f8d7da; }
        button { padding: 5px 10px; margin-right: 5px; cursor: pointer; }
        .approve { background: #28a745; color: white; border: none; }
        .reject { background: #dc3545; color: white; border: none; }
        .success { color: green; }
    </style>
@endsection
