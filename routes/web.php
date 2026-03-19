<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;

// Public Static Pages
Route::get('/', function () { return view('home'); })->name('home');
Route::get('/needs', function () { return view('needs'); })->name('needs');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');

// Public Features
Route::get('/cari-arsitek', [FeatureController::class, 'cari'])->name('features.cari');
Route::get('/arsitek/{id}', [FeatureController::class, 'profil'])->name('features.profil');
Route::get('/pricing', [FeatureController::class, 'pricing'])->name('features.pricing');

// Protected Routes (Require Authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    // Chat Routes
    Route::get('/chat/{architect_id?}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages/{receiverId}', [ChatController::class, 'fetchMessages'])->name('chat.fetch');

    // Checkout / Payment Routes
    Route::get('/checkout/{architectId}', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'processPayment'])->name('checkout.process');
    
    // Default Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
