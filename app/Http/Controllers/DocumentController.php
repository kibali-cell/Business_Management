<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'task_id' => 'required|exists:tasks,id'
        ]);

        $path = $request->file('file')->store('task-documents', 'public');

        $document = Document::create([
            'task_id' => $request->task_id,
            'filename' => $request->file('file')->getClientOriginalName(),
            'path' => $path,
            'uploaded_by' => auth()->id()
        ]);

        return response()->json($document);
    }

    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->path);
        $document->delete();

        return response()->json(['success' => true]);
    }
}
