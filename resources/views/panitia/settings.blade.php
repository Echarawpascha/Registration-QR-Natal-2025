@extends('layouts.panitia')

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

        <form method="POST" action="{{ route('panitia.updateSettings') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $panitia->name) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       required>
            </div>

            <div class="mb-4">
                <label for="profile_image" class="block text-gray-700 text-sm font-bold mb-2">Foto Profil:</label>
                <div class="mb-2">
                    <img src="{{ $panitia->profile_image ? asset('storage/' . $panitia->profile_image) : asset('storage/profile_images/profile.png') }}" alt="Current Profile Image"
                         class="w-20 h-20 rounded-full object-cover">
                </div>
                <input type="file" id="profile_image" name="profile_image" accept="image/*"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                @if($panitia->profile_image)
                    <button type="button" onclick="removeProfileImage()" class="mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">
                        Hapus Foto Profil
                    </button>
                @endif
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Perubahan
                </button>
                <a href="{{ route('panitia.dashboard') }}" class="text-gray-600 hover:text-gray-800">Kembali ke Dashboard</a>
            </div>
        </form>
    </div>
</div>

<script>
function removeProfileImage() {
    if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("panitia.removeProfileImage") }}';

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';

        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
