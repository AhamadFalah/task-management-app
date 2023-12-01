<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/q', function () {
    return view('qlw');
})->name('q');

Route::get('/home',[HomeController::class,'index'])->middleware('auth')->name('home');

Route::get('/addtask', [TaskController::class,'add'])->middleware(['auth','admin'])->name('addtask');

Route::get('/task/create', [TaskController::class, 'create'])->middleware(['auth','admin'])->name('tasks.create');

Route::post('/task/store', [TaskController::class, 'store'])->middleware(['auth','admin'])->name('task.store');

Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->middleware(['auth','admin'])->name('editTask');

Route::delete('/tasks/{id}/delete', [TaskController::class, 'deleteTask'])->middleware(['auth','admin'])->name('deleteTask');

Route::put('/tasks/{id}/update', [TaskController::class, 'update'])->name('updateTask');

Route::get('/tasks/{id}/update', [TaskController::class, 'updateTask'])->name('updateTaskUser');

Route::post('/logout',[HomeController::class,'logout'])->name('logout');



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
