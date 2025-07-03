<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    //
    public function pdf(Request $request)
    {
        $start = $request->start ?? now()->startOfMonth()->toDateString();
        $end = $request->end ?? now()->endOfMonth()->toDateString();
    
        $transactions = Transaction::with('category')
            ->whereBetween('date_transaction', [$start, $end])
            ->get();
    
        return Pdf::loadView('pdf.transactions', compact('transactions', 'start', 'end'))
            ->stream('laporan-transaksi.pdf');
    }
}
