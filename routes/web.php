<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SpecializationController as AdminSpecializationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Architect\DashboardController as ArchitectDashboardController;
use App\Http\Controllers\Architect\PortfolioController as ArchitectPortfolioController;
use App\Http\Controllers\Architect\ProfileController as ArchitectProfileController;
use App\Http\Controllers\Architect\ProjectController as ArchitectProjectController;
use App\Http\Controllers\Architect\ReviewController as ArchitectReviewController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\ProjectController as ClientProjectController;
use App\Http\Controllers\Client\ReviewController as ClientReviewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\FollowedArchitectController;
use App\Http\Controllers\MidtransNotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Static Pages
Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/needs', function () {
    return view('needs');
})->name('needs');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Midtrans HTTP notification (tanpa CSRF; tanpa auth)
Route::post('/midtrans/notification', [MidtransNotificationController::class, 'handle'])->name('midtrans.notification');

// Public Features
Route::get('/cari-arsitek', [FeatureController::class, 'cari'])->name('features.cari');
Route::get('/arsitek/{id}', [FeatureController::class, 'profil'])->name('features.profil');
Route::get('/pricing', [FeatureController::class, 'pricing'])->name('features.pricing');
Route::get('/arsitek-saya', [FollowedArchitectController::class, 'index'])->name('features.followed');

// Protected Routes (Require Authentication)
Route::middleware(['auth', 'verified'])->group(function () {

    // Client review actions from architect public profile page & checkout
    Route::middleware('can:client')->group(function () {
        Route::post('/arsitek/{architect}/reviews', [FeatureController::class, 'storeReview'])->name('features.reviews.store');
        Route::put('/arsitek/{architect}/reviews/{review}', [FeatureController::class, 'updateReview'])->name('features.reviews.update');
        Route::get('/arsitek/{architect}/follow', [FeatureController::class, 'followFromLink'])->name('features.follow.link');
        Route::post('/arsitek/{architect}/follow', [FeatureController::class, 'follow'])->name('features.follow');
        Route::post('/arsitek/{architect}/unfollow', [FeatureController::class, 'unfollow'])->name('features.unfollow');

        Route::get('/checkout/finish/{project}', [CheckoutController::class, 'finish'])->name('checkout.finish');
        Route::get('/checkout/{architect}', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/process', [CheckoutController::class, 'processPayment'])->name('checkout.process');
    });

    // Dashboard Hub
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Dashboard
    Route::middleware('can:admin')->prefix('admin/dashboard')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Users Management
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Master Specializations
        Route::resource('specializations', AdminSpecializationController::class)->except(['show']);

        // Reviews Management
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::patch('/reviews/{review}/resolve', [AdminReviewController::class, 'resolveReport'])->name('reviews.resolve');
    });

    // Architect Dashboard
    Route::middleware('can:architect')->prefix('architect/dashboard')->name('architect.')->group(function () {
        Route::get('/', [ArchitectDashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [ArchitectProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ArchitectProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/deactivate', [ArchitectProfileController::class, 'deactivate'])->name('profile.deactivate');

        // Portfolio
        Route::resource('portfolios', ArchitectPortfolioController::class);

        // Projects (Status Desain)
        Route::get('/projects', [ArchitectProjectController::class, 'index'])->name('projects.index');
        Route::patch('/projects/{project}/status', [ArchitectProjectController::class, 'updateStatus'])->name('projects.update-status');

        // Reviews
        Route::get('/reviews', [ArchitectReviewController::class, 'index'])->name('reviews.index');
    });

    // Client Dashboard
    Route::middleware('can:client')->prefix('client/dashboard')->name('client.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'index'])->name('dashboard');

        // Transaction History / Projects
        Route::get('/projects', [ClientProjectController::class, 'index'])->name('projects.index');

        // Review Management
        Route::get('/reviews', [ClientReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reviews/create/{project}', [ClientReviewController::class, 'create'])->name('reviews.create');
        Route::post('/reviews/{project}', [ClientReviewController::class, 'store'])->name('reviews.store');
        Route::get('/reviews/{review}/edit', [ClientReviewController::class, 'edit'])->name('reviews.edit');
        Route::put('/reviews/{review}', [ClientReviewController::class, 'update'])->name('reviews.update');
    });

    // Chat Routes (specific paths before optional /chat/{id})
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/receipt/delivered', [ChatController::class, 'markDelivered'])->name('chat.receipt.delivered');
    Route::get('/chat/messages/{receiverId}', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
    Route::get('/chat/{architect_id?}', [ChatController::class, 'index'])->name('chat.index');

    // Default Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
