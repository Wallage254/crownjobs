<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/test', function() {
    try {
        DB::connection()->getPdo();
        return 'Laravel is working! Database connection: Connected';
    } catch (Exception $e) {
        return 'Laravel is working! Database connection: Failed - ' . $e->getMessage();
    }
})->name('test');

Route::get('/create-admin', function() {
    $admin = \App\Models\User::firstOrCreate([
        'email' => 'admin@crownopportunities.com'
    ], [
        'name' => 'Admin',
        'password' => \Hash::make('admin123'),
        'email_verified_at' => now()
    ]);

    return response()->json([
        'message' => 'Default admin created successfully',
        'email' => 'admin@crownopportunities.com', 
        'password' => 'admin123'
    ]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [HomeController::class, 'jobs'])->name('jobs');
Route::get('/jobs/{id}', [HomeController::class, 'jobDetail'])->name('job.detail');
Route::get('/admin/login', function() { return view('admin-login'); })->name('admin.login');
Route::get('/admin', [HomeController::class, 'admin'])->name('admin');

// Handle client-side routing - catch all other routes and return the home view
Route::fallback([HomeController::class, 'index']);