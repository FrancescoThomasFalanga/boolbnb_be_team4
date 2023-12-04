<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\SponsorshipController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('apartments', ApartmentController::class)->parameters(['apartments' => 'apartment:slug']);
    Route::resource('messages', MessageController::class);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('[apartment/{apartment}/messages', [MessageController::class, 'showByApartment'])->name('messages.single');

    Route::get('sponsorships/{apartment}', [SponsorshipController::class, 'show'])->name('sponsorships.show');
    Route::post('sponsorships/{apartment}', [SponsorshipController::class, 'store'])->name('sponsorships.store');

});

require __DIR__.'/auth.php';
