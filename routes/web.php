<?php
use App\Http\Controllers\AccountController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\CurrencyController;
// use App\Http\Controllers\FinancialController;

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
        Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])->name('documents.preview');
});

Route::middleware(['auth'])->group(function () {
    // Account routes
    Route::resource('accounts', AccountController::class);
    
    // Transaction routes
    Route::resource('transactions', TransactionController::class);
    
    // Invoice routes
    Route::resource('invoices', InvoiceController::class);

});
Route::get('accounts/{account}/download', [AccountController::class, 'download'])->name('accounts.download');

Route::post('/bank-accounts/{account}/deposit', [BankAccountController::class, 'deposit'])->name('bank-accounts.deposit');


// Route::post('/bank-accounts/{account}/deposit', [TransactionController::class, 'deposit'])->name('bank-accounts.deposit');
// Route::post('/bank-accounts/{account}/withdraw', [TransactionController::class, 'withdraw'])->name('bank-accounts.withdraw');

Route::resource('budgets', BudgetController::class);


// Route::middleware(['auth'])->group(function () {
//     // Reports
//     Route::get('/reports/profit-loss', [ReportController::class, 'profitLoss']);
//     Route::get('/reports/balance-sheet', [ReportController::class, 'balanceSheet']);
    
//     // Budgets
//     Route::resource('budgets', BudgetController::class);
//     Route::post('/budgets/{budget}/track', [BudgetController::class, 'track']);
    
//     // Bank Integration
//     Route::get('/bank-accounts', [BankAccountController::class, 'index']);
//     Route::post('/bank-accounts/sync', [BankAccountController::class, 'sync']);
    
//     // Currency
//     Route::get('/exchange-rates', [CurrencyController::class, 'rates']);
//     Route::post('/currency/convert', [CurrencyController::class, 'convert']);
// });


// routes/web.php

Route::middleware(['auth'])->group(function () {
    // Financial Dashboard
    // Route::get('/financial/dashboard', [FinancialController::class, 'dashboard'])
    //     ->name('financial.dashboard');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])
            ->name('profit-loss');
        Route::get('/balance-sheet', [ReportController::class, 'balanceSheet'])
            ->name('balance-sheet');
        Route::get('/cash-flow', [ReportController::class, 'cashFlow'])
            ->name('cash-flow');
        Route::get('/export-balance-sheet', [ReportController::class, 'exportBalanceSheet'])
            ->name('exportBalanceSheet');
    });

    

    // Budget Management
    Route::resource('budgets', BudgetController::class);
    Route::post('/budgets/{budget}/track', [BudgetController::class, 'track'])
        ->name('budgets.track');
        

    // Bank Accounts
    Route::resource('bank-accounts', BankAccountController::class);
    Route::post('/bank-accounts/{account}/deposit', [BankAccountController::class, 'deposit'])
        ->name('bank-accounts.deposit');
Route::post('/bank-accounts/{account}/withdraw', [BankAccountController::class, 'withdraw'])->name('bank-accounts.withdraw');
    Route::post('/bank-accounts/{account}/sync', [BankAccountController::class, 'sync'])
        ->name('bank-accounts.sync');

    // Currency Management
    Route::get('/currency', [CurrencyController::class, 'index'])
        ->name('currency.index');
    Route::post('/currency/convert', [CurrencyController::class, 'convert'])
        ->name('currency.convert');
});

// Route::middleware(['auth'])->group(function () {
//     Route::resource('folders', FolderController::class);
// });

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::resource('customers', CustomerController::class);
    });
});


require __DIR__.'/auth.php';