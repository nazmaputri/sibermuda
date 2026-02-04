<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\RatingKursus;
use App\Mail\HelloMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DataMentorController extends Controller
{
    /**
     * Menampilkan daftar mentor
     */
    public function index(Request $request)
    {
        $query = $request->input('search');

        $users = User::where('role', 'mentor')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('status', 'LIKE', "%{$query}%");
                });
            })
            ->paginate(10);

        return view('dashboard-admin.data-mentor.index', compact('users', 'query'));
    }

    /**
     * Menampilkan form tambah mentor
     */
    public function create()
    {
        return view('dashboard-admin.data-mentor.create');
    }

    /**
     * Menampilkan detail mentor
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $courses = Course::where('mentor_id', $id)->paginate(5);

        foreach ($courses as $course) {
            $averageRating = RatingKursus::where('course_id', $course->id)->avg('stars');

            $course->average_rating = $averageRating ? round(min($averageRating, 5), 1) : 'Belum ada rating';
        }

        return view('dashboard-admin.data-mentor.show', compact('user', 'courses'));
    }

    /**
     * Menghapus mentor
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('data-mentor.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * Update status mentor menjadi inactive
     */
    public function updateStatusToInactive($id)
    {
        $user = User::findOrFail($id);

        if ($user->status !== 'inactive') {
            $user->status = 'inactive';
            $user->save();

            return redirect()->back()->with('success', 'Status mentor berhasil diperbarui menjadi nonaktif!');
        }

        return redirect()->back()->with('info', 'User sudah dalam status nonaktif.');
    }

    /**
     * Update status mentor menjadi active
     */
    public function updateStatus($id)
    {
        $user = User::findOrFail($id);

        if (in_array($user->status, ['pending', 'inactive'])) {
            $user->status = 'active';
            $user->save();

            Mail::to($user->email)->send(new HelloMail($user->name));

            return redirect()->back()->with('success', 'Status mentor berhasil diperbarui dan email telah terkirim!');
        }

        return redirect()->back()->with('info', 'User berhasil diaktifkan.');
    }

    /**
     * Toggle status active/inactive 
     */
    public function toggleActive(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($request->id);

        if ($user->role !== 'mentor') {
            return response()->json(['error' => 'User ini bukan mentor'], 403);
        }

        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => 'Status mentor diperbarui', 'status' => $user->status]);
    }
}
