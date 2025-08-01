<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;

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

// Job routes
Route::apiResource('jobs', JobController::class);

// Application routes
Route::apiResource('applications', ApplicationController::class);

// Testimonial routes
Route::apiResource('testimonials', TestimonialController::class);

// Category routes
Route::apiResource('categories', CategoryController::class);

// Message routes (Contact form)
Route::apiResource('messages', MessageController::class);

// Public routes that don't require authentication
Route::get('/jobs/search', [JobController::class, 'index']);
Route::get('/testimonials/active', [TestimonialController::class, 'index']);
Route::get('/categories/active', [CategoryController::class, 'index']);
