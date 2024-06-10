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
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth:sanctum')->apiResource('tickets',TicketController::class);
Route::middleware('auth:sanctum')->apiResource('users',UserController::class);
Route::middleware('auth:sanctum')->apiResource('users.tickets',AuthorTicketsController::class);

// Route::middleware('auth:sanctum')->controller(TicketController::class)->group(function(){
//     Route::get('/tickets','index')->name('tickets');
//     Route::get('/tickets/{id}','show')->name('tickets.show');
// });


