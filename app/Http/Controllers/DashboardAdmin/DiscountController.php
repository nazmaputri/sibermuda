<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Course;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DiscountController extends Controller
{
    /**
     * Menampilkan daftar diskon
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $discounts = Discount::with('courses')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('coupon_code', 'like', '%' . $search . '%')
                        ->orWhere('discount_percentage', 'like', '%' . $search . '%')
                        ->orWhere('start_date', 'like', '%' . $search . '%')
                        ->orWhere('end_date', 'like', '%' . $search . '%');
                });
            })
            ->paginate(5);

        return view('dashboard-admin.discount.index', compact('discounts', 'search'));
    }

    /**
     * Menampilkan form tambah diskon
     */
    public function create()
    {
        $courses = Course::all();

        return view('dashboard-admin.discount.create', compact('courses'));
    }

    /**
     * Menyimpan diskon baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|unique:discounts,coupon_code|max:12',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'apply_to_all' => 'nullable|boolean',
            'courses' => 'nullable|array',
        ], [
            'coupon_code.required' => 'Kode kupon wajib diisi.',
            'coupon_code.unique' => 'Kode kupon sudah digunakan, silakan gunakan kode lain.',
            'coupon_code.max' => 'Kode kupon maksimal 12 karakter.',
            'discount_percentage.required' => 'Persentase diskon wajib diisi.',
            'discount_percentage.integer' => 'Persentase diskon harus berupa angka.',
            'discount_percentage.min' => 'Persentase diskon minimal 1%.',
            'discount_percentage.max' => 'Persentase diskon maksimal 100%.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'end_date.required' => 'Tanggal berakhir wajib diisi.',
            'end_date.date' => 'Format tanggal berakhir tidak valid.',
            'end_date.after_or_equal' => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'end_time.required' => 'Waktu berakhir wajib diisi.',
            'apply_to_all.boolean' => 'Nilai apply to all harus berupa benar atau salah.',
            'courses.array' => 'Kursus harus berupa array.',
        ]);

        $applyToAll = (bool) $request->input('apply_to_all');

        if (! $applyToAll) {
            if (! $request->has('courses') || count($request->input('courses')) === 0) {
                return back()
                    ->withInput()
                    ->withErrors(['courses' => 'Mohon pilih minimal satu kursus atau centang "Terapkan ke semua kursus".']);
            }
        }

        if (! $applyToAll) {
            $today = Carbon::now();
            $selected = $request->input('courses', []);
            $activeDiscounts = Discount::where('apply_to_all', false)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->get();

            foreach ($selected as $courseId) {
                foreach ($activeDiscounts as $d) {
                    if ($d->courses->contains($courseId)) {
                        return back()
                            ->withInput()
                            ->withErrors([
                                'courses' => 'Kursus ID ' . $courseId . ' sudah memiliki diskon aktif.'
                            ]);
                    }
                }
            }
        }

        $discount = Discount::create([
            'coupon_code' => $request->coupon_code,
            'discount_percentage' => $request->discount_percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'apply_to_all' => $applyToAll,
        ]);

        if ($applyToAll) {
            $allCourseIds = Course::pluck('id')->toArray();
            $discount->courses()->attach($allCourseIds);
        } else {
            $discount->courses()->attach($request->input('courses', []));
        }

        return redirect()->route('discount.index')
            ->with('success', 'Diskon berhasil dibuat!');
    }

    /**
     * Menampilkan form edit diskon
     */
    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        $courses = Course::all();
        $courseTitles = $discount->courses->pluck('title')->toArray();
        $courseIds = $discount->courses->pluck('id')->toArray();

        return view('dashboard-admin.discount.edit', compact('discount', 'courses', 'courseTitles', 'courseIds'));
    }

    /**
     * Update diskon
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'coupon_code' => 'required|string|max:12',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'apply_to_all' => 'nullable|boolean',
            'courses' => 'nullable|array',
        ], [
            'coupon_code.required' => 'Kode kupon wajib diisi.',
            'coupon_code.string' => 'Kode kupon harus berupa teks.',
            'coupon_code.max' => 'Kode kupon maksimal 12 karakter.',
            'discount_percentage.required' => 'Persentase diskon wajib diisi.',
            'discount_percentage.numeric' => 'Persentase diskon harus berupa angka.',
            'discount_percentage.min' => 'Persentase diskon minimal 1%.',
            'discount_percentage.max' => 'Persentase diskon maksimal 100%.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'end_date.required' => 'Tanggal berakhir wajib diisi.',
            'end_date.date' => 'Format tanggal berakhir tidak valid.',
            'end_date.after_or_equal' => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'end_time.required' => 'Waktu berakhir wajib diisi.',
            'apply_to_all.boolean' => 'Nilai apply to all harus berupa benar atau salah.',
            'courses.array' => 'Kursus harus berupa array.',
        ]);

        $discount = Discount::findOrFail($id);
        $applyToAll = (bool) $request->input('apply_to_all');

        if (! $applyToAll) {
            if (! $request->has('courses') || count($request->input('courses')) === 0) {
                return back()
                    ->withInput()
                    ->withErrors(['courses' => 'Mohon pilih minimal satu kursus atau centang "Terapkan ke semua kursus".']);
            }
        }

        if (! $applyToAll) {
            $today = Carbon::now();
            $selected = $request->input('courses', []);
            $activeDiscounts = Discount::where('id', '!=', $discount->id)
                ->where('apply_to_all', false)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->get();

            foreach ($selected as $courseId) {
                foreach ($activeDiscounts as $d) {
                    if ($d->courses->contains($courseId)) {
                        return back()
                            ->withInput()
                            ->withErrors([
                                'courses' => 'Kursus ID ' . $courseId . ' sudah memiliki diskon aktif.'
                            ]);
                    }
                }
            }
        }

        $discount->coupon_code = $request->coupon_code;
        $discount->discount_percentage = $request->discount_percentage;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->start_time = $request->start_time;
        $discount->end_time = $request->end_time;
        $discount->apply_to_all = $applyToAll;
        $discount->save();

        if ($applyToAll) {
            $allCourseIds = Course::pluck('id')->toArray();
            $discount->courses()->sync($allCourseIds);
        } else {
            $discount->courses()->sync($request->input('courses', []));
        }

        return redirect()->route('discount.index')->with('success', 'Data diskon berhasil diperbarui.');
    }

    /**
     * Menghapus diskon
     */
    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('discount.index')->with('success', 'Diskon berhasil dihapus.');
    }

    /**
     * Menerapkan diskon ke kursus (untuk user)
     */
    public function applyDiscount(Request $request)
    {
        $couponCode = $request->coupon_code;
        $courseId = $request->course_id;

        $discount = Discount::where('coupon_code', $couponCode)->first();

        if (!$discount) {
            return redirect()->route('cart.index')->with('error', 'Kupon tidak valid');
        }

        $now = Carbon::now();
        $startDateTime = Carbon::parse($discount->start_date . ' ' . $discount->start_time);
        $endDateTime = Carbon::parse($discount->end_date . ' ' . $discount->end_time);

        if ($now->lt($startDateTime) || $now->gt($endDateTime)) {
            return redirect()->route('cart.index')->with('error', 'Kupon sudah kadaluarsa atau belum aktif');
        }

        $course = Course::find($courseId);

        if (!$course) {
            return redirect()->route('cart.index')->with('error', 'Kursus tidak ditemukan');
        }

        if (!$discount->apply_to_all && !$discount->courses->contains($courseId)) {
            return redirect()->route('cart.index')->with('error', 'Kupon tidak berlaku untuk kursus ini');
        }

        $discountAmount = ($course->price * $discount->discount_percentage) / 100;
        $discountedPrice = max($course->price - $discountAmount, 0); 

        return redirect()->route('cart.index')->with('success', 'Diskon berhasil diterapkan')->with([
            'original_price' => $course->price,
            'discount_percentage' => $discount->discount_percentage,
            'discounted_price' => $discountedPrice,
        ]);
    }
}
