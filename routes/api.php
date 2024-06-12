<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorTicketsController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tickets', TicketController::class)->except(['update']);
    Route::put('tickets/{ticket}', [TicketController::class,'replace']);
    Route::patch('tickets/{ticket}', [TicketController::class,'replace']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('users.tickets', AuthorTicketsController::class);
    Route::put('users/{author}/tickets/{ticket}', [AuthorTicketsController::class,'replace']);
    Route::patch('users/{author}/tickets/{ticket}', [AuthorTicketsController::class,'replace']);
});



// Route::middleware('auth:sanctum')->controller(TicketController::class)->group(function(){
//     Route::get('/tickets','index')->name('tickets');
//     Route::get('/tickets/{id}','show')->name('tickets.show');
// });
