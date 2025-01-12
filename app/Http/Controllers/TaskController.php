<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Folder;
use Illuminate\Http\Request;

use App\Notifications\TaskUpdatedNotification;


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
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $task->update($validated);

        // Send notification to assigned user
        $task->assignee->notify(new TaskUpdatedNotification($task));

        // Handle document uploads if any
    if ($request->hasFile('documents')) {
        foreach ($request->file('documents') as $file) {
            $path = $file->store('task-documents', 'public');
            $task->documents()->create([
                'filename' => $file->getClientOriginalName(),
                'path' => $path
            ]);
        }
    }

        return response()->json(['success' => true, 'task' => $task->fresh()->load('assignee')]);
    }

        public function attachDocument(Task $task, Request $request)
    {
        $validated = $request->validate(['document_id' => 'required|exists:documents,id']);
        $task->documents()->attach($validated['document_id']);
        return back()->with('success', 'Document attached successfully');
    }

    public function detachDocument(Task $task, Document $document)
    {
        $task->documents()->detach($document->id);
        return back()->with('success', 'Document detached successfully');
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