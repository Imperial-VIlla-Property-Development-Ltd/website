<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\PageController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| PUBLIC WEBSITE ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/estates', [PageController::class, 'estates'])->name('estates');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [EnquiryController::class, 'store'])->name('contact.submit');
Route::get('/thank-you', [PageController::class, 'thankyou'])->name('thankyou');
Route::get('/coming-soon',[PageController::class,'coming'])->name('coming-son');
Route::view('/terms-and-conditions', 'pages.terms')->name('terms');
