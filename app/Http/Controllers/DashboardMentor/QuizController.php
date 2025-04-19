<?php

namespace App\Http\Controllers\DashboardMentor;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Materi; 
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function show($quizId)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($quizId);
        return view('dashboard-peserta.quiz', compact('quiz'));
    }

    public function detail($courseId, $quizId = null)
    {
        $materi = null;
    
        $quiz = Quiz::findOrFail($quizId);
        $course = Course::findOrFail($courseId);
    
        return view('dashboard-mentor.quiz-detail', compact('quiz', 'course', 'courseId', 'materi'));
    }

    public function result($quizId)
    {
        // Ambil data kuis
        $quiz = Quiz::findOrFail($quizId);
        
        // Ambil skor, hasil, dan waktu mulai ujian dari session
        $score = session('score', null);
        $results = session('results', []);
        $startTime = session('start_time', null);
        
        // Ambil course terkait dengan quiz
        $course = $quiz->course;
    
        // Jika data hasil kuis tidak ditemukan di session
        if ($score === null || empty($results) || $startTime === null) {
            return redirect()->route('quiz.show', $quizId)->withErrors('Hasil kuis tidak ditemukan.');
        }
    
        // Simpan hasil kuis ke materi_user untuk riwayat
        $userId = auth()->id();
        $courseId = $course->id;
        \DB::table('materi_user')->updateOrInsert(
            ['user_id' => $userId, 'courses_id' => $courseId, 'quiz_id' => $quizId],
            [
                'nilai' => $score,
                'completed_at' => now(),
                'updated_at' => now(),
            ]
        );
    
        // Menampilkan hasil kuis ke dalam view
        return view('dashboard-peserta.quiz-result', compact('quiz', 'score', 'results', 'startTime', 'course'));
    }    

    public function submit(Request $request, $quizId)
    {
        \Log::info("Submit method called for Quiz ID: {$quizId}");
        \Log::info("Request data: ", $request->all());

        $quiz = Quiz::with('questions.answers')->findOrFail($quizId);
        \Log::info("Quiz loaded: {$quiz->title}");

        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;

        $validatedData = $request->validate([
            'question_*' => 'required|integer|exists:answers,id',
        ]);

        $questionResults = [];
        foreach ($quiz->questions as $question) {
            $submittedAnswerId = $request->input("question_{$question->id}");
            $correctAnswer = $question->answers()->where('is_correct', true)->first();

            $isCorrect = $submittedAnswerId == $correctAnswer->id;
            if ($isCorrect) {
                $correctAnswers++;
            }

            $questionResults[] = [
                'question' => $question->question,
                'submitted_answer' => $question->answers->where('id', $submittedAnswerId)->first()->answer ?? null,
                'correct_answer' => $correctAnswer->answer,
                'is_correct' => $isCorrect,
            ];
        }

        $score = round(($correctAnswers / $totalQuestions) * 100, 2);
        $startTime = session("quiz_start_time.$quizId", now());
        $userId = auth()->id();
        $courseId = $quiz->course_id;

        // Simpan hasil ke tabel materi_user
        \DB::table('materi_user')->insert([
            'user_id' => $userId,
            'courses_id' => $courseId,
            'quiz_id' => $quizId,
            'nilai' => $score,
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('quiz.result', ['quiz' => $quizId])->with([
            'score' => $score,
            'results' => $questionResults,
            'start_time' => $startTime,
        ]);
    }

    public function retake($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);

        // Set ulang waktu mulai kuis di session (optional)
        session(["quiz_start_time.$quizId" => now()]);

        // Redirect ke halaman kuis
        return redirect()->route('quiz.show', $quizId);
    }

    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);

        return view('dashboard-mentor.quiz-create', compact('course', 'courseId'));
    }

    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.answers' => 'required|array|min:4|max:4',
            'questions.*.correct_answer' => 'required|integer|min:0|max:3',
        ], [
            'title.required' => 'Judul kuis harus diisi.',
            'description.required' => 'Deskripsi kuis harus diisi.',
            'duration.required' => 'Durasi harus diisi.',
            'questions.required' => 'Anda harus menambahkan soal.',
            'questions.*.question.required' => 'Soal tidak boleh kosong.',
            'questions.*.answers.required' => 'Jawaban tidak boleh kosong.',
            'questions.*.answers.min' => 'Harus ada 4 jawaban untuk setiap soal.',
            'questions.*.correct_answer.required' => 'Jawaban yang benar harus dipilih.',
        ]);

        try {
            $course = Course::findOrFail($courseId);

            // Cek apakah ini tugas akhir atau kuis biasa
            $quizData = [
                'title' => $request->title,
                'description' => $request->description,
                'course_id' => $course->id,
                'duration' => $request->duration,
            ];

            $quiz = Quiz::create($quizData);

            // Simpan soal dan jawaban
            foreach ($request->questions as $questionData) {
                $question = $quiz->questions()->create([
                    'question' => $questionData['question'],
                ]);

                foreach ($questionData['answers'] as $index => $answerText) {
                    $question->answers()->create([
                        'answer' => $answerText,
                        'is_correct' => $index == $questionData['correct_answer'],
                    ]);
                }
            }

        } catch (\Exception $e) {
            return redirect()->route('courses.show', ['course' => $course->id])->with('success', 'Kuis berhasil diupdate');
        }
    }
    
    public function edit($courseId, $quiz)
    {
        $course = Course::findOrFail($courseId);
        $quiz = Quiz::findOrFail($quiz);

        return view('dashboard-mentor.quiz-edit', compact('quiz', 'course', 'courseId'));
    }

    public function update(Request $request, $courseId, $id)
    {
        // Validasi input dengan pesan kustom
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.answers' => 'required|array|min:4|max:4', // Harus tepat 4 jawaban
            'questions.*.correct_answer' => 'required|integer|min:0|max:3',
        ], [
            'title.required' => 'Judul kuis wajib diisi.',
            'description.required' => 'Deskripsi kuis wajib diisi.',
            'duration.required' => 'Durasi kuis wajib diisi.',
            'questions.required' => 'Harus ada soal yang ditambahkan.',
            'questions.*.question.required' => 'Setiap soal harus diisi.',
            'questions.*.answers.required' => 'Setiap soal harus memiliki 4 jawaban.',
            'questions.*.answers.min' => 'Setiap soal harus memiliki tepat 4 jawaban.',
            'questions.*.answers.max' => 'Setiap soal hanya boleh memiliki 4 jawaban.',
            'questions.*.correct_answer.required' => 'Harus memilih jawaban yang benar.',
            'questions.*.correct_answer.min' => 'Jawaban yang benar harus dipilih dari 4 pilihan.',
            'questions.*.correct_answer.max' => 'Jawaban yang benar harus dipilih dari 4 pilihan.',
        ]);

        try {
            // Validasi course_id dan materi_id
            $course = Course::findOrFail($courseId);

            // Temukan kuis yang ingin diperbarui
            $quiz = Quiz::findOrFail($id);

            // Perbarui data kuis
            $quiz->update([
                'title' => $request->title,
                'description' => $request->description,
                'duration' => $request->duration,
            ]);

            // Ambil ID soal yang disertakan dalam permintaan
            $questionIds = collect($request->questions)->pluck('id')->filter()->toArray();

            // Hapus soal yang tidak ada di permintaan
            $quiz->questions()->whereNotIn('id', $questionIds)->delete();

            // Perbarui soal dan jawaban
            foreach ($request->questions as $index => $questionData) {
                // Jika `id` soal ada, perbarui; jika tidak, buat baru
                $question = isset($questionData['id'])
                    ? $quiz->questions()->findOrFail($questionData['id'])
                    : $quiz->questions()->create(['question' => $questionData['question']]);

                // Perbarui teks soal
                $question->update(['question' => $questionData['question']]);

                // Perbarui jawaban
                foreach ($questionData['answers'] as $answerIndex => $answerText) {
                    // Cari jawaban berdasarkan indeks
                    $answer = $question->answers()->firstOrNew(['index' => $answerIndex]);

                    $answer->fill([
                        'answer' => $answerText,
                        'is_correct' => $answerIndex == $questionData['correct_answer'],
                    ])->save();
                }
            }

        } catch (\Exception $e) {
            return redirect()->route('courses.show', ['course' => $course->id])->with('success', 'Kuis berhasil ditambahkan');
        }
    }

    public function destroy($courseId, $id)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            $quiz->delete();

            // redirect balik ke halaman course setelah sukses hapus
            return redirect()->route('courses.show', ['course' => $courseId])
                            ->with('success', 'Kuis berhasil dihapus');
        } catch (\Exception $e) {
            // kalau gagal, juga arahkan balik (bisa ganti pesan jika perlu)
            return redirect()->route('courses.show', ['course' => $courseId])
                            ->with('error', 'Terjadi kesalahan saat menghapus kuis');
        }
    }
}
