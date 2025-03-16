<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MeetingRoomController;

Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'userProfile']);
Route::post('/book-meeting', [MeetingRoomController::class, 'store']);

