<?php

use App\Http\Controllers\LoginInjectionLabController;
use App\Http\Controllers\DatabaseVersionLabController;
use App\Http\Controllers\ColumnCountLabController;
use App\Http\Controllers\ColumnTextLabController;
use App\Http\Controllers\MultipleValuesSingleColumnLabController;
use App\Http\Controllers\OracleVersionLabController;
use App\Http\Controllers\TableDataLabController;
use App\Http\Controllers\ProductLabController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockUnionLabController;
use App\Http\Controllers\UserTableUnionLabController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('labs/instructions', 'labs.instructions')
    ->name('labs.instructions');

Route::get('labs/sql-injection', ProductLabController::class)
    ->name('labs.sql-injection');
Route::view('labs/sql-injection/instructions', 'labs.sql-injection-instructions')
    ->name('labs.sql-injection.instructions');

Route::get('labs/sql-injection-login', [LoginInjectionLabController::class, 'show'])
    ->name('labs.sql-injection-login');
Route::view('labs/sql-injection-login/instructions', 'labs.sql-injection-login-instructions')
    ->name('labs.sql-injection-login.instructions');
Route::post('labs/sql-injection-login', [LoginInjectionLabController::class, 'login'])
    ->name('labs.sql-injection-login.attempt');
Route::post('labs/sql-injection-login/logout', [LoginInjectionLabController::class, 'logout'])
    ->name('labs.sql-injection-login.logout');

Route::get('labs/sql-injection-stock-union', [StockUnionLabController::class, 'show'])
    ->name('labs.sql-injection-stock-union');
Route::post('labs/sql-injection-stock-union/check', [StockUnionLabController::class, 'check'])
    ->name('labs.sql-injection-stock-union.check');
Route::post('labs/sql-injection-stock-union/login', [StockUnionLabController::class, 'login'])
    ->name('labs.sql-injection-stock-union.login');
Route::post('labs/sql-injection-stock-union/logout', [StockUnionLabController::class, 'logout'])
    ->name('labs.sql-injection-stock-union.logout');
Route::view('labs/sql-injection-stock-union/instructions', 'labs.sql-injection-stock-union-instructions')
    ->name('labs.sql-injection-stock-union.instructions');

Route::get('labs/sql-injection-blind-conditional', [\App\Http\Controllers\BlindConditionalLabController::class, 'show'])
    ->name('labs.sql-injection-blind-conditional');
Route::post('labs/sql-injection-blind-conditional/set-tracking', [\App\Http\Controllers\BlindConditionalLabController::class, 'setTracking'])
    ->name('labs.sql-injection-blind-conditional.set_tracking');
Route::post('labs/sql-injection-blind-conditional/login', [\App\Http\Controllers\BlindConditionalLabController::class, 'login'])
    ->name('labs.sql-injection-blind-conditional.login');
Route::post('labs/sql-injection-blind-conditional/logout', [\App\Http\Controllers\BlindConditionalLabController::class, 'logout'])
    ->name('labs.sql-injection-blind-conditional.logout');
Route::view('labs/sql-injection-blind-conditional/instructions', 'labs.sql-injection-blind-conditional-instructions')
    ->name('labs.sql-injection-blind-conditional.instructions');

Route::get('labs/sql-injection-oracle-version', OracleVersionLabController::class)
    ->name('labs.sql-injection-oracle-version');
Route::view('labs/sql-injection-oracle-version/instructions', 'labs.sql-injection-oracle-version-instructions')
    ->name('labs.sql-injection-oracle-version.instructions');

Route::get('labs/sql-injection-version', DatabaseVersionLabController::class)
    ->name('labs.sql-injection-version');
Route::view('labs/sql-injection-version/instructions', 'labs.sql-injection-version-instructions')
    ->name('labs.sql-injection-version.instructions');

Route::get('labs/sql-injection-user-table', [UserTableUnionLabController::class, 'show'])
    ->name('labs.sql-injection-user-table');
Route::post('labs/sql-injection-user-table/login', [UserTableUnionLabController::class, 'login'])
    ->name('labs.sql-injection-user-table.login');
Route::post('labs/sql-injection-user-table/logout', [UserTableUnionLabController::class, 'logout'])
    ->name('labs.sql-injection-user-table.logout');
Route::view('labs/sql-injection-user-table/instructions', 'labs.sql-injection-user-table-instructions')
    ->name('labs.sql-injection-user-table.instructions');

Route::get('labs/sql-injection-column-count', ColumnCountLabController::class)
    ->name('labs.sql-injection-column-count');
Route::view('labs/sql-injection-column-count/instructions', 'labs.sql-injection-column-count-instructions')
    ->name('labs.sql-injection-column-count.instructions');

Route::get('labs/sql-injection-column-text', ColumnTextLabController::class)
    ->name('labs.sql-injection-column-text');
Route::view('labs/sql-injection-column-text/instructions', 'labs.sql-injection-column-text-instructions')
    ->name('labs.sql-injection-column-text.instructions');

Route::get('labs/sql-injection-table-data', [TableDataLabController::class, 'show'])
    ->name('labs.sql-injection-table-data');
Route::post('labs/sql-injection-table-data/login', [TableDataLabController::class, 'login'])
    ->name('labs.sql-injection-table-data.login');
Route::post('labs/sql-injection-table-data/logout', [TableDataLabController::class, 'logout'])
    ->name('labs.sql-injection-table-data.logout');
Route::view('labs/sql-injection-table-data/instructions', 'labs.sql-injection-table-data-instructions')
    ->name('labs.sql-injection-table-data.instructions');

Route::get('labs/sql-injection-multiple-values', [MultipleValuesSingleColumnLabController::class, 'show'])
    ->name('labs.sql-injection-multiple-values');
Route::post('labs/sql-injection-multiple-values/login', [MultipleValuesSingleColumnLabController::class, 'login'])
    ->name('labs.sql-injection-multiple-values.login');
Route::post('labs/sql-injection-multiple-values/logout', [MultipleValuesSingleColumnLabController::class, 'logout'])
    ->name('labs.sql-injection-multiple-values.logout');
Route::view('labs/sql-injection-multiple-values/instructions', 'labs.sql-injection-multiple-values-instructions')
    ->name('labs.sql-injection-multiple-values.instructions');

Route::middleware(['auth'])->group(function () {
    Route::get('labs/solutions', function () {
        if (auth()->id() !== 1) {
            abort(403, 'Рішення лабораторних доступні лише авторизованому користувачу з ID 1.');
        }

        return view('labs.solutions');
    })->name('labs.solutions');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::post('dashboard/labs/{labKey}/reset', [DashboardController::class, 'resetLab'])->name('dashboard.lab.reset');
});

require __DIR__.'/settings.php';
