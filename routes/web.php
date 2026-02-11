<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\MemorialController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TributeController;
use App\Http\Controllers\VirtualGiftController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Webhook\StripeWebhookController;
use Illuminate\Support\Facades\Route;

// Language switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Public pages
Route::get('/', fn () => view('pages.home'))->name('home');
Route::get('/pricing', fn () => view('pages.pricing'))->name('pricing');
Route::get('/about', fn () => view('pages.about'))->name('about');
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');

// QR code redirect
Route::get('/qr/{code}', [QrCodeController::class, 'redirect'])->name('qr.redirect');

// Stripe webhook
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])->name('stripe.webhook');

// Authenticated dashboard routes
Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Memorials
    Route::resource('memorials', MemorialController::class)->except(['show']);
    Route::get('memorials/{memorial}/qr', [QrCodeController::class, 'show'])->name('memorials.qr');
    Route::post('memorials/{memorial}/photos', [PhotoController::class, 'store'])->name('memorials.photos.store');
    Route::patch('photos/{photo}', [PhotoController::class, 'update'])->name('photos.update');
    Route::delete('photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');

    // Tributes management
    Route::post('tributes/{tribute}/approve', [TributeController::class, 'approve'])->name('tributes.approve');
    Route::post('tributes/{tribute}/reject', [TributeController::class, 'reject'])->name('tributes.reject');
    Route::delete('tributes/{tribute}', [TributeController::class, 'destroy'])->name('tributes.destroy');

    // Billing
    Route::get('billing', [BillingController::class, 'index'])->name('billing');
    Route::post('checkout', [BillingController::class, 'checkout'])->name('checkout');
    Route::get('billing/portal', [BillingController::class, 'portal'])->name('billing.portal');

    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (must be before the slug catch-all)
require __DIR__.'/auth.php';

// Public memorial routes (must be last — slug catch-all)
Route::get('/{memorial:slug}', [MemorialController::class, 'show'])->name('memorial.show');
Route::get('/{slug}/gallery', [MemorialController::class, 'gallery'])->name('memorial.gallery');
Route::get('/{slug}/timeline', [MemorialController::class, 'timeline'])->name('memorial.timeline');
Route::get('/{slug}/password', [MemorialController::class, 'password'])->name('memorial.password');
Route::post('/{slug}/password', [MemorialController::class, 'verifyPassword'])->name('memorial.password.verify');
Route::post('/{slug}/tributes', [TributeController::class, 'store'])->name('memorial.tributes.store');
Route::post('/{slug}/gifts', [VirtualGiftController::class, 'store'])->name('memorial.gifts.store');
