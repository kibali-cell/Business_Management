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
        $query = Document::query();
        
        // If folder is specified, show documents in that folder
        if ($request->folder_id) {
            $query->where('folder_id', $request->folder_id);
        } else {
            // Only show root documents (not in any folder)
            $query->whereNull('folder_id');
        }

        // If task_id is specified, show only task documents
        if ($request->task_id) {
            $query->where('task_id', $request->task_id);
        }

        $documents = $query->with(['folder', 'uploader'])->latest()->paginate(20);
        $folders = Folder::whereNull('parent_id')->with('children')->get();

        return view('documents.index', compact('documents', 'folders'));
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
        
        // Store the file
        $path = $file->store('documents/' . date('Y/m'), 'public');

        $document = Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
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
    
    return view('documents.preview', compact('document', 'previewType'));
}


}