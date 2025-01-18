<?php
use App\Http\Controllers\{
    AccountController,
    InvoiceController,
    TransactionController,
    DashboardController,
    DocumentController,
    TaskController,
    CustomerController,
    ProfileController,
    FolderController,
    ReportController,
    BudgetController,
    BankAccountController,
    CurrencyController
};
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', fn() => view('welcome'));
Route::get('/dashboard', fn() => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Task Management
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
        Route::patch('/{task}/status', [TaskController::class, 'updateStatus'])->name('update-status');
        Route::post('/{task}/documents', [TaskController::class, 'attachDocument'])->name('attach_document');
        Route::delete('/{task}/documents/{document}', [TaskController::class, 'detachDocument'])->name('detach_document');
    });

    // Document Management
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::post('/', [DocumentController::class, 'store'])->name('store');
        Route::post('/{document}/version', [DocumentController::class, 'addVersion'])->name('version');
        Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
        Route::get('/{document}/preview', [DocumentController::class, 'preview'])->name('preview');
        Route::delete('/{id}', [DocumentController::class, 'destroy'])->name('destroy');
        Route::resource('folders', FolderController::class)->only(['store', 'index']);
    });

    // Resource Management
    Route::resources([
        'accounts' => AccountController::class,
        'transactions' => TransactionController::class,
        'invoices' => InvoiceController::class,
        'budgets' => BudgetController::class,
        'bank-accounts' => BankAccountController::class
    ]);

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profit-loss');
        Route::get('/balance-sheet', [ReportController::class, 'balanceSheet'])->name('balance-sheet');
        Route::get('/cash-flow', [ReportController::class, 'cashFlow'])->name('cash-flow');
        Route::get('/export-balance-sheet', [ReportController::class, 'exportBalanceSheet'])->name('export-balance-sheet');
    });

    // Budget Management
    Route::post('/budgets/{budget}/track', [BudgetController::class, 'track'])->name('budgets.track');

    // Bank Account Operations
    Route::prefix('bank-accounts')->name('bank-accounts.')->group(function () {
        Route::post('/{account}/deposit', [BankAccountController::class, 'deposit'])->name('deposit');
        Route::post('/{account}/withdraw', [BankAccountController::class, 'withdraw'])->name('withdraw');
        Route::post('/{account}/sync', [BankAccountController::class, 'sync'])->name('sync');
    });

    // Currency Management
    Route::prefix('currency')->name('currency.')->group(function () {
        Route::get('/', [CurrencyController::class, 'index'])->name('index');
        Route::post('/convert', [CurrencyController::class, 'convert'])->name('convert');
    });

    // CRM
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::resource('customers', CustomerController::class);
    });
});

require __DIR__.'/auth.php';
