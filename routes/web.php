<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\RedemptionController as AdminRedemptionController;
use App\Http\Controllers\Peserta\DashboardController as PesertaDashboardController;
use App\Http\Controllers\Peserta\TransactionController as PesertaTransactionController;
use App\Http\Controllers\Peserta\RedemptionController as PesertaRedemptionController;

// Halaman Beranda (Landing Page)
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('peserta.dashboard');
    }
    return view('welcome');
})->name('home');

// Autentikasi Tamu (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout (Wajib Auth)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute Khusus Admin (Diproteksi Auth & Custom Middleware role:admin)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Kategori Sampah
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');

    // Verifikasi & Penilaian Transaksi Limbah
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [AdminTransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{transaction}/approve', [AdminTransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{transaction}/reject', [AdminTransactionController::class, 'reject'])->name('transactions.reject');

    // Pengelolaan Penukaran Poin ke Rupiah
    Route::get('/redemptions', [AdminRedemptionController::class, 'index'])->name('redemptions.index');
    Route::post('/redemptions/{redemption}/complete', [AdminRedemptionController::class, 'complete'])->name('redemptions.complete');
});

// Rute Khusus Peserta (Diproteksi Auth & Custom Middleware role:peserta)
Route::prefix('peserta')->name('peserta.')->middleware(['auth', 'role:peserta'])->group(function () {
    Route::get('/dashboard', [PesertaDashboardController::class, 'index'])->name('dashboard');

    // Pengajuan & Riwayat Transaksi Limbah
    Route::get('/transactions', [PesertaTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [PesertaTransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [PesertaTransactionController::class, 'store'])->name('transactions.store');

    // Riwayat & Klaim Penukaran Poin ke Rupiah
    Route::get('/redemptions', [PesertaRedemptionController::class, 'index'])->name('redemptions.index');
    Route::post('/redemptions', [PesertaRedemptionController::class, 'store'])->name('redemptions.store');
});
