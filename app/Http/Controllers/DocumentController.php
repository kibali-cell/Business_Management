<?php
namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Folder;
use App\Models\DocumentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        // Get all root folders with their children and document counts
        $folders = Folder::withCount('documents')
            ->whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->withCount('documents');
            }])
            ->orderBy('name')
            ->get();

        // Get documents for current folder or root
        $query = Document::query();
        if ($request->has('folder')) {
            $query->where('folder_id', $request->folder);
            $currentFolder = Folder::findOrFail($request->folder);
        } else {
            $currentFolder = null;
            $query->whereNull('folder_id');
        }
        
        $documents = $query->latest()->paginate(15);

        return view('documents.index', compact('folders', 'documents', 'currentFolder'));
    }

    
    public function create()
    {
        $folders = Folder::all(); // You'll need to create the Folder model
        return view('documents.create', compact('folders'));
    }

    public function store(Request $request)
{
    $request->validate([
        'file' => 'required|file|max:10240', // 10MB max
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'folder_id' => 'nullable|exists:folders,id',
        'task_id' => 'nullable|exists:tasks,id'
    ]);

    $file = $request->file('file');
    $fileSize = $file->getSize();  // Get the file size

    // Store the file and get the path
    $path = Storage::disk('public')->putFile('documents/' . date('Y/m'), $file);

    // For debugging, verify the file exists immediately after upload
    if (!Storage::disk('public')->exists($path)) {
        return back()->with('error', 'File upload failed - could not verify file existence');
    }

    // Store the document
    $document = Document::create([
        'title' => $request->title,
        'description' => $request->description,
        'filename' => $file->getClientOriginalName(),
        'path' => $path,
        'file_type' => $file->getClientMimeType(),
        'file_size' => $fileSize,  // Ensure file_size is set
        'folder_id' => $request->folder_id,
        'task_id' => $request->task_id,
        'uploaded_by' => auth()->id(),
        'version' => 1
    ]);

    return back()->with('success', 'Document uploaded successfully');
}

    

    public function addVersion(Request $request, Document $document)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'change_notes' => 'required|string'
        ]);

        $file = $request->file('file');
        $path = $file->store('documents/' . date('Y/m'), 'public');

        // Create version record
        DocumentVersion::create([
            'document_id' => $document->id,
            'version_number' => $document->version + 1,
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'file_size' => $file->getSize(),
            'uploaded_by' => auth()->id(),
            'change_notes' => $request->change_notes
        ]);

        // Update document version
        $document->increment('version');

        return back()->with('success', 'New version uploaded successfully');
    }

    public function download(Document $document)
    {
        // Check access
        if (!$document->is_public && $document->uploaded_by !== auth()->id()) {
            abort(403);
        }

        return Storage::disk('public')->download($document->path, $document->filename);
    }

    private function getPreviewType($extension)
{
    return match(strtolower($extension)) {
        'pdf' => 'pdf',
        'jpg', 'jpeg', 'png', 'gif' => 'image',
        'doc', 'docx' => 'office',
        'txt', 'md' => 'text',
        default => 'download'
    };
}

public function preview(Document $document)
{
    $fileExtension = pathinfo($document->path, PATHINFO_EXTENSION);
    $previewType = $this->getPreviewType($fileExtension);
    
    // Add debugging
    $exists = Storage::disk('public')->exists($document->path);
    $fullPath = Storage::disk('public')->path($document->path);
    
    return view('documents.preview', compact('document', 'previewType', 'exists', 'fullPath'));
}

public function destroy($id)
{
    $document = Document::findOrFail($id);
    Storage::delete($document->path); // Deletes the file
    $document->delete(); // Deletes the record

    return response()->json(['success' => true]);
}


}