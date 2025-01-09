<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_customers' => Customer::count(),
            'new_leads' => Customer::where('status', 'lead')->count(),
            'pending_tasks' => Task::where('status', 'pending')->count(),
            'overdue_tasks' => Task::where('due_date', '<', now())
                                  ->where('status', '!=', 'completed')
                                  ->count()
        ];

        return view('dashboard', compact('stats'));
    }
}
