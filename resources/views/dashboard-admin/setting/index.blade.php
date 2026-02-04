@extends('layouts.dashboard-admin')
@section('title', 'Pengaturan Akun')
@section('content')

<div class="max-w-2xl mx-auto border border-gray-200 bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-lg font-semibold text-center text-gray-700 border-b-2 pb-2 mb-4">Pengaturan Akun</h2>
    <form action="{{ url('/settings-admin/update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="photo" class="block font-medium text-gray-700">Foto Profil</label>
            @if($user->photo)
                <img src="{{ Storage::url($user->photo) }}" alt="Foto Profil" class="w-28 h-28 rounded-full mt-2 mx-auto">
            @endif
            <input type="file" name="photo" id="photo" class="p-2 mt-2 text-sm text-gray-700 block w-full border border-gray-200 rounded-md shadow-sm" placeholder="Masukkan foto profil">
            @error('photo')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nama -->
        <div class="mb-3">
            <label for="name" class="block font-medium text-gray-700">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="p-2 mt-1 text-sm text-gray-700 block w-full border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400"  placeholder="Masukkan nama">
            @error('name')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="p-2 mt-1 text-sm text-gray-700 block w-full border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400"  placeholder="Masukkan email">
            @error('email')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- No Telepon -->
        <div class="mb-3">
            <label for="phone_number" class="block font-medium text-gray-700">No Telepon</label>
            <input type="number" name="phone_number" id="phone_number" 
                   value="{{ old('phone_number', $user->phone_number) }}" 
                   class="p-2 mt-1 text-sm text-gray-700 block w-full border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400"  
                   placeholder="Contoh: 6281234567890">
            
            <div class="flex items-center p-3 mb-2 text-sm text-yellow-600 rounded-lg bg-yellow-100 md:mt-3 mt-2" role="alert">
                <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <p class="text-xs text-yellow-800">Gunakan format internasional tanpa angka 0 di awal, misalnya ganti <strong>0812</strong> menjadi <strong>62812</strong> agar bisa diarahkan ke WhatsApp.</p>
            </div>
        
            @error('phone_number')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>             

        <!-- Password lama -->
        <div class="mb-3 relative">
            <label for="password" class="block font-medium text-gray-700">Kata Sandi Lama</label>
            
            <div class="relative">
                <input type="password" name="password" id="old-password"
                    class="password-input p-2 pr-10 mt-1 block w-full text-sm text-gray-700 border-gray-200 border rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
                
                <!-- Icon Mata -->
                <div class="absolute inset-y-0 right-2 flex items-center cursor-pointer toggle-password">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
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

        <!-- Password -->
        <div class="mb-4 relative">
            <label for="password" class="block font-medium text-gray-700">Kata Sandi Baru</label>
            
            <div class="relative">
                <input type="password" name="password" id="new_password"
                    class="p-2 pr-10 mt-1 block w-full text-sm text-gray-700 border-gray-200 border rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400" placeholder="Masukkan kata sandi">
                
                <!-- Icon Mata -->
                <div class="absolute inset-y-0 right-2 flex items-center cursor-pointer" id="toggleNewPassword">
                    <svg id="eyeNewIcon" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
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
       <div class="mb-3 relative">
            <label for="password_confirmation" class="block font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
            
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="p-2 pr-10 mt-1 block w-full text-sm text-gray-700 border-gray-200 border rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400" placeholder="Masukkan konfirmasi kata sandi">
                
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

        <div class="flex justify-end space-x-4 mt-2">
            <!-- Tombol Batal -->
            <a href="{{ route('welcome-admin') }}" class="bg-red-400 text-white font-medium py-2 px-6 rounded-md hover:bg-red-300 mt-2">Batal</a>
            <!-- Tombol Simpan -->
            <button type="submit" class="bg-sky-400 text-white font-medium py-2 px-6 rounded-md hover:bg-sky-300 mt-2">Simpan</button>
        </div>              
    </form>

<script>
    // Ambil semua elemen toggle password dan input password berdasarkan class (untuk password yang baru dengan yang lama)
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    const passwordFields = document.querySelectorAll('.password-input');
    const eyeIcons = document.querySelectorAll('#eye-icon'); // Mengambil ikon berdasarkan ID

    // Definisikan ikon mata untuk status terbuka dan tertutup
    const eyeOpen = `<path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />`;

    const eyeClosed = `<path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
                        <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />`;

    // Iterasi berdasarkan index untuk setiap tombol toggle password
    togglePasswordButtons.forEach((button, i) => {
        button.addEventListener('click', function () {
            const passwordField = passwordFields[i];  // Ambil input password terkait berdasarkan index
            const eyeIcon = eyeIcons[i];  // Ambil ikon mata terkait berdasarkan index

            // Debug untuk melihat tipe password saat ini dan elemen ikon
            console.log(passwordField.type);  
            console.log(eyeIcon);

            // Toggle antara password dan text untuk input
            if (passwordField.type === 'password') {
                passwordField.type = 'text';  // Ubah tipe input menjadi teks
                eyeIcon.innerHTML = eyeClosed;  // Ganti ikon mata menjadi tertutup
            } else {
                passwordField.type = 'password';  // Ubah tipe input menjadi password
                eyeIcon.innerHTML = eyeOpen;  // Ganti ikon mata menjadi terbuka
            }
        });
    });

    // Pengaturan Icon New Password
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('toggleNewPassword');
        const passwordField = document.getElementById('new_password');
        const eyeIcon = document.getElementById('eyeNewIcon');

        const eyeOpen = `<path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />`;

        const eyeClosed = `<path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
                        <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />`;

        let isVisible = false;

        togglePassword.addEventListener('click', function () {
            isVisible = !isVisible;
            passwordField.type = isVisible ? 'text' : 'password';
            eyeIcon.innerHTML = isVisible ? eyeClosed : eyeOpen;
        });
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