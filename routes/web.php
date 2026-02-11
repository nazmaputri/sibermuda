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
use App\Http\Controllers\DashboardAdmin\NewsController;
use App\Http\Controllers\DashboardAdmin\BootcampController;
use App\Http\Controllers\DashboardMentor\RatingKursusController;
use App\Http\Controllers\DashboardMentor\FinalTaskController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardAdmin\DataAffiliateController;
use App\Http\Controllers\DashboardAdmin\DataMentorController;
use App\Http\Controllers\DashboardAdmin\DataPesertaController;
use App\Http\Controllers\DashboardAdmin\DiscountController;
use App\Http\Controllers\DashboardAdmin\LaporanController;
use App\Http\Controllers\DashboardAdmin\MainController;
use App\Http\Controllers\DashboardAdmin\RatingController as DashboardAdminRatingController;
use App\Http\Controllers\DashboardSuperAdmin\SuperAdminController;
use Illuminate\Support\Facades\Route;

//LandingPage
Route::get('/', [LandingPageController::class, 'main'])->name('landingpage');
Route::get('/kursus/{slug}', [LandingPageController::class, 'detail'])->name('kursus.detail');
Route::get('/beli-kursus/{slug}', [KeranjangController::class, 'handlePurchase'])->name('beli.kursus');
Route::post('/rating', [RatingController::class, 'store'])->name('rating.store');
Route::get('/tutorialbeli', [LandingPageController::class, 'buyingTutor'])->name('tutorial.beli');
Route::get('/tentangkami', [LandingPageController::class, 'about'])->name('tentang.kami');
Route::get('/visi-misi', [LandingPageController::class, 'visi'])->name('visi.misi');
Route::get('/kategori', [LandingPageController::class, 'category'])->name('category');
Route::get('/kategori/{slug}', [LandingPageController::class, 'categoryShow'])->name('category.detail');
Route::get('/berita', [LandingPageController::class, 'news'])->name('berita');
Route::get('/berita/{slug}', [LandingPageController::class, 'newsShow'])->name('news.detail');
Route::get('/testimoni', [LandingPageController::class, 'rating'])->name('testimoni');
Route::get('/bootcamp', [LandingPageController::class, 'bootcamp'])->name('bootcamp');
Route::get('/verifikasi-sertifikat', [LandingPageController::class, 'sertiverify'])->name('serti-verify');
Route::get('/program-affiliate', [LandingPageController::class, 'affiliate'])->name('affiliate');

//Verifikasi Email
Route::get('/email/verify/{id}/{hash}', [LoginController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
Route::post('/email/verification-notification', [LoginController::class, 'verifyHandler'])->middleware('throttle:6,1')->name('verification.send');

Route::get('login-sber-md', [LoginController::class, 'loginAdmin'])->name('sber-md');
Route::post('login-admin', [LoginController::class, 'prosesLogin'])->name('prosesLogin');
Route::get('/login-superadmin-sber-md', [SuperAdminController::class, 'loginsuperadmin'])->name('super-admin-login'); //Login Superadmin

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

    //Setting
    Route::get('/settings-student', [SettingController::class, 'student'])->name('settings-student');
    Route::put('/update-peserta', [SettingController::class, 'updatePeserta'])->name('update-peserta');
    Route::get('/user/{user}/avatar', [SettingController::class, 'showAvatar'])->name('user.avatar');

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

require __DIR__.'/affiliate.php';

require __DIR__.'/admin.php';
