<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::resource('customers', CustomerController::class);
    });
});


require __DIR__.'/auth.php';
