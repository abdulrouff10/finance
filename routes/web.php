<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect('/admin');
});


// Tambahkan di luar, bukan di dalam fungsi route lain
Route::get('/admin/transactions/report-pdf', [ReportController::class, 'pdf'])->name('transactions.report.pdf');
