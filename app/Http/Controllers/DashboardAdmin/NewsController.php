<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Menampilkan daftar berita 
     */
    public function index(Request $request)
    {
        $query = News::query()->orderBy('published_at', 'desc');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $news = $query->paginate(10);

        return view('dashboard-admin.news.index', compact('news'));
    }

    /**
     * Menampilkan form tambah berita
     */
    public function create()
    {
        $categories = [
            'Kursus Baru',
            'Tips & Trik',
            'Prestasi',
            'Event',
            'Pengumuman',
            'Kerjasama',
            'Promo'
        ];

        return view('dashboard-admin.news.create', compact('categories'));
    }

    /**
     * Menyimpan berita baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required|max:100',
            'author' => 'required|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $imagePath = Storage::url($imagePath);
        }

        News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'author' => $validated['author'],
            'image_path' => $imagePath,
            'published_at' => $validated['published_at'] ?? now(),
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail berita
     */
    public function show($id)
    {
        $news = News::findOrFail($id);

        return view('dashboard-admin.news.show', compact('news'));
    }

    /**
     * Menampilkan form edit berita
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);

        $categories = [
            'Kursus Baru',
            'Tips & Trik',
            'Prestasi',
            'Event',
            'Pengumuman',
            'Kerjasama',
            'Promo'
        ];

        return view('dashboard-admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update berita
     */
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required|max:100',
            'author' => 'required|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date'
        ]);

        $imagePath = $news->image_path;
        if ($request->hasFile('image')) {
            if ($news->image_path && strpos($news->image_path, 'storage') !== false) {
                $oldPath = str_replace('/storage/', '', $news->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $imagePath = $request->file('image')->store('news', 'public');
            $imagePath = Storage::url($imagePath);
        }

        $news->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'author' => $validated['author'],
            'image_path' => $imagePath,
            'published_at' => $validated['published_at'] ?? $news->published_at,
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Menghapus berita
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->image_path && strpos($news->image_path, 'storage') !== false) {
            $path = str_replace('/storage/', '', $news->image_path);
            Storage::disk('public')->delete($path);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus!');
    }
}
