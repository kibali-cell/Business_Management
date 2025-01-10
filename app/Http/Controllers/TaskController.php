<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['assignee', 'creator'])->get();
        $users = User::all(); // For the assign to dropdown
        return view('tasks.index', compact('tasks', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date'
        ]);

        $validated['created_by'] = auth()->id();

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        $task->update($validated);

        return response()->json(['success' => true]);
    }

    
    public function edit(Task $task)
    {
        return response()->json($task->load('assignee'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date'
        ]);

        $task->update($validated);

        // Send notification to assigned user
        $task->assignee->notify(new TaskUpdatedNotification($task));

        return response()->json(['success' => true, 'task' => $task->fresh()->load('assignee')]);
    }

    
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}