@extends('layouts.peserta')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-center mb-6">Pengaturan Akun</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('peserta.updateSettings') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $peserta->name) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       required>
            </div>

            <div class="mb-4">
                <label for="profile_image" class="block text-gray-700 text-sm font-bold mb-2">Foto Profil:</label>
                @if($peserta->profile_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $peserta->profile_image) }}" alt="Current Profile Image"
                             class="w-20 h-20 rounded-full object-cover">
                    </div>
                @endif
                <input type="file" id="profile_image" name="profile_image" accept="image/*"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Perubahan
                </button>
                <a href="{{ route('peserta.dashboard') }}" class="text-gray-600 hover:text-gray-800">Kembali ke Dashboard</a>
            </div>
        </form>
    </div>
</div>
@endsection
