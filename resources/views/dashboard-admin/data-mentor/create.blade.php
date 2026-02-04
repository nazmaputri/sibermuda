@extends('layouts.dashboard-admin')
@section('title', 'Tambah Mentor')
@section('content')
<div>
    <div class="bg-white p-6 rounded-md shadow-lg overflow-auto border border-gray-200">
        <div class="justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Tambah Mentor</h3>
        </div>
        <form action="{{ route('register') }}" method="POST" class="grid grid-col-1 md:grid-cols-2 gap-6">
            @csrf
            <input type="hidden" name="added_by_admin" value="true">
            <!-- Nama Lengkap -->
            <div class="order-1 md:order-none">
                <label for="name" class="block font-medium  text-gray-700 pb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 text-sm text-gray-700 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('name') border-red-500 @enderror" placeholder="Masukkan nama lengkap">
                @error('name')
                    <p class="text-red-500 text-sm mt-1" id="name-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="order-2 md:order-none">
                <label for="email" class="block font-medium text-gray-700 pb-2">Email</label>
                <input type="email" name="email" id="email" class="anti-autofill w-full px-4 py-2 text-sm text-gray-700 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('email') border-red-500 @enderror" placeholder="Masukkan Email" value="{{ old('email') }}" autocomplete="off" {{-- atau coba: autocomplete="new-password" --}} readonly  onfocus="this.removeAttribute('readonly');"
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1" id="email-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor Telepon -->
            <div class="order-3 md:order-none">
                <label for="phone_number" class="block font-medium text-gray-700 pb-2">Nomor Telepon</label>
                <input type="text" name="phone_number" id="phone_number" class="w-full px-4 py-2 text-sm text-gray-700 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('phone_number') border-red-500 @enderror" placeholder="Masukkan nomor telepon">
                @error('phone_number')
                    <p class="text-red-500 text-sm mt-1" id="phone_number-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="relative order-4 md:order-none">
                <label for="password" class="block font-medium text-gray-700 pb-2">Kata Sandi</label>
                
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 pr-10 text-sm text-gray-700 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('password') border-red-500 @enderror"
                        placeholder="Masukkan kata sandi">
                    
                    <!-- Icon Mata -->
                    <div class="absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-500" id="togglePassword">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20" class="h-5 w-5">
                            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                            <path fill-rule="evenodd"
                                d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                @error('password')
                    <p class="text-red-500 text-sm mt-1" id="password-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi Pengalaman -->
            <div class="order-6 md:order-none">
                <label for="experience" class="block font-medium text-gray-700 pb-2">Deskripsi Pengalaman</label>
                <textarea name="experience" id="experience" rows="4" class="w-full px-4 py-2 text-sm text-gray-700 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('experience') border-red-500 @enderror" placeholder="Deskripsikan pengalaman"></textarea>
                @error('experience')
                    <p class="text-red-500 text-sm mt-1" id="experience-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="relative order-5 md:order-none">
                <label for="password_confirmation" class="block font-medium text-gray-700 pb-2">Konfirmasi Kata Sandi</label>
                
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-2 pr-10 text-sm text-gray-700 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('password') border-red-500 @enderror"
                        placeholder="Masukkan konfirmasi kata sandi">
                    
                    <!-- Icon Mata -->
                    <div class="absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-500" id="toggleConfirmPassword">
                        <svg id="eyeConfirmIcon" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20" class="h-5 w-5">
                            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                            <path fill-rule="evenodd"
                                d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1" id="password-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hidden Role -->
            <input type="hidden" name="role" value="mentor">
            <!-- Submit Button -->
            <div class="order-7 col-span-1 md:col-span-2 flex justify-end space-x-4">
                <a href="{{ route('datamentor-admin') }}" class="bg-red-400 text-white font-medium py-2 px-6 rounded-md hover:bg-red-300">Batal</a>
                <button type="submit" class="bg-sky-400 text-white font-medium py-2 px-6 rounded-md hover:bg-sky-300">
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk menghapus class error dan menyembunyikan pesan error validasi (form line 149 to 168)
    document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                removeErrorStyles(input.id);
            });
        });
    });

    function removeErrorStyles(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.classList.remove('border-red-500', 'focus:ring-red-500', 'text-red-500');
            const errorMessage = document.getElementById(inputId + '-error');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }
    }

    // Pengaturan Icon Password
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
@endsection
