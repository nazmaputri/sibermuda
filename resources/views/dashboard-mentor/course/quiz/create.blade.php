@extends('layouts.dashboard-mentor')
@section('title', 'Tambah Kuis')
@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <!-- Judul Halaman -->
        <h2 class="text-lg font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Tambah Kuis</h2>

        <!-- Form Tambah Kuis -->
        <form action="{{ route('quiz.store', ['courseId' => $courseId]) }}" method="POST" class="space-y-3">    
            @csrf
            <!-- Input untuk Judul Kuis -->
            <div>
                <label for="title" class="block text-gray-700 font-medium mb-1">Judul Kuis</label>
                <input type="text" name="title" id="title" class="w-full p-2 border text-sm rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 text-gray-700 @error('title') border-red-500 @enderror" placeholder="Masukkan judul kuis" value="{{ old('title') }}">
                @error('title')
                    <div class="text-red-500 text-sm mt-1 error-message" id="error-title">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input untuk Deskripsi Kuis -->
            <div>
                <label for="description" class="block text-gray-700 font-medium mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="5" class="w-full p-2 text-sm border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 text-gray-700 @error('description') border-red-500 @enderror" placeholder="Masukkan deskripsi kuis">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-red-500 text-sm mt-1 error-message" id="error-description">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input untuk Waktu Pengerjaan Kuis -->
            <div>
                <label for="duration" class="block text-gray-700 font-medium mb-1">Durasi</label>
                <input type="number" name="duration" id="duration" class="w-full p-2 text-sm border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 text-gray-700 @error('duration') border-red-500 @enderror" placeholder="Masukkan durasi kuis (menit)" value="{{ old('duration') }}" min="1">
                @error('duration')
                    <div class="text-red-500 text-sm mt-1 error-message" id="error-duration">{{ $message }}</div>
                @enderror
            </div>

            <!-- Daftar Soal Dinamis (KONTAINER UTAMA INPUTAN DATA) -->
            <div id="questions-container">
                <h3 class="text-md font-medium mb-1 text-gray-700">Soal dan Jawaban</h3>

                @php
                    use Illuminate\Support\Str;

                    function getQuestionError($errors, $fieldPattern) {
                        foreach ($errors->keys() as $key) {
                            if (Str::is($fieldPattern, $key)) {
                                return $errors->first($key);
                            }
                        }
                        return null;
                    }
                @endphp

            <!-- Container untuk Soal-soal (FUNGSI NYA UNTUK MENAMPILKAN SOAL SOAL OLD YANG GAGAL SAAT VALIDASI) -->
            <div id="question-list">
                @error('questions')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror

                @foreach (old('questions', []) as $index => $q)
                    <div class="question-item border p-4 mb-4 rounded bg-white">
                        <!-- Menampilkan Nomor Soal -->
                        <div class="mb-3">
                            <span class="text-md text-gray-700 font-medium">Soal {{ $index + 1 }}</span>
                        </div>

                        <!-- Input Pertanyaan -->
                        <div class="mb-3">
                            <label class="block text-gray-700 font-medium mb-2">Soal</label>
                            <input id="question-{{ $index }}"  type="text" name="questions[{{ $index }}][question]" class="w-full p-2 text-sm border rounded question-input focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 text-gray-700 @error("questions.$index.question") border-red-500 @enderror" placeholder="Masukkan teks soal" value="{{ old("questions.$index.question") }}" >
                            @php
                                $errorMsg = getQuestionError($errors, "questions.$index.question");
                            @endphp
                            @if ($errorMsg)
                                <div id="error-question-{{ $index }}" class="text-red-500 text-sm mt-1">{{ $errorMsg }}</div>
                            @endif
                        </div>

                        <!-- Input Jawaban -->
                        <div class="answers-container">
                            <label class="block text-gray-700 font-medium mb-2">Jawaban Pilihan Ganda</label>
                            @for ($i = 0; $i < 4; $i++)
                                <div class="flex items-center space-y-2">
                                    <input type="radio" name="questions[{{ $index }}][correct_answer]" value="{{ $i }}" class="mr-2 answer-radio"
                                        {{ old('questions.0.correct_answer') !== null && old('questions.0.correct_answer') == $i ? 'checked' : '' }}>
                                    <input id="answer-{{ $index }}-{{ $i }}" type="text" name="questions[{{ $index }}][answers][]" class="w-full text-sm text-gray-700 p-2 border focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 rounded answer-input @error("questions.$index.answers.$i") border-red-500 @enderror" placeholder="Masukkan jawaban" value="{{ old("questions.$index.answers.$i") }}">
                                </div>
                                @php
                                    $ansError = getQuestionError($errors, "questions.$index.answers.$i");
                                @endphp
                                @if ($ansError)
                                    <div id="error-answer-{{ $index }}-{{ $i }}" class="text-red-500 text-sm mt-1">{{ $ansError }}</div>
                                @endif
                            @endfor

                            @php
                                $correctError = getQuestionError($errors, "questions.$index.correct_answer");
                            @endphp
                            @if ($correctError)
                                <p class="text-red-500 text-sm mt-1">{{ $correctError }}</p>
                            @endif
                        </div>

                        <!-- Tombol Hapus Soal -->
                        <button type="button" onclick="removeQuestion(this)" class="text-white px-2 py-1 bg-red-400 hover:bg-red-300 text-sm rounded font-medium mt-2">Hapus</button>
                    </div>
                @endforeach
            </div>

            <!-- INI TEMPLATE PERTANYAAN (INPUT) UNTUK DIKIRIM KE BACKEND (kalau kontainer yg atas a.k.a class question-list hanya untuk menampilkan pesan error validasi supaya lebih spesifik) -->
            <template id="question-template">
                <div class="question-item border p-4 mb-4 rounded bg-white">
                    <div class="mb-3">
                        <span class="text-md text-gray-700 font-medium">Soal <span class="question-number"></span></span>
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-700 font-medium mb-2">Pertanyaan</label>
                        <input type="text" name="questions[0][question]" class="w-full p-2 text-sm border rounded question-input focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 text-gray-700" placeholder="Masukkan teks soal">
                    </div>

                    <div class="answers-container">
                        <label class="block text-gray-700 font-medium mb-2">Jawaban Pilihan Ganda</label>
                        @for ($i = 0; $i < 4; $i++)
                            <div class="flex items-center space-y-2">
                                <input type="radio" name="questions[0][correct_answer]" value="{{ $i }}" class="mr-2 answer-radio">
                                <input type="text" name="questions[0][answers][]" class="w-full text-sm text-gray-700 p-2 border focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 rounded answer-input" placeholder="Masukkan jawaban">
                            </div>
                        @endfor
                    </div>

                    <button type="button" onclick="removeQuestion(this)" class="text-white px-2 py-1 bg-red-400 hover:bg-red-300 text-sm rounded font-medium mt-2">Hapus</button>
                </div>
            </template>

            <!-- Container untuk Soal-soal (TERUTAMA JIKA VALIDASI GAGAL, AKAN DITAMPILKAN SOAL OLD NYA) -->
            <div id="question-list"></div>

            <!-- Tombol Tambah Soal -->
            <button type="button" onclick="addQuestion()" class="mt-1 bg-green-400 hover:bg-green-300 text-white font-medium py-2 px-4 text-sm rounded">
                Tambah Soal
            </button>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('courses.show', ['course' => $course->slug]) }}" class="bg-red-400 hover:bg-red-300 text-white font-medium py-2 px-4 rounded-md">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-medium py-2 px-4 rounded-md">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    // Fungsi untuk menghapus pesan error dan border merah saat pengguna mulai mengetik
    document.addEventListener('DOMContentLoaded', function () {
        // Mengambil semua input dan textarea yang memiliki error
        const inputs = document.querySelectorAll('input, textarea');
        
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                // Hapus border merah dan pesan error ketika pengguna mulai mengetik
                if (this.classList.contains('border-red-500')) {
                    this.classList.remove('border-red-500');
                }
                const errorMessage = document.querySelector(`#error-${this.id}`);
                if (errorMessage) {
                    errorMessage.remove();
                }
            });
        });
    });

    // FUNGSI INI UNTUK MENGITUNG NOMOR SOAL AGAR SESUAI, MENAMBAH SOAL BARU
    let questionCounter = 0;

    function addQuestion() {
        const template = document.getElementById('question-template').content.cloneNode(true);
        const questionList = document.getElementById('question-list');
        const newIndex = questionCounter++;

        template.querySelector('.question-number').textContent = newIndex + 1;

        template.querySelectorAll('.question-input, .answer-input, .answer-radio').forEach(el => {
            if (el.classList.contains('question-input')) {
                el.name = `questions[${newIndex}][question]`;
            } else if (el.classList.contains('answer-radio')) {
                el.name = `questions[${newIndex}][correct_answer]`;
            } else {
                el.name = `questions[${newIndex}][answers][]`;
            }
        });

        questionList.appendChild(template);
    }

    function removeQuestion(element) {
        element.closest('.question-item').remove();
    }

    // Inisialisasi questionCounter sesuai jumlah soal yang sudah ada (misal dari old())
    document.addEventListener('DOMContentLoaded', function () {
        const existingQuestions = document.querySelectorAll('#question-list .question-item').length;
        questionCounter = existingQuestions;
    });
</script>
@endsection
