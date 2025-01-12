<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FolderController;
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
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->name('tasks.update-status');


        Route::post('/tasks/{task}/documents', [TaskController::class, 'attachDocument'])
     ->name('tasks.attach_document');
Route::delete('/tasks/{task}/documents/{document}', [TaskController::class, 'detachDocument'])
     ->name('tasks.detach_document');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::post('/documents/{document}/version', [DocumentController::class, 'addVersion'])
         ->name('documents.version');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
         ->name('documents.download');

         Route::prefix('documents')->name('documents.')->group(function () {
            Route::resource('folders', FolderController::class)->only(['store', 'index']);
        });

        Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])->name('documents.preview');

});

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::resource('customers', CustomerController::class);
    });
});


require __DIR__.'/auth.php';
