<?php

namespace App\Http\Controllers;

use App\Services\Financial\BudgetService;

use Illuminate\Http\Request;

class BudgetController extends Controller
{
    //
    protected $budgetService;

    public function __construct(BudgetService $budgetService)
    {
        $this->budgetService = $budgetService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $budget = $this->budgetService->createBudget($validated);

        return redirect()->back()->with('success', 'Budget created successfully');
    }

    public function track($id)
    {
        $budget = Budget::findOrFail($id);
        $trackedBudget = $this->budgetService->trackBudget($budget);

        return response()->json($trackedBudget);
    }
}
