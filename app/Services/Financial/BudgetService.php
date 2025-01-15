<?php
namespace App\Services\Financial;

use App\Models\Budget;
use App\Models\Transaction;
use Carbon\Carbon;

class BudgetService
{
    public function createBudget(array $data)
    {
        return Budget::create($data);
    }

    public function trackBudget(Budget $budget)
    {
        $actualAmount = Transaction::where('category', $budget->category)
            ->whereBetween('date', [$budget->start_date, $budget->end_date])
            ->sum('amount');

        $budget->update([
            'actual_amount' => $actualAmount,
            'status' => $this->calculateBudgetStatus($budget->amount, $actualAmount)
        ]);

        return $budget;
    }

    private function calculateBudgetStatus($budgeted, $actual)
    {
        $percentage = ($actual / $budgeted) * 100;
        
        if ($percentage > 90) return 'danger';
        if ($percentage > 75) return 'warning';
        return 'good';
    }

    public function getBudgetAlerts()
    {
        return Budget::where('status', 'danger')
            ->orWhere('status', 'warning')
            ->get();
    }
}