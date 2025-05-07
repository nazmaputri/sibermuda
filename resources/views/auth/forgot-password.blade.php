<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">

    <div class="max-w-5xl w-full flex bg-white shadow-lg rounded-xl overflow-hidden">
        <!-- Kiri (Form) -->
        <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
            <h2 class="text-3xl font-semibold text-center text-midnight mb-2">Lupa Password</h2>
            <p class="text-center text-gray-600 mb-6">Silakan masukkan email Anda untuk reset password.</p>

            <form action="" method="POST" class="space-y-4">
                @csrf
                <div class="relative">
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder=" " 
                        required
                        class="peer w-full px-4 pt-5 pb-2 text-sm bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-midnight @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}"
                    />
                    <label for="email" class="absolute left-4 top-2 text-gray-500 text-sm transition-all duration-200 
                        peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                        peer-focus:top-2 peer-focus:text-sm peer-focus:text-gray-700">
                        Email
                    </label>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-midnight text-white py-3 rounded-lg hover:bg-opacity-90">Kirim Link Reset</button>
            </form>
        </div>

        <!-- Kanan (Gambar) -->
        <div class="hidden md:block md:w-1/2 bg-gray-100">
            <img src="{{ asset('storage/login2.png') }}" alt="Ilustrasi" class="object-cover h-full w-full">
        </div>
    </div>

</body>
</html>
