<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('assignee')->get();
        $users = User::all();
        return view('tasks.index', compact('tasks', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'status' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function updateStatus(Request $request)
    {
        $task = Task::findOrFail($request->taskId);
        $task->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }
}