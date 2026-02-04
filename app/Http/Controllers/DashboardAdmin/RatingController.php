<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Menampilkan daftar rating
     */
    public function index()
    {
        $ratings = Rating::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard-admin.rating.index', compact('ratings'));
    }

    /**
     * Menampilkan detail rating
     */
    // public function show($id)
    // {
    //     $rating = Rating::with(['user', 'course'])->findOrFail($id);

    //     return view('dashboard-admin.rating.show', compact('rating'));
    // }

    /**
     * Menghapus rating
     */
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return redirect()->route('rating.index')->with('success', 'Rating berhasil dihapus!');
    }
}
