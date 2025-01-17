<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\FinancialReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function profitLoss(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now());

        // Updated to use transaction_date instead of date
        $transactions = Transaction::whereBetween('transaction_date', [$startDate, $endDate])->get();
        $invoices = Invoice::whereBetween('created_at', [$startDate, $endDate])->get(); // Assuming invoices use created_at

        $data = [
            'revenue' => [
                'sales' => $invoices->where('status', 'paid')->sum('total'),
                'other_income' => $transactions->where('type', 'income')
                    ->where('category', '!=', 'sales')
                    ->sum('amount'),
            ],
            'expenses' => [
                'cost_of_goods' => $transactions->where('type', 'expense')
                    ->where('category', 'cost_of_goods')
                    ->sum('amount'),
                'operating_expenses' => $transactions->where('type', 'expense')
                    ->where('category', 'operating')
                    ->sum('amount'),
                'payroll' => $transactions->where('type', 'expense')
                    ->where('category', 'payroll')
                    ->sum('amount'),
            ],
            'period' => [
                'start' => $startDate,
                'end' => $endDate,
            ],
        ];

        $data['total_revenue'] = array_sum($data['revenue']);
        $data['total_expenses'] = array_sum($data['expenses']);
        $data['net_profit'] = $data['total_revenue'] - $data['total_expenses'];

        return view('financial.reports.profit-loss', compact('data'));
    }

    public function cashFlow(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now());

        // Updated to use transaction_date instead of date
        $transactions = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->orderBy('transaction_date')
            ->get();

        $data = [
            'operating_activities' => [
                'inflows' => [
                    'customer_payments' => $transactions->where('type', 'income')
                        ->where('category', 'sales')
                        ->sum('amount'),
                    'other_receipts' => $transactions->where('type', 'income')
                        ->where('category', '!=', 'sales')
                        ->sum('amount'),
                ],
                'outflows' => [
                    'supplier_payments' => $transactions->where('type', 'expense')
                        ->where('category', 'supplier')
                        ->sum('amount'),
                    'operating_expenses' => $transactions->where('type', 'expense')
                        ->where('category', 'operating')
                        ->sum('amount'),
                ],
            ],
            'period' => [
                'start' => $startDate,
                'end' => $endDate,
            ],
        ];

        $data['net_operating_cash'] = array_sum($data['operating_activities']['inflows']) - 
                                    array_sum($data['operating_activities']['outflows']);

        return view('financial.reports.cash-flow', compact('data'));
    }

    public function balanceSheet(Request $request)
    {
        $asOfDate = $request->get('as_of_date', Carbon::now());

        // Updated to use transaction_date instead of date
        $data = [
            'assets' => [
                'current_assets' => [
                    'cash' => Account::where('type', 'cash')
                        ->sum('balance'),
                    'accounts_receivable' => Invoice::where('status', 'unpaid')
                        ->sum('total'),
                    'inventory' => Account::where('type', 'inventory')
                        ->sum('balance'),
                ],
                'fixed_assets' => [
                    'equipment' => Account::where('type', 'equipment')
                        ->sum('balance'),
                    'buildings' => Account::where('type', 'building')
                        ->sum('balance'),
                ],
            ],
            'liabilities' => [
                'current_liabilities' => [
                    'accounts_payable' => Transaction::where('type', 'expense')
                        ->where('status', 'unpaid')
                        ->where('transaction_date', '<=', $asOfDate)
                        ->sum('amount'),
                ],
                'long_term_liabilities' => [
                    'loans' => Account::where('type', 'loan')
                        ->sum('balance'),
                ],
            ],
            'as_of_date' => $asOfDate,
        ];

        $data['total_assets'] = array_sum(array_map('array_sum', $data['assets']));
        $data['total_liabilities'] = array_sum(array_map('array_sum', $data['liabilities']));
        $data['equity'] = $data['total_assets'] - $data['total_liabilities'];

        return view('financial.reports.balance-sheet', compact('data'));
    }

    public function exportBalanceSheet(Request $request)
    {
        $asOfDate = $request->get('as_of_date', Carbon::now());
        
        // Reuse the same logic from balanceSheet method
        $data = [/* ... same as balanceSheet method ... */
        
            'assets' => [
                'current_assets' => [
                    'cash' => Account::where('type', 'cash')
                        ->sum('balance'),
                    'accounts_receivable' => Invoice::where('status', 'unpaid')
                        ->sum('total'),
                    'inventory' => Account::where('type', 'inventory')
                        ->sum('balance'),
                ],
                'fixed_assets' => [
                    'equipment' => Account::where('type', 'equipment')
                        ->sum('balance'),
                    'buildings' => Account::where('type', 'building')
                        ->sum('balance'),
                ],
            ],
            'liabilities' => [
                'current_liabilities' => [
                    'accounts_payable' => Transaction::where('type', 'expense')
                        ->where('status', 'unpaid')
                        ->where('transaction_date', '<=', $asOfDate)
                        ->sum('amount'),
                ],
                'long_term_liabilities' => [
                    'loans' => Account::where('type', 'loan')
                        ->sum('balance'),
                ],
            ],
            'as_of_date' => $asOfDate,
        
        ];
        
        $pdf = PDF::loadView('financial.reports.balance-sheet-pdf', compact('data'));
        
        return $pdf->download('balance-sheet.pdf');
    }
}
