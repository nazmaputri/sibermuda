<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Models\Bootcamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BootcampController extends Controller
{
    /**
     * Menampilkan daftar bootcamp
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bootcamps = Bootcamp::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('dashboard-admin.bootcamp.index', compact('bootcamps', 'search'));
    }

    /**
     * Menampilkan form tambah bootcamp
     */
    public function create()
    {
        return view('dashboard-admin.bootcamp.create');
    }

    /**
     * Menyimpan bootcamp baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string|max:100',
            'level' => 'required|string|max:100',
            'schedule' => 'required|string|max:255',
            'price' => 'required|string|max:100',
            'discount_price' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'syllabus' => 'nullable|array',
            'syllabus.*' => 'string',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('bootcamps', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);

        Bootcamp::create($validated);

        return redirect()->route('bootcamp.index')->with('success', 'Bootcamp berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail bootcamp
     */
    public function show($id)
    {
        $bootcamp = Bootcamp::findOrFail($id);

        return view('dashboard-admin.bootcamp.show', compact('bootcamp'));
    }

    /**
     * Menampilkan form edit bootcamp
     */
    public function edit($id)
    {
        $bootcamp = Bootcamp::findOrFail($id);

        return view('dashboard-admin.bootcamp.edit', compact('bootcamp'));
    }

    /**
     * Update bootcamp
     */
    public function update(Request $request, $id)
    {
        $bootcamp = Bootcamp::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string|max:100',
            'level' => 'required|string|max:100',
            'schedule' => 'required|string|max:255',
            'price' => 'required|string|max:100',
            'discount_price' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'syllabus' => 'nullable|array',
            'syllabus.*' => 'string',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($bootcamp->image) {
                Storage::disk('public')->delete($bootcamp->image);
            }
            $validated['image'] = $request->file('image')->store('bootcamps', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);

        $bootcamp->update($validated);

        return redirect()->route('bootcamp.index')->with('success', 'Bootcamp berhasil diperbarui!');
    }

    /**
     * Menghapus bootcamp
     */
    public function destroy($id)
    {
        $bootcamp = Bootcamp::findOrFail($id);

        if ($bootcamp->image) {
            Storage::disk('public')->delete($bootcamp->image);
        }

        $bootcamp->delete();

        return redirect()->route('bootcamp.index')->with('success', 'Bootcamp berhasil dihapus!');
    }
}
