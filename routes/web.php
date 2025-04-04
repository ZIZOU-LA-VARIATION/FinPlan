<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\FinancialGoalController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentReminderController;
use App\Http\Controllers\SavingGoalController;
use App\Http\Controllers\TransactionController;
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

Route::get('debt', function () {
    return view('user.debts');
})->name('debts');

Route::get('finacial_goal', function () {
    return view('user.finacial_goal');
})->name('finacial_goal');

Route::get('investisments', function () {
    return view('user.investisments');
})->name('investisments');

Route::get('invioce', function () {
    return view('user.invioces');
})->name('invioces');

Route::get('saving', function () {
    return view('user.savings');
})->name('savings');






Route::middleware(['auth'])->group(function () {
    Route::resource('accounts', AccountController::class);
    // Route::resource('transactions', TransactionController::class);
    // Route::resource('budgets', BudgetController::class);
    // Route::resource('categories', CategoryController::class);
    // Route::resource('saving-goals', SavingGoalController::class);
    // Route::resource('investments', InvestmentController::class);
    // Route::resource('financial-goals', FinancialGoalController::class);
    // Route::resource('debts', DebtController::class);
    // Route::resource('payment-reminders', PaymentReminderController::class);
    // Route::resource('invoices', InvoiceController::class);
});
