<?php

use App\Http\Controllers\API\ApiFilmController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CastController;
use App\Http\Controllers\API\CastMovieController;
use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('/v1')->group(function(){
    // Route::post("/movie", [ApiFilmController::class, 'store']);
    Route::apiResource('cast', CastController::class);
    Route::apiResource('genre', GenreController::class);
    Route::apiResource('movie', MovieController::class);
    Route::apiResource('cast_movie', CastMovieController::class);
    Route::apiResource('role', RoleController::class)->middleware(['auth:api', 'UserAdmin']);
    Route::apiResource('profile', ProfileController::class)->middleware(['auth:api', 'UserVerified']);
    Route::apiResource('review', ReviewController::class)->middleware(['auth:api', 'UserVerified']); 
    Route::prefix('auth')->group(function(){
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('/generate-otp', [AuthController::class, 'generateOtp'])->middleware('auth:api');
        Route::post('/verifikasi-akun', [AuthController::class, 'verifikasi'])->middleware('auth:api');
    });
    Route::get('/me', [AuthController::class, 'getUser'])->middleware('auth:api');
    Route::post('/update-user', [AuthController::class, 'update'])->middleware(['auth:api', 'UserVerified']);
});