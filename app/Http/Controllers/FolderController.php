<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:folders,id'
        ]);

        $folder = Folder::create([
            'name' => $validated['name'],
            'parent_id' => $validated['parent_id'],
            'created_by' => auth()->id()
        ]);

        return back()->with('success', 'Folder created successfully');
    }

    public function getFolderTree()
    {
        $folders = Folder::whereNull('parent_id')
            ->with('children.children') // Load nested folders
            ->get();

        return response()->json($folders);
    }

    public function index()
{
    $folders = Folder::all(); // Example: Retrieve all folders
    return response()->json($folders);
}

}
