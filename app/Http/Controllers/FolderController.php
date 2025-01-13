<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FolderController extends Controller
{
    public function index()
    {
        // Fetch root folders with their children
        // $rootFolders = Folder::with('children')
        //     ->whereNull('parent_id')
        //     ->orderBy('name')
        //     ->get();

            // Fetch all folders with their children
    $allFolders = Folder::with('children')
    ->orderBy('name')
    ->get();

return view('folders.index', compact('allFolders'));

        // return view('folders.index', compact('rootFolders'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:folders,id'
        ]);

        // Create a new folder
        $folder = Folder::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return response()->json([
            'success' => true,
            'folder' => $folder
        ]);
    }

    public function update(Request $request, Folder $folder)
    {
        // Validate the folder name
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Update the folder's name and path
        $oldPath = $folder->path;
        $folder->name = $request->name;
        $folder->slug = Str::slug($request->name);
        
        if ($folder->parent_id) {
            $parent = Folder::find($folder->parent_id);
            $folder->path = $parent->path . '/' . $folder->slug;
        } else {
            $folder->path = $folder->slug;
        }
        
        $folder->save();

        // Update the paths of all children
        if ($folder->children->count() > 0) {
            foreach ($folder->children as $child) {
                $child->path = str_replace($oldPath, $folder->path, $child->path);
                $child->save();
            }
        }

        return response()->json([
            'success' => true,
            'folder' => $folder
        ]);
    }

    public function destroy(Folder $folder)
    {
        // Cascade delete all children folders and move documents to the root
        Document::where('folder_id', $folder->id)
            ->update(['folder_id' => null]);

        // Delete the folder
        $folder->delete();

        return response()->json(['success' => true]);
    }
}
