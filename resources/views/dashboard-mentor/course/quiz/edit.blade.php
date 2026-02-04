@extends('layouts.dashboard-mentor')
@section('title', 'Edit Kuis')
@section('content')
<div class="container mx-auto">
    <!-- Card Wrapper -->
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
        <h1 class="text-lg font-semibold text-gray-700 mb-6 text-center border-b-2 pb-2">Edit Kuis</h1>

    <!-- Form Edit Quiz -->
    <form action="{{ route('quiz.update', ['courseId' => $courseId, 'quiz' => $quiz->id]) }}" method="POST">
        @csrf
        @method('PUT')

    <!-- Judul Quiz -->
    <div class="mb-4">
        <label for="title" class="block text-gray-700 font-medium">Judul Kuis</label>
        <input type="text" name="title" id="title" value="{{ old('title', $quiz->title) }}" 
               class="w-full text-gray-700 text-sm  border-gray-300 rounded border focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 p-2
               @error('title') border-red-500 @enderror">
        @error('title') 
            <span class="text-red-500 text-sm error-title">{{ $message }}</span> 
        @enderror
    </div>

    <!-- Deskripsi Quiz -->
    <div class="mb-4">
        <label for="description" class="block text-gray-700 font-medium">Deskripsi</label>
        <textarea name="description" id="description" rows="3" 
                  class="w-full text-gray-700 text-sm border-gray-300 rounded border focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 p-2
                  @error('description') border-red-500 @enderror">{{ old('description', $quiz->description) }}</textarea>
        @error('description') 
            <span class="text-red-500 text-sm error-description">{{ $message }}</span> 
        @enderror
    </div>

    <!-- Durasi Quiz -->
    <div class="mb-4">
        <label for="duration" class="block text-gray-700 font-medium">Durasi (Menit)</label>
        <input type="number" name="duration" id="duration" value="{{ old('duration', $quiz->duration) }}" 
               class="w-full text-gray-700 text-sm border-gray-300 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 p-2
               @error('duration') border-red-500 @enderror">
        @error('duration') 
            <span class="text-red-500 text-sm error-duration">{{ $message }}</span> 
        @enderror
    </div>

    <!-- ini pertanyaan dan jawaban pada soal quiz (SEMANGAT UNTUK FAHAMI KODE BAGIAN INI YAAA!!!!!) -->
    <div class="mb-4">
        <h3 class="font-medium text-gray-700 mb-4">Soal dan Jawaban</h3>

        @php
            $oldQuestions = old('questions');
        @endphp

        @if ($oldQuestions && count($oldQuestions) > 0)
            {{-- Render soal dari old input saat validasi gagal -------------- ini untuk menampilkan pesan spesifik validasi jika gagal memvalidasi --}}
            @foreach ($oldQuestions as $index => $oldQuestion)
                <div class="question-item border p-4 mb-4 rounded bg-white">
                    <div class="mb-3">
                        <span class="font-medium text-gray-700">Soal {{ $index + 1 }}</span>
                    </div>

                    {{-- Input Pertanyaan --}}
                    <div class="mb-3">
                        <label class="block text-gray-700 font-medium mb-2 text-sm">Pertanyaan</label>
                        <input type="text" 
                            name="questions[{{ $index }}][question]" 
                            class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded question-input focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('questions.' . $index . '.question') border-red-500 @enderror" 
                            placeholder="Masukkan teks soal" 
                            value="{{ old("questions.$index.question") }}">
                        @error('questions.' . $index . '.question')
                            <div id="error-questions-{{ $index }}-question" class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Jawaban Pilihan Ganda --}}
                    <div class="answers-container">
                        <label class="block text-gray-700 font-medium text-sm mb-2">Jawaban Pilihan Ganda</label>
                        @php
                            $answers = old("questions.$index.answers", ['','','','']);
                        @endphp
                        @for ($i = 0; $i < 4; $i++)
                            <div class="flex items-center mb-2">
                                <input type="radio" 
                                    name="questions[{{ $index }}][correct_answer]" 
                                    value="{{ $i }}" 
                                    class="mr-2 answer-radio" 
                                    {{ old("questions.$index.correct_answer") !== null && old("questions.$index.correct_answer") == $i ? 'checked' : '' }} 
                                    >
                                <input type="text" 
                                    name="questions[{{ $index }}][answers][{{ $i }}]" 
                                    class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded answer-input focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('questions.' . $index . '.answers.' . $i) border-red-500 @enderror" 
                                    placeholder="Masukkan jawaban" 
                                    value="{{ $answers[$i] ?? '' }}">
                            </div>
                            @error('questions.' . $index . '.answers.' . $i)
                                <div id="error-questions-{{ $index }}-answers-{{ $i }}" class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        @endfor
                        @error('questions.' . $index . '.correct_answer')
                            <p id="error-questions-{{ $index }}-correct-answer" class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Hapus Soal --}}
                    <button type="button" onclick="removeQuestion(this)" class="text-white px-2 py-1 bg-red-400 hover:bg-red-300 text-sm rounded font-medium mt-2">Hapus</button>
                </div>
            @endforeach
        @else
            {{-- Render soal dari database saat load pertama / tidak ada old input  ------------ ini untuk menampilkan pertanyaan yang lama (mengambil dari database) --}}
            @foreach ($quiz->questions as $index => $question)
                <div class="bg-white border border-gray-200 p-3 rounded-md mb-4 question-block">
                    <div class="mb-3">
                        <span class="font-medium text-gray-700">Soal {{ $index + 1 }}</span>
                    </div>
                    {{-- Soal --}}
                    <div class="mb-4">
                        <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">
                        <label for="questions[{{ $index }}][question]" class="block text-gray-700 font-medium">Pertanyaan</label>
                        <input type="text" name="questions[{{ $index }}][question]" id="questions[{{ $index }}][question]" 
                            value="{{ old("questions.$index.question", $question->question) }}" 
                            class="w-full text-gray-700 text-sm border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 p-2
                            @error("questions.$index.question") border-red-500 @enderror">
                        @error("questions.$index.question") 
                            <div class="text-red-500 text-sm">{{ $message }}</div> 
                        @enderror
                    </div>

                    {{-- Jawaban --}}
                    <div class="space-y-3">
                        {{-- Label Jawaban kecil --}}
                        <p class="block sm:hidden text-gray-700 font-medium text-sm mb-2">Jawaban</p>
                        @foreach($question->answers as $answerIndex => $answer)
                            <div class="flex items-center gap-x-2">
                                <input type="hidden" name="questions[{{ $index }}][answers][{{ $answerIndex }}]" value="{{ $answer->id ?? '' }}">
                                <label for="questions[{{ $index }}][answers][{{ $answerIndex }}]" class=" text-gray-700 font-medium text-sm hidden md:block">Jawaban {{ $answerIndex + 1 }}</label>
                                <input type="text" name="questions[{{ $index }}][answers][{{ $answerIndex }}]" 
                                    id="questions[{{ $index }}][answers][{{ $answerIndex }}]" 
                                    value="{{ old("questions.$index.answers.$answerIndex", $answer->answer) }}" 
                                    class="flex-1 text-gray-700 text-sm border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 p-2
                                    @error("questions.$index.answers.$answerIndex") border-red-500 @enderror">

                                {{-- Radio Jawaban Benar --}}
                                <input type="radio" name="questions[{{ $index }}][correct_answer]" value="{{ $answerIndex }}" 
                                {{ old("questions.$index.correct_answer", $question->correct_answer) == $answerIndex ? 'checked' : ($answer->is_correct ? 'checked' : '') }} 
                                class="focus:ring focus:ring-blue-300">
                                <div class="text-sm text-gray-700 text-sm hidden sm:inline">Benar</div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Tombol Hapus Soal --}}
                    <button type="button" class="remove-question text-white px-2 py-1 bg-red-400 hover:bg-red-300 text-sm rounded font-medium mt-2">
                        Hapus
                    </button>
                </div>
            @endforeach
        @endif

        {{-- Soal Template (untuk cloning JS) ----------------- ini adalah template soal dinamis untuk menambah soal --}}
        <template id="question-template">
            <div class="question-item border p-4 mb-4 rounded bg-white">
                <div class="flex space-x-1 mb-2">
                    <p class="font-medium text-gray-700">Soal </p><span class="font-medium text-gray-700 question-number"></span>
                </div>

                {{-- Input Pertanyaan --}}
                <div class="mb-3">
                    <label class="block text-gray-700 font-medium mb-2 text-sm">Pertanyaan</label>
                    <input type="text" name="questions[0][question]" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded question-input focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400" placeholder="Masukkan teks soal">
                </div>

                {{-- Input Jawaban Pilihan Ganda --}}
                <div class="answers-container">
                    <label class="block text-gray-700 font-medium text-sm mb-2">Jawaban Pilihan Ganda</label>
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center mb-2">
                            <input type="radio" name="questions[0][correct_answer]" value="{{ $i }}" class="mr-2 answer-radio">
                            <input type="text" name="questions[0][answers][]" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded answer-input focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400" placeholder="Masukkan jawaban">
                        </div>
                    @endfor
                </div>

                <button type="button" onclick="removeQuestion(this)" class="text-white px-2 py-1 bg-red-400 hover:bg-red-300 text-sm rounded font-medium mt-2">Hapus</button>
            </div>
        </template>

        {{-- Container untuk soal tambahan lewat JS --}}
        <div id="question-list"></div>

        {{-- Tombol Tambah Soal --}}
        <button type="button" onclick="addQuestion()" class="mt-1 bg-green-400 hover:bg-green-300 text-white font-medium py-2 px-4 text-sm rounded">
            Tambah Soal
        </button>
    </div>

    <!-- Tombol aksi -->
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
        const inputs = document.querySelectorAll('input, textarea');

        inputs.forEach(input => {
            input.addEventListener('input', function () {
                // Hapus border merah
                this.classList.remove('border-red-500');

                // Tangani error message setelah input
                const nextElement = this.nextElementSibling;
                if (nextElement && nextElement.classList.contains('text-red-500')) {
                    nextElement.style.display = 'none';
                }

                // Tangani error message dalam bentuk <span> atau <p> (bukan sibling langsung)
                const errorId = this.getAttribute('name')?.replace(/\[/g, '-').replace(/\]/g, '').replace(/\./g, '-') || '';
                const possibleError = document.getElementById('error-' + errorId);
                if (possibleError) {
                    possibleError.style.display = 'none';
                }
            });
        });
    });

    // FUNGSI INI UNTUK MENGITUNG NOMOR SOAL AGAR SESUAI, MENAMBAH SOAL BARU
    let questionCounter = {{ count($quiz->questions) }}; // Mulai dari jumlah soal yang sudah ada

    function addQuestion() {
        const template = document.getElementById('question-template').content.cloneNode(true);
        const questionList = document.getElementById('question-list');
        const newIndex = questionCounter++;

        const questionNumber = template.querySelector('.question-number');
        if (questionNumber) {
            questionNumber.textContent = newIndex + 1;
        }

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

    // FUNGSION UNTUK HAPUS PERTANYAAN JUGA (PANGGIL FUNGSION RENUMBER JUGA DISINI)
    function removeQuestion(element) {
        const questionItem = element.closest('.question-item') || element.closest('.question-block');
        if (questionItem) {
            questionItem.remove();
            renumberQuestions();
        }
    }

    // FUNGSION UNTUK RENUMBER AGAR SESUAI
    function renumberQuestions() {
        const questionItems = document.querySelectorAll('.question-item, .question-block');
        questionItems.forEach((item, index) => {
            // Update label penomoran
            const numberSpan = item.querySelector('.question-number');
            const labelSpan = item.querySelector('span.font-medium.text-gray-700');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            } else if (labelSpan) {
                labelSpan.textContent = `Soal ${index + 1}`;
            }

            // Update semua input name di dalam question
            item.querySelectorAll('input, textarea, select').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\questions\[\d+\]/, `questions[${index}]`);
                }
            });
        });

        // Reset ulang index counter (opsional tergantung dari logic tambah soal)
        questionCounter = questionItems.length;
    }

    // MANIPULASI DOM UNTUK PENGHAPUSAN PERTANYAAN DAN JAWABAN DARI KUIS YANG LAMA
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.remove-question').forEach(function (button) {
            button.addEventListener('click', function () {
                const block = button.closest('.question-block');
                if (block) {
                    block.remove();
                    renumberQuestions();
                }
            });
        });
    });
</script>
@endsection