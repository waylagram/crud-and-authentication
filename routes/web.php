<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;


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
// User
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register-user', [AuthController::class, 'registerUser'])->name('register.user');
Route::post('/login-user', [AuthController::class, 'loginUser'])->name('login.user');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/password-request', [AuthController::class, 'passwordRequest'])->name('password.request');
Route::post('/password-email', [AuthController::class, 'passwordEmail'])->name('password.email');
Route::get('/password-reset', [AuthController::class, 'passwordReset'])->name('password.reset');
Route::post('/password-update', [AuthController::class, 'passwordUpdate'])->name('password.update');

//POST
Route::get('/', [PostController::class, 'allPosts'])->name('all.posts');
Route::get('/home', [PostController::class, 'allPosts'])->name('all.posts');
Route::get('/create-post', [PostController::class, 'createPost'])->name('create.post')->middleware('auth');
Route::post('/submit-post', [PostController::class, 'submitPost'])->name('submit.post')->middleware('auth');
Route::get('/single-post/{id}', [PostController::class, 'singlePost'])->name('single.post')->middleware('auth');
Route::get('/edit-post/{id}', [PostController::class, 'editPost'])->name('edit.post')->middleware('auth');
Route::put('/update-post/{id}', [PostController::class, 'updatePost'])->name('update.post')->middleware('auth');
Route::delete('/delete-post/{id}', [PostController::class, 'deletePost'])->name('delete.post')->middleware('auth');

// Comment
Route::post('/comment/{post_id}', [CommentController::class, 'comment'])->name('comment')->middleware('auth');

//Email Verification
// Route::get('/email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify')->middleware('auth');
// Route::get('/email/resend/', [AuthController::class, 'resend'])->name('verification.resend')->middleware('auth');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::delete('/deactivate', [AuthController::class, 'deactivate'])->name('deactivate')->middleware('auth');
