<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MemorialController;
use App\Http\Controllers\MemorialExportController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\TributeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VirtualGiftController;
use App\Http\Controllers\VoiceMemoryController;
use App\Http\Controllers\Webhook\StripeWebhookController;
use App\Http\Middleware\HoneypotProtection;
use App\Models\Memorial;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Language switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Sitemap
Route::get('/sitemap.xml', function () {
    $path = public_path('sitemap.xml');
    if (! file_exists($path)) {
        Artisan::call('sitemap:generate');
    }

    return response()->file($path, ['Content-Type' => 'application/xml']);
})->name('sitemap');

// Public pages
Route::get('/', function () {
    $today = now();

    $bornToday = Memorial::query()
        ->where('is_published', true)
        ->where('privacy', 'public')
        ->whereMonth('date_of_birth', $today->month)
        ->whereDay('date_of_birth', $today->day)
        ->first();

    $diedToday = Memorial::query()
        ->where('is_published', true)
        ->where('privacy', 'public')
        ->whereMonth('date_of_death', $today->month)
        ->whereDay('date_of_death', $today->day)
        ->first();

    return view('pages.home', compact('bornToday', 'diedToday'));
})->name('home');
Route::get('/pricing', fn() => view('pages.pricing'))->name('pricing');
Route::get('/about', fn() => view('pages.about'))->name('about');
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
    Route::middleware('subscribed')->group(function () {
        Route::get('memorials/{memorial}/qr', [QrCodeController::class, 'show'])->name('memorials.qr');
        Route::get('memorials/{memorial}/qr/download', [QrCodeController::class, 'download'])->name('memorials.qr.download');
        Route::get('memorials/{memorial}/analytics', [DashboardController::class, 'analytics'])->name('memorials.analytics');
        Route::get('memorials/{memorial}/voice-memories', [VoiceMemoryController::class, 'index'])->name('memorials.voice-memories.index');
        Route::post('memorials/{memorial}/voice-memories', [VoiceMemoryController::class, 'store'])->name('memorials.voice-memories.store');
        Route::delete('voice-memories/{voiceMemory}', [VoiceMemoryController::class, 'destroy'])->name('voice-memories.destroy');
        Route::get('memorials/{memorial}/export', [MemorialExportController::class, 'show'])->name('memorials.export');
    });
    Route::post('memorials/{memorial}/photos', [PhotoController::class, 'store'])->name('memorials.photos.store');
    Route::patch('photos/{photo}', [PhotoController::class, 'update'])->name('photos.update');
    Route::delete('photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');

    // Videos
    Route::post('memorials/{memorial}/videos', [VideoController::class, 'store'])->name('memorials.videos.store');
    Route::patch('videos/{video}', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');

    // Moderation
    Route::get('moderation', [DashboardController::class, 'moderation'])->name('moderation');

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

// Invitation acceptance
Route::get('/invitation/{token}/accept', [InvitationController::class, 'accept'])->middleware(['auth', 'verified'])->name('invitation.accept');

// Auth routes (must be before the slug catch-all)
require __DIR__ . '/auth.php';

// Public memorial routes (must be last — slug catch-all)
Route::get('/{memorial:slug}', [MemorialController::class, 'show'])->name('memorial.show')->middleware(\App\Http\Middleware\TrackMemorialVisit::class);
Route::get('/{slug}/gallery', [MemorialController::class, 'gallery'])->name('memorial.gallery');
Route::get('/{slug}/timeline', [MemorialController::class, 'timeline'])->name('memorial.timeline');
Route::get('/{slug}/password', [MemorialController::class, 'password'])->name('memorial.password');
Route::post('/{slug}/password', [MemorialController::class, 'verifyPassword'])->name('memorial.password.verify')->middleware('throttle:password-verify');
Route::post('/{slug}/tributes', [TributeController::class, 'store'])->name('memorial.tributes.store')->middleware(['throttle:tributes', HoneypotProtection::class]);
Route::post('/{slug}/gifts', [VirtualGiftController::class, 'store'])->name('memorial.gifts.store')->middleware(['throttle:gifts', HoneypotProtection::class]);
