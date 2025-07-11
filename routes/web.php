<?php

use App\Http\Controllers\Dashboard\DashboardAdminController;
use App\Http\Controllers\Dashboard\DashboardPesertaController;
use App\Http\Controllers\Dashboard\DashboardMentorController;
use App\Http\Controllers\DashboardMentor\CourseController;
use App\Http\Controllers\DashboardMentor\MateriController;
use App\Http\Controllers\DashboardMentor\VideoController;
use App\Http\Controllers\DashboardMentor\PdfController;
use App\Http\Controllers\DashboardMentor\QuizController;
use App\Http\Controllers\DashboardAdmin\CategoryController;
use App\Http\Controllers\DashboardMentor\RatingKursusController;
use App\Http\Controllers\DashboardMentor\FinalTaskController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardSuperAdmin\SuperAdminController;
use Illuminate\Support\Facades\Route;

//LandingPage
Route::get('/', [LandingPageController::class, 'lp'])->name('landingpage');
Route::get('/course/{slug}', [LandingPageController::class, 'detail'])->name('kursus.detail');
Route::get('/category/{slug}', [LandingPageController::class, 'category'])->name('category.detail');
Route::post('/ratings', [RatingController::class, 'store'])->name('rating.store');
Route::get('/beli-kursus/{slug}', [KeranjangController::class, 'handlePurchase'])->name('beli.kursus');
Route::get('/tutorialbeli', [LandingPageController::class, 'tutorialbeli'])->name('tutorial.beli');
Route::get('/tentangkami', [LandingPageController::class, 'tentangkami'])->name('tentang.kami');
Route::get('/visi', [LandingPageController::class, 'visi'])->name('visi.misi');
Route::get('/category', [LandingPageController::class, 'categorylp'])->name('category');

//Verifikasi Email
Route::get('/email/verify/{id}/{hash}', [LoginController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
Route::post('/email/verification-notification', [LoginController::class, 'verifyHandler'])->middleware('throttle:6,1')->name('verification.send');

Route::get('login-sber-md', [LoginController::class, 'loginAdmin'])->name('sber-md');
Route::post('login-admin', [LoginController::class, 'prosesLogin'])->name('prosesLogin');
Route::get('/login-superadmin-sber-md', [SuperAdminController::class, 'loginsuperadmin'])->name('super-admin-login'); //Login Superadmin

// Route berdasarkan role

Route::middleware(['auth:admin'])->group(function () {
    
    //Beranda
    Route::get('dashboard-admin/welcome', [DashboardAdminController::class, 'show'])->name('welcome-admin');

    //Kursus
    Route::get('/kursus/{categoryId}/{courseId}', [DashboardAdminController::class, 'detailkursus'])->name('detail-kursusadmin');
    Route::get('/kursus/{id}', [DashboardAdminController::class, 'detailkursus'])->name('detailkursus'); //nggadipake, tp jgn dikomen nnti detail mentor malah ngaco 

    //Laporan
    Route::get('dashboard-admin/laporan', [DashboardAdminController::class, 'laporan'])->name('laporan-admin');

    //Penilaian
    Route::get('dashboard-admin/rating', [DashboardAdminController::class, 'rating'])->name('rating-admin');

    //Pengaturan Akun
    Route::get('/settings-admin', [SettingController::class, 'admin'])->name('settings.admin');
    Route::post('/settings-admin/update', [SettingController::class, 'update']);

    //Notifikasi 
    Route::get('/admin/notifications', [DashboardAdminController::class, 'getNotifications'])->name('admin.notifications');
    
    //Rating
    Route::post('toggle/displayadmin/{id}', [RatingController::class, 'toggleDisplayAdmin'])->name('toggle.displayadmin');
    Route::delete('/ratings/{id}', [RatingController::class, 'destroy'])->name('ratings.destroy');

    //Mentor
    Route::get('/mentor/detail/{id}', [DashboardAdminController::class, 'detailmentor'])->name('detaildata-mentor');
    Route::get('dashboard-admin/data-mentor', [DashboardAdminController::class, 'mentor'])->name('datamentor-admin');
    Route::get('dashboard-admin/tambah-mentor', [DashboardAdminController::class, 'tambahmentor'])->name('tambah-mentor');
    Route::post('/admin/users/{id}/status/inactive', [DashboardAdminController::class, 'updateStatusToInactive'])->name('updateStatusToInactive'); 
    Route::post('/mentor/toggle/status', [DashboardAdminController::class, 'toggleActive'])->name('mentors.toggle');
    Route::post('/admin/users/{id}/status', [DashboardAdminController::class, 'updateStatus'])->name('admin.users.updateStatus'); 
    Route::delete('/dashboard/mentor/{id}', [DashboardAdminController::class, 'destroy'])->name('datamentor-admin.delete');

    //Peserta
    Route::get('/peserta/detail/{id}', [DashboardAdminController::class, 'detailpeserta'])->name('detaildata-peserta');
    Route::get('dashboard-admin/tambah-peserta', [DashboardAdminController::class, 'tambahpeserta'])->name('tambah-peserta');
    Route::get('dashboard-admin/data-peserta', [DashboardAdminController::class, 'peserta'])->name('datapeserta-admin');
    Route::delete('/dashboard/peserta/{id}', [DashboardAdminController::class, 'deletePeserta'])->name('datapeserta-admin.delete');
    //Update status pembayaran
    Route::put('/admin/update-status/{id}', [PaymentController::class, 'updateStatus'])->name('admin.update-status');

    //Pembayaran Manual
    Route::post('/admin/import-manual', [DashboardAdminController::class, 'importManual'])->name('admin.import.manual');
   
    //Import Peserta dari Excel
    Route::post('import-excel', [DashboardAdminController::class, 'importExcel'])->name('import.excel');

    //Export Data Pendapatan ke Excel
    Route::get('/purchases/export', [DashboardAdminController::class, 'export'])->name('purchases.export');

    //Discount 
    Route::get('discount', [DiscountController::class, 'index'])->name('discount');
    Route::get('discount-tambah', [DiscountController::class, 'create'])->name('discount-tambah');
    Route::post('discount.store', [DiscountController::class, 'store'])->name('discount.store');
    Route::get('discount/{id}/edit', [DiscountController::class, 'edit'])->name('discount.edit');
    Route::put('discount/{id}', [DiscountController::class, 'update'])->name('discount.update');
    Route::delete('discount/{id}', [DiscountController::class, 'destroy'])->name('discount.destroy');

    // Kategori
    Route::resource('categories', CategoryController::class);
    Route::patch('/courses/{categoryId}/{courseId}/approve', [DashboardAdminController::class, 'approve'])->name('courses.approve');
    Route::patch('/courses/{categoryId}/{courseId}/publish', [DashboardAdminController::class, 'publish'])->name('courses.publish');
    Route::patch('/courses/{categoryId}/{courseId}/hiddencourse', [DashboardAdminController::class, 'hiddencourse'])->name('hiddencourse');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

    // FITUR/AKSES SUPERADMIN
    Route::get('/welcome-superadmin', [SuperAdminController::class, 'index'])->name('welcome-superadmin'); //Dashboard Superadmin
    Route::get('/settings-superadmin', [SuperAdminController::class, 'setting'])->name('settings.superadmin'); //Pengaturan Akun
    Route::get('/dashboard-superadmin/data-admin', [SuperAdminController::class, 'dataadmin'])->name('dataadmin-superadmin'); //Data Admin
    Route::post('/dashboard-superadmin/{id}/status-inactive', [SuperAdminController::class, 'updatestatusadmintoinactive'])->name('updatestatusadmintoinactive'); //Update Status Admin Jadi Inactive
    Route::post('/dashboard-superadmin/{id}/status-active', [SuperAdminController::class, 'updatestatusadmintoactive'])->name('updatestatusadmintoactive'); //Update Status Admin Jadi Active
    Route::get('/dashboard-superadmin/detail-admin/{id}', [SuperAdminController::class, 'detailadmin'])->name('detaildataadmin-superadmin'); //Detail Admin
    Route::delete('/dashboard-superadmin/admin/{id}', [SuperAdminController::class, 'destroyadmin'])->name('dataadmin-delete-superadmin'); //Hapus Admin
    Route::get('/dashboard-superadmin/data-mentor', [SuperAdminController::class, 'datamentor'])->name('datamentor-superadmin'); //Data Mentor
    Route::get('/dashboard-superadmin/tambah-mentor', [SuperAdminController::class, 'tambahmentorbysuperadmin'])->name('tambah-mentor-superadmin'); //Form Tambah Data Mentor
    Route::get('/dashboard-superadmin/detailmentor/{id}', [SuperAdminController::class, 'detailmentorsuperadmin'])->name('detaildata-mentor-superadmin'); //Detail Mentor Superadmin
    Route::get('/dashboard-superadmin/data-peserta', [SuperAdminController::class, 'peserta'])->name('datapeserta-superadmin'); //Data Peserta Superadmin
    Route::get('/dashboard-superadmin/detailpeserta/{id}', [SuperAdminController::class, 'detailpeserta'])->name('detaildata-peserta-superadmin'); //Detail Data Peserta Superadmin
    Route::get('/dashboard-superadmin/edit-peserta/{id}', [SuperAdminController::class, 'editpeserta'])->name('edit-peserta-superadmin'); //Form Edit Data Peserta Superadmin
    Route::put('/dashboard-superadmin/update-peserta/{id}', [SuperAdminController::class, 'updatepeserta'])->name('update-peserta-superadmin'); ///Update Data Peserta Superadmin
    Route::get('/dashboard-superadmin/kategori', [SuperAdminController::class, 'kategori'])->name('kategori-superadmin'); //Kategori Kursus Superadmin
    Route::get('/dashboard-superadmin/tambah-kategori', [SuperAdminController::class, 'tambahkategori'])->name('tambahkategori-superadmin'); //Form Tambah Kategori Kursus Superadmin
    Route::get('/dashboard-superadmin/edit-kategori/{category}', [SuperAdminController::class, 'editkategori'])->name('editkategori-superadmin'); //Form Edit Kategori Kursus Superadmin
    Route::get('/dashboard-superadmin/detail-kategori/{id}', [SuperadminController::class, 'detailkategori'])->name('detailkategori-superadmin'); //Detail kategori Superadmin
    Route::get('/dashboard-superadmin/kursus/{categoryId}/{courseId}', [SuperAdminController::class, 'detailkursus'])->name('detail-kursus-superadmin'); //Detail Kursus Superadmin
    Route::get('/dashboard-superadmin/diskon', [SuperAdminController::class, 'diskon'])->name('diskon-superadmin'); //Diskon Superadmin
    Route::get('/dashboard-superadmin/tambah-diskon', [SuperAdminController::class, 'tambahdiskon'])->name('tambah-diskon-superadmin'); //Tambah Diskon Superadmin
    Route::get('/dashboard-superadmin/edit-diskon/{id}', [SuperAdminController::class, 'editdiskon'])->name('editdiskon-superadmin'); //Edit Diskon Superadmin
    Route::get('/dashboard-superadmin/rating-superadmin', [SuperAdminController::class, 'rating'])->name('rating-superadmin'); //Rating Superadmin
    Route::get('dashboard-superadmin/laporan-superadmin', [SuperAdminController::class, 'laporan'])->name('laporan-superadmin'); //Laporan Superadmin
    Route::get('/dashboard-superadmin/notifications', [SuperAdminController::class, 'Notifications'])->name('superadmin.notifications'); //Notifikasi Superadmin

});

Route::middleware(['auth:student'])->group(function () {
    //Dashboard Peserta
    Route::get('dashboard-peserta/welcome', [DashboardPesertaController::class, 'show'])->middleware('verified')->name('welcome-peserta');
    Route::get('dashboard-peserta/daftar', [DashboardPesertaController::class, 'daftar'])->name('daftar-peserta');
    Route::get('dashboard-peserta/kursus', [DashboardPesertaController::class, 'kursusTerdaftar'])->name('daftar-kursus');
    Route::get('/detail-kursus-peserta/{slug}/{categorySlug?}', [DashboardPesertaController::class, 'kursus'])->name('kursus-peserta');
    Route::get('dashboard-peserta/kursus/{slug}', [DashboardPesertaController::class, 'detail'])->name('detail-kursus');
    Route::get('dashboard-peserta/study/{slug}/{materiId?}', [DashboardPesertaController::class, 'study'])->name('study-peserta');
    Route::get('dashboard-peserta/video', [DashboardPesertaController::class, 'video'])->name('video-peserta');
    Route::get('dashboard-peserta/quiz', [DashboardPesertaController::class, 'quiz'])->name('quiz-peserta');
    Route::get('dashboard-peserta/kategori', [DashboardPesertaController::class, 'kategori'])->name('kategori-peserta');
    Route::get('/categories/{id}/detail', [DashboardPesertaController::class, 'showCategoryDetail'])->name('categories-detail');
    Route::get('/settings-student', [SettingController::class, 'student'])->name('settings-student');
    Route::put('/update-peserta', [SettingController::class, 'updatePeserta'])->name('update-peserta');
    Route::post('/kursus/{course_id}/rating', [RatingKursusController::class, 'store'])->name('ratings.store');
    Route::post('/rating/load-more', [DashboardPesertaController::class, 'loadMoreRating'])->name('rating.loadMore'); // rooute untuk menampilkan lebih banyak rating di halama detail kursus (role peserta)
    Route::post('/materi/{materi}/next-or-finish', [MateriController::class, 'nextOrFinish'])->name('materi.nextOrFinish');

    Route::get('/notifikasi/pembelian', [DashboardPesertaController::class, 'navbarNotifikasi']);

    //Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah/{slug}', [KeranjangController::class, 'addToCart'])->name('cart.add');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'removeFromCart'])->name('cart.remove');

    //Keranjang Pending
    Route::get('/keranjang-pending', [KeranjangController::class, 'keranjangpending'])->name('keranjang-pending');

    Route::post('/apply-discount', [DiscountController::class, 'applyDiscount'])->name('apply.discount');

    //Tugas Akhir
    Route::get('/finaltask-user/{course}/{finalTaskId}', [FinalTaskController::class, 'user'])->name('finaltask-user');
    Route::post('/finaltask-upload', [FinalTaskController::class, 'storeUser'])->name('finaltaskstore-user');

    //Quiz Peserta
    Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{quiz}/retake', [QuizController::class, 'retake'])->name('quiz.retake');
    Route::post('/quiz/{quiz}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/quiz/{quiz}/result', [QuizController::class, 'result'])->name('quiz.result');

    Route::get('/certificate-detail/{courseId}', [CertificateController::class, 'certificate'])->name('certificate-detail');
    Route::get('/certificate/download/{courseId}', [CertificateController::class, 'downloadCertificate'])->name('certificate.download');
    Route::post('/create-payment', [PaymentController::class, 'createPayment'])->name('create-payment');
    Route::post('/update-payment-status', [PaymentController::class, 'updatePaymentStatus']);
});

Route::middleware(['auth:mentor'])->group(function () {
    //Dashboard Mentor
    Route::get('dashboard-mentor/welcome', [DashboardMentorController::class, 'show'])->name('welcome-mentor');
    Route::get('dashboard-mentor/data-peserta', [DashboardMentorController::class, 'datapeserta'])->name('datapeserta-mentor');
    Route::get('dashboard-mentor/laporan', [DashboardMentorController::class, 'laporan'])->name('laporan-mentor');
    Route::get('dashboard-mentor/rating', [DashboardMentorController::class, 'rating'])->name('rating-kursus');
    Route::get('dashboard-mentor/rating/{id}', [DashboardMentorController::class, 'ratingDetail'])->name('rating-detail');
    Route::post('/rating/{id}/toggle-display', [RatingKursusController::class, 'toggleDisplay'])->name('toggle.displaymentor');
    Route::delete('/rating/{id}', [RatingKursusController::class, 'destroy'])->name('ratingmentor.destroy');
    Route::get('/notifications/final-task-user', [DashboardMentorController::class, 'getPendingNotifications']);
    Route::get('/settings-mentor', [SettingController::class, 'mentor'])->name('settings.mentor');
    Route::post('/settings', [SettingController::class, 'update']);
    
    //Kursus
    Route::resource('courses', CourseController::class);

    // Materi
    Route::patch('/materi/{id}/toggle-preview', [MateriController::class, 'togglePreview'])->name('materi.togglePreview');
    Route::get('/materi/{slug}/{materiId}', [MateriController::class, 'show'])->name('materi.show');
    Route::get('/materi/{slug}', [MateriController::class, 'create'])->name('materi.create');
    Route::post('/materi/{courseId}', [MateriController::class, 'store'])->name('materi.store');
    Route::get('/materi/edit/{slug}/{materiId}', [MateriController::class, 'edit'])->name('materi.edit');
    Route::put('/materi/edit/{courseId}/{materiId}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{courseId}/destroy/{materiId}', [MateriController::class, 'destroy'])->name('materi.destroy');
    Route::delete('video/{video}', [VideoController::class, 'destroy'])->name('video.destroy');
    Route::delete('pdf/{pdf}', [PdfController::class, 'destroy'])->name('pdf.destroy');

    // Quiz
    Route::get('/quiz-detail/{course}/{quiz}', [QuizController::class, 'detail'])->name('quiz-detail');
    Route::get('/quiz-create/{courseId}', [QuizController::class, 'create'])->name('quiz.create');
    Route::post('/quiz/{courseId}', [QuizController::class, 'store'])->name('quiz.store');
    Route::get('/quiz-edit/{courseId}/{quiz}', [QuizController::class, 'edit'])->name('quiz-edit');
    Route::put('/quiz/{courseId}/{quiz}', [QuizController::class, 'update'])->name('quiz.update');
    Route::delete('/quiz/{courseId}/{quiz}', [QuizController::class, 'destroy'])->name('quiz.destroy');

    //Tugas Akhir
    Route::get('/finaltask-detail/{course}/{id}', [FinalTaskController::class, 'detail'])->name('finaltask.detail');
    Route::get('/finaltask-detail/{courseId}/{taskId}/{userId}', [FinalTaskController::class, 'detailByUser'])->name('finaltask.detailByUser'); // route untuk menampilkan detail tugas akhir yg dikirim oleh peserta
    Route::get('/finaltask-create/{courseId}', [FinalTaskController::class, 'create'])->name('finaltask.create');
    Route::post('/finaltask/{courseId}', [FinalTaskController::class, 'store'])->name('finaltask.store');
    Route::get('/finaltask-edit/{course}/{id}', [FinalTaskController::class, 'edit'])->name('finaltask.edit');
    Route::put('/finaltask-update/{course}/{id}', [FinalTaskController::class, 'update'])->name('finaltask.update');
    Route::delete('/finaltask/{course}/{id}', [FinalTaskController::class, 'destroy'])->name('finaltask.destroy');

    // Konfirmasi Sertifikat
    Route::post('/final-task/{id}/confirm', [FinalTaskController::class, 'confirm'])->name('final-task.confirm');
});

//Umum
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/certificate/{courseId}', [CertificateController::class, 'showCertificate'])->name('certificate.show');

Route::middleware('auth:mentor,student')->group(function () {
    Route::get('chat/student/{slug}/{chatId?}', [ChatController::class, 'chatStudent'])->name('chat.student');
    Route::get('chat/mentor/{slug}/{chatId?}', [ChatController::class, 'chatMentor'])->name('chat.mentor');
    Route::post('chat-send/{chatId}', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/start/{slug}/{studentId?}', [ChatController::class, 'startChat'])->name('chat.start');
});

// Route jika halaman tidak ditemukan notfound
Route::fallback(function () {
    abort(404);
});

require __DIR__.'/auth.php';

