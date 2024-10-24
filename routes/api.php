<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
// Book
Route::get('books', [BookController::class, 'index']);
Route::get('books/{id}', [BookController::class, 'show']);
Route::post('books', [BookController::class, 'store']);
Route::put('books/{id}', [BookController::class, 'update']);
Route::delete('books/{id}', [BookController::class, 'destroy']);
Route::get('books/search/{title}', [BookController::class, 'search']);
Route::get('books/filter/{author}', [BookController::class, 'filter']);

// User
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'Delete']);
Route::get('users/search/{name}', [UserController::class, 'search']);
Route::get('users/filter/{email}', [UserController::class, 'filter']);

// Payment
Route::post('payments', [PaymentController::class, 'createPayment']);
Route::post('payments/{id}/success', [PaymentController::class, 'successPayment']);
Route::post('payments/{id}/cancel', [PaymentController::class, 'cancelPayment']);
