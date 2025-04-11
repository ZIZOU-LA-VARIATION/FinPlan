<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\FinancialGoalController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentReminderController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\SavingGoalController;
use App\Http\Controllers\TransactionController;
use App\Models\Activity;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


Route::get('transaction', function () {
    return view('user.transactions');
})->name('transactions');

Route::get('budget', function () {
    return view('user.budgets');
})->name('budgets');

Route::get('invioce', function () {
    return view('user.invioces');
})->name('invioces');








Route::middleware(['auth'])->group(function () {
    Route::resource('accounts', AccountController::class);
    Route::resource('transactions', TransactionController::class)->middleware('auth');
    // Route::resource('budgets', BudgetController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('savings', SavingController::class)->middleware('auth');

    Route::resource('investments', InvestmentController::class)->middleware('auth');
    Route::resource('financial_goals', FinancialGoalController::class)->middleware('auth');;
    Route::resource('debts', DebtController::class);
    // Route::resource('payment-reminders', PaymentReminderController::class);
    // Route::resource('invoices', InvoiceController::class);
});
