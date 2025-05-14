<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Course;
use App\Models\User;

class ChatController extends Controller
{
    public function chatMentor($courseId, $chatId = null)
    {
        $user = auth()->user();
        $course = Course::findOrFail($courseId);
    
        // Ambil chat berdasarkan mentor dan courseId
        $chats = Chat::where('mentor_id', $user->id)
            ->where('course_id', $courseId)
            ->get();
    
        // Ambil daftar student yang telah membeli kursus dengan status pembayaran success
        $students = Purchase::where('status', 'success')
            ->whereHas('course', function ($query) use ($user, $courseId) {
                $query->where('mentor_id', $user->id)
                    ->where('id', $courseId);
            })
            ->with('user')
            ->get()
            ->pluck('user')
            ->unique();
    
        // Hanya ambil chat aktif jika chatId disediakan
        $activeChat = null;
        $messages = [];

        if ($chatId) {
            $activeChat = Chat::where('id', $chatId)
                ->where('mentor_id', $user->id)
                ->where('course_id', $courseId)
                ->first();
        
            if ($activeChat) {
                // Tandai semua pesan sebagai sudah dibaca (is_read = true)
                $activeChat->messages()
                    ->where('is_read', false)
                    ->where('course_id', $courseId)
                    ->update(['is_read' => true]);
        
                // Ambil semua pesan setelah ditandai sudah dibaca
                $messages = $activeChat->messages()
                    ->where('course_id', $courseId)
                    ->with('sender')
                    ->get();
            }
        }        
    
        // Hitung jumlah pesan yang belum dibaca untuk setiap chat
        foreach ($chats as $chat) {
            $chat->unreadMessagesCount = $chat->messages()
                ->where('is_read', false)
                ->count();
        }

        return view('dashboard-mentor.chat', compact('chats', 'messages', 'activeChat', 'students'));
        return view('dashboard-mentor.chat', compact('chats', 'messages', 'activeChat', 'students', 'course'));
    }
      
   public function chatStudent($slug, $chatId = null)
    {
        $user = auth()->user();
        
        // Ambil kursus berdasarkan slug, pastikan kursus yang dibeli dan statusnya sukses
        $course = Purchase::where('user_id', $user->id)
                            ->where('status', 'success')
                            ->whereHas('course', function ($query) use ($slug) {
                                $query->where('slug', $slug);
                            })
                            ->first()?->course;

        // Jika kursus tidak ditemukan, redirect ke halaman courses.index dengan pesan error
        if (!$course) {
            return redirect()->route('courses.index')->with('error', 'You have not enrolled in this course.');
        }
        
        // Ambil mentor dari kursus yang sudah dibeli
        $mentorId = $course->mentor_id;
        
        // Ambil semua chat yang melibatkan student dan mentor
        $chats = Chat::where('student_id', $user->id)
                    ->where('mentor_id', $mentorId)
                    ->where('course_id', $course->id)  // Filter berdasarkan ID kursus yang tepat
                    ->with('mentor')
                    ->get();
        
        // Tentukan chat aktif
        $activeChat = $chatId ? Chat::find($chatId) : $chats->first();
        
        // Jika tidak ada chat, arahkan untuk memulai chat baru
        if (!$activeChat) {
            return redirect()->route('chat.start', $user->id)->with('error', 'No chat found. Please start a new chat.');
        }
        
        // Ambil pesan-pesan yang sesuai dengan chat aktif
        $messages = $activeChat ? $activeChat->messages()
            ->where('course_id', $course->id)  // Pastikan pesan hanya diambil untuk course_id yang benar
            ->with('sender') // Menampilkan informasi pengirim
            ->get() : [];
        
        // Passing data ke view
        return view('dashboard-peserta.chat', compact('chats', 'messages', 'activeChat', 'mentorId', 'course'));
    }

   public function sendMessage(Request $request, $chatId)
    {
        // Validasi input pesan dan pastikan course_id disertakan
        $request->validate([
            'message' => 'required|string|max:1000',
            'course_id' => 'required|exists:courses,id', // Pastikan course_id valid
        ]);

        // Periksa apakah chat dengan ID yang diberikan ada
        $chat = Chat::findOrFail($chatId);

        // Validasi apakah user saat ini adalah bagian dari chat
        if (auth()->id() !== $chat->mentor_id && auth()->id() !== $chat->student_id) {
            abort(403, 'Unauthorized action.');
        }

        // Simpan pesan baru dengan course_id
        $chat->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'course_id' => $request->course_id, // Menyimpan course_id bersama pesan
        ]);

        // Tentukan route berdasarkan peran pengguna
        $roleRoute = auth()->user()->role == 'mentor' ? 'chat.mentor' : 'chat.student';

        // Redirect sesuai role
        if ($roleRoute === 'chat.student') {
            // Ambil slug berdasarkan course_id
            $slug = Course::findOrFail($chat->course_id)->slug;

            return redirect()->route('chat.student', [
                'slug' => $slug,
                'chatId' => $chat->id,
            ])->with([
                'success' => 'Message sent successfully.',
                'disable_swal' => true, // Supaya pesan tidak ditampilkan oleh sweetalert
            ]);
        } else {
            return redirect()->route('chat.mentor', [
                'courseId' => $chat->course_id,
                'chatId' => $chat->id,
            ])->with([
                'success' => 'Message sent successfully.',
                'disable_swal' => true,
            ]);
        }
    }
    
    // public function startChat(Request $request, $studentId, $courseId)
    // {
    //     $mentorId = auth()->id();

    //     // Pastikan course sesuai dengan mentor dan courseId
    //     $course = Course::where('id', $courseId)
    //         ->where('mentor_id', $mentorId)
    //         ->firstOrFail();

    //     $chat = Chat::firstOrCreate([
    //         'mentor_id' => $mentorId,
    //         'student_id' => $studentId,
    //         'course_id' => $course->id,
    //     ]);

    //     return redirect()->route('chat.mentor', [
    //         'courseId' => $course->id,
    //         'chatId' => $chat->id
    //     ]);
    // }

    public function startChat(Request $request, $slug, $studentId = null)
    {
        $authUser = auth()->user();
        
        // Ambil course berdasarkan slug
        $course = Course::where('slug', $slug)->firstOrFail();

        // Jika yang login adalah mentor
        if ($authUser->id === $course->mentor_id) {
            if (!$studentId) {
                abort(400, 'Student ID diperlukan untuk mentor');
            }

            // Buat chat jika belum ada
            $chat = Chat::firstOrCreate([
                'mentor_id' => $authUser->id,
                'student_id' => $studentId,
                'course_id' => $course->id,
            ]);

            // Redirect ke halaman chat mentor
            return redirect()->route('chat.mentor', [
                'slug' => $slug,
                'chatId' => $chat->id,
            ]);
        }

        // Jika yang login adalah student
        $chat = Chat::firstOrCreate([
            'mentor_id' => $course->mentor_id,
            'student_id' => $authUser->id,
            'course_id' => $course->id,
        ]);

        // Redirect ke halaman chat student
        return redirect()->route('chat.student', [
            'slug' => $slug,
            'chatId' => $chat->id,
        ]);
    }

    
}
