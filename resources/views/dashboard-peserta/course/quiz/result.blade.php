@extends('layouts.dashboard-peserta')
@section('title', 'Hasil Kuis')
@section('content')
    <div class="container mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6 border border-gray-200">
            <h1 class="text-xl font-semibold text-gray-700 border-b-2 mb-1 flex justify-between items-center">
                <span>Hasil Kuis : {{ $quiz->title }}</span>
                <div class="px-1 rounded-md">
                    <span class="text-3xl cursor-pointer text-gray-700" onclick="closeQuizResult()">×</span>
                </div>
            </h1>
            <script>
                function closeQuizResult() {
                    // Redirect ke route 'study-peserta' dengan ID course
                    window.location.href = "{{ route('study-peserta', ['slug' => $course->slug]) }}";
                }
            </script>
            <div class="mt-6 flex flex-col lg:flex-row gap-8">
                <div class="lg:w-1/3 md:max-h-[40vh] bg-white shadow-md rounded-lg p-6 sticky top-6 border">
                    <h2 class="text-lg font-semibold text-gray-700 border-b-2 pb-2">Skor Anda</h2>
                
                    <!-- Tanggal Ujian (Paling Atas) -->
                    <p class="text-sm text-gray-700 mt-2">
                        Tanggal Mengerjakan : {{ \Carbon\Carbon::parse($startTime)->translatedFormat('d F Y') }}
                    </p>
                
                    <!-- Menggunakan Flexbox untuk mengatur Total Soal dan Skor agar bersebelahan -->
                    <div class="flex justify-between items-center mt-4 space-x-2 p-4">
                        <!-- Total Soal -->
                        <div class="flex flex-col items-center text-center">
                            <p class="text-lg text-gray-700">Total Soal :</p>
                            <p class="text-2xl font-semibold text-gray-700">{{ count($quiz->questions) }}</p>
                        </div>         
                        
                        <!-- Skor -->
                        <div class="flex flex-col items-center text-center">
                            <p class="text-lg text-gray-700">Skor :</p>
                            <p class="text-2xl font-semibold {{ $score < 70 ? 'text-red-500' : 'text-green-500' }}">
                                {{ $score }}
                            </p>
                        </div>                      
                    </div>                    
                
                    <!-- Status Lulus atau Tidak -->
                    @if ($score >= 75)
                        <p class="text-green-500 text-center text-sm">Selamat, Anda lulus kuis ini!</p>
                    @else
                        <p class="text-red-500 text-center text-sm">Maaf, Anda belum lulus kuis ini.</p>
                    @endif
                </div>                             

                <!-- Detail Jawaban -->
                <div class="lg:w-2/3 md:max-h-[55vh] bg-white shadow-md rounded-lg border p-6 overflow-y-auto scrollbar-hide max-h-[calc(100vh-200px)]">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b-2 pb-2">Detail Jawaban</h2>
                    @foreach ($results as $result)
                        <div class="border-b border-gray-200 py-2">
                            <p class="font-medium text-gray-700">{{ $result['question'] }}</p>
                            <p class="mt-1">
                                <span class="text-sm text-gray-600">Jawaban Anda :</span>
                                <span class="{{ $result['is_correct'] ? 'text-green-500 text-sm' : 'text-red-500 text-sm' }}">
                                    {{ $result['submitted_answer'] ?? 'Tidak dijawab' }}
                                </span>
                            </p>
                            <p class="mt-1">
                                <span class="text-sm text-gray-600">Jawaban Benar :</span>
                                <span class="text-green-500 text-sm">{{ $result['correct_answer'] }}</span>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
