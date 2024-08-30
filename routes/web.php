<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\QuestionsController;


Route::middleware(['auth'])->get('/admin/data', [AdminController::class, 'getAdminData']);
Route::middleware(['auth'])->post('/get_users', [AdminController::class, 'getUsers']);
Route::middleware(['auth'])->post('/update_user_status', [AdminController::class, 'update_user_status']);
Route::middleware(['auth'])->post('/add_question', [QuestionsController::class, 'add_question']);
Route::middleware(['auth'])->get('/get_questions', [QuestionsController::class, 'get_questions']);
Route::middleware(['auth'])->get('/get_question/{id}', [QuestionsController::class, 'get_question']);
Route::middleware(['auth'])->post('/add_option', [QuestionsController::class, 'add_option']);
Route::middleware(['auth'])->post('/edit_option', [QuestionsController::class, 'edit_option']);
Route::middleware(['auth'])->post('/delete_option', [QuestionsController::class, 'delete_option']);



Route::post('/update-profile', [UserController::class, 'updateProfile']);
Route::post('/update-profile-avatar', [UserController::class, 'updateProfileAvatar']);


Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('/auth/google/call-back', [GoogleAuthController::class, 'callBackGoogle'])->name('callBackGoogle');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/check-user', [LoginController::class, 'check_user']);


// Vue.js 
Route::get('/{pathMatch}', function () {
    return view('welcome');
})->where('pathMatch', '.*');

Route::get('/', function () {
    return view('welcome');
});







