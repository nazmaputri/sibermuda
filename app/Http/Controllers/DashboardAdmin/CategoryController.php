<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Ambil input dari searchbar

        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(5);

        $courses = Course::paginate(10);

        return view('dashboard-admin.category', compact('categories', 'courses', 'search'));
    }

    public function show($id)
    {
        $category = Category::with('courses')->where('id', $id)->firstOrFail();
        $courses = $category->courses()->paginate(5);
  
        return view('dashboard-admin.category-detail', compact('category', 'courses'));
    }    

    public function create()
    {
        return view('dashboard-admin.category-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'required|string',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string' => 'Nama kategori harus berupa teks.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'image.required' => 'foto wajib diisi.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus berupa jpg, png, atau jpeg.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'description.required' => 'deskripsi wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        $data = $request->only(['name', 'description']);

        // Cek apakah ada gambar yang di-upload
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('images/kategori', 'public');
        }

        // Simpan kategori
        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('dashboard-admin.category-edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'required|string',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, png, atau jpeg.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.required' => 'Deskripsi harus diisi.',
        ]);

        $category->name = $request->input('name');
        $category->description = $request->input('description');

        // Cek apakah ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }

            // Simpan gambar baru
            $category->image_path = $request->file('image')->store('images/kategori', 'public');
        }

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
