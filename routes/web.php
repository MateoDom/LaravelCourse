<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// All listings
Route::get('/', [ListingController::class, 'index']);

// Show Create Form
Route::get('/listings/create',[ListingController::class, 'create'])->middleware('auth');

// Store Listing
Route::post('/listings',[ListingController::class, 'store'])->middleware('auth');;

Route::get('/listings/manage',[ListingController::class, 'manage'])->middleware('auth');

// Edit Listing
Route::get('/listings/{listing}/edit',[ListingController::class, 'edit'])->middleware('auth');;


// Edit Submit
Route::put('/listings/{listing}',[ListingController::class, 'update'])->middleware('auth');;

Route::delete('/listings/{listing}',[ListingController::class, 'destroy'])->middleware('auth');;

// Single Listing
Route::get('/listings/{listing}',[ListingController::class, 'show']);

// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');;
// Post new User
Route::post('/users', [UserController::class, 'store']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');;

Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');;
Route::post('/users/authenticate', [UserController::class, 'authenticate']);