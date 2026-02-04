<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DataAffiliateController extends Controller
{
    /**
     * Menampilkan daftar affiliate
     */
    public function index(Request $request)
    {
        $query = $request->input('search');

        $users = User::where('role', 'affiliate')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('status', 'LIKE', "%{$query}%");
                });
            })
            ->paginate(10);

        return view('dashboard-admin.data-affiliate.index', compact('users', 'query'));
    }

    /**
     * Menampilkan form tambah affiliate
     */
    public function create()
    {
        return view('dashboard-admin.data-affiliate.create');
    }

    /**
     * Menampilkan detail affiliate
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('dashboard-admin.data-affiliate.show', compact('user'));
    }

    /**
     * Menyimpan affiliate baru
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         // validasi lainnya
    //     ]);

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'role' => 'affiliate',
    //         // field lainnya
    //     ]);

    //     return redirect()->route('data-affiliate.index')->with('success', 'Affiliate berhasil ditambahkan!');
    // }

    /**
     * Menampilkan form edit affiliate
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('dashboard-admin.data-affiliate.edit', compact('user'));
    }

    /**
     * Update affiliate
     */
    // public function update(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email,' . $id,
    //         // validasi lainnya
    //     ]);

    //     $user->update($request->all());

    //     return redirect()->route('data-affiliate.index')->with('success', 'Affiliate berhasil diperbarui!');
    // }

    /**
     * Menghapus affiliate
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('data-affiliate.index')->with('success', 'Affiliate berhasil dihapus!');
    }
}
