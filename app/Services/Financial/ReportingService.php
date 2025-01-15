<?php
namespace App\Services\Financial;

use App\Models\Transaction;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportingService
{
    public function generateProfitLossReport($startDate, $endDate)
    {
        $revenue = Transaction::where('type', 'revenue')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $expenses = Transaction::where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $netIncome = $revenue - $expenses;

        return [
            'revenue' => $revenue,
            'expenses' => $expenses,
            'net_income' => $netIncome,
            'period' => [
                'start' => $startDate,
                'end' => $endDate
            ]
        ];
    }

    public function generateBalanceSheet()
    {
        $assets = Account::where('type', 'asset')->sum('balance');
        $liabilities = Account::where('type', 'liability')->sum('balance');
        $equity = $assets - $liabilities;

        return [
            'assets' => $assets,
            'liabilities' => $liabilities,
            'equity' => $equity,
            'generated_at' => now()
        ];
    }

    public function generateCashFlowReport($startDate, $endDate)
    {
        $operatingCashFlow = Transaction::where('type', 'operating')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $investingCashFlow = Transaction::where('type', 'investing')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $financingCashFlow = Transaction::where('type', 'financing')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        return [
            'operating' => $operatingCashFlow,
            'investing' => $investingCashFlow,
            'financing' => $financingCashFlow,
            'net_cash_flow' => $operatingCashFlow + $investingCashFlow + $financingCashFlow
        ];
    }
}