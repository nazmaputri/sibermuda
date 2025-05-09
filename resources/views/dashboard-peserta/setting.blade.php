@extends('layouts.dashboard-peserta')
@section('title', 'Pengaturan Akun')
@section('content')

<div class="max-w-2xl border border-gray-200 mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="md:text-lg text-center text-md font-semibold text-gray-700 border-b-2 pb-2 mb-4">Pengaturan Akun</h2>
    <form action="{{ url('/update-peserta') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
       <div class="mb-4">
            <label for="photo" class="block text-sm font-medium text-gray-700">Foto Profil</label>
            @if($user->photo)
                <img src="{{ Storage::url($user->photo) }}" alt="Foto Profil" class="w-28 h-28 rounded-full mx-auto">
            @endif
            <input type="file" name="photo" id="photo" class="p-1.5 text-sm mt-2 block w-full border border-gray-200 rounded-md shadow-sm text-gray-700">
            @error('photo')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nama -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="p-1.5 text-sm mt-1 block w-full border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 text-gray-700" required>
            @error('name')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="p-1.5 text-sm mt-1 block w-full border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 text-gray-700" required>
            @error('email')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4 relative">
            <label for="password" class="block font-medium text-gray-700">Masukkan Kata Sandi Baru</label>
            
            <div class="relative">
                <input type="password" name="password" id="password"
                    class="p-1.5 pr-10 mt-1 block w-full text-sm text-gray-700 border-gray-200 border rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
                
                <!-- Icon Mata -->
                <div class="absolute inset-y-0 right-2 flex items-center cursor-pointer" id="togglePassword">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20" class="h-5 w-5 text-gray-500">
                        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                        <path fill-rule="evenodd"
                            d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            @error('password')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

       <!-- Password Confirmation -->
       <div class="mb-4 relative">
            <label for="password_confirmation" class="block font-medium text-gray-700">Masukkan Kata Sandi Baru</label>
            
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="p-1.5 pr-10 mt-1 block w-full text-sm text-gray-700 border-gray-200 border rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
                
                <!-- Icon Mata -->
                <div class="absolute inset-y-0 right-2 flex items-center cursor-pointer" id="toggleConfirmPassword">
                    <svg id="eyeConfirmIcon" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20" class="h-5 w-5 text-gray-500">
                        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                        <path fill-rule="evenodd"
                            d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            @error('password_confirmation')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <!-- Tombol Batal -->
            <a href="{{ route('welcome-peserta') }}" class="bg-red-400 text-white font-medium py-2 px-6 rounded-lg hover:bg-red-300 text-sm">Batal</a>
            <!-- Tombol Simpan -->
            <button type="submit" class="bg-sky-400 text-white font-medium py-2 px-6 rounded-lg hover:bg-sky-300 text-sm">Simpan</button>
        </div>              
    </form>

<script>
    // Pengaturan Icon PAssword
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    const eyeOpen = `<path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />`;
    const eyeClosed = `<path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
                    <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />`;

    togglePassword.addEventListener('click', function() {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.innerHTML = eyeClosed;
        } else {
            passwordField.type = 'password';
            eyeIcon.innerHTML = eyeOpen;
        }
    });
    
    // Pengaturan Icon Konfirmasi Password
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordField = document.getElementById('password_confirmation');
    const eyeConfirmIcon = document.getElementById('eyeConfirmIcon');

    const eyeOpenConfirm = `<path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />`;

    const eyeClosedConfirm = `<path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
                    <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />`;

    toggleConfirmPassword.addEventListener('click', function() {
        if (confirmPasswordField.type === 'password') {
            confirmPasswordField.type = 'text';
            eyeConfirmIcon.innerHTML = eyeClosedConfirm;
        } else {
            confirmPasswordField.type = 'password';
            eyeConfirmIcon.innerHTML = eyeOpenConfirm;
        }
    });
</script>
</div>

@endsection