@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Folders</h1>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newFolderModal">
                New Folder
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @if($allFolders->count() > 0)
                        <div class="list-group">
                            @foreach($allFolders as $folder)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        {!! str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $folder->level) !!}
                                        <i class="bi bi-folder-fill me-2"></i>
                                        {{ $folder->name }}
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary edit-folder" 
                                                data-folder-id="{{ $folder->id }}" 
                                                data-folder-name="{{ $folder->name }}">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-folder" 
                                                data-folder-id="{{ $folder->id }}">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-muted my-5">No folders created yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Folder Modal -->
<div class="modal fade" id="newFolderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="newFolderForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Folder Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parent Folder (Optional)</label>
                        <select name="parent_id" class="form-select">
                            <option value="">Root</option>
                            @foreach($allFolders as $folder)
                                <option value="{{ $folder->id }}">
                                    {{ str_repeat('─ ', $folder->level) }} {{ $folder->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Folder Modal -->
<div class="modal fade" id="editFolderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editFolderForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Folder Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Create Folder
    const newFolderForm = document.getElementById('newFolderForm');
    newFolderForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const response = await fetch('/folders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: this.querySelector('[name="name"]').value,
                    parent_id: this.querySelector('[name="parent_id"]').value
                })
            });
            
            if (response.ok) {
                window.location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    // Edit Folder
    const editButtons = document.querySelectorAll('.edit-folder');
    const editFolderForm = document.getElementById('editFolderForm');
    const editModal = new bootstrap.Modal(document.getElementById('editFolderModal'));

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const folderId = this.dataset.folderId;
            const folderName = this.dataset.folderName;
            
            editFolderForm.querySelector('[name="name"]').value = folderName;
            editFolderForm.action = `/folders/${folderId}`;
            editModal.show();
        });
    });

    editFolderForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const response = await fetch(this.action, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: this.querySelector('[name="name"]').value
                })
            });
            
            if (response.ok) {
                window.location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    // Delete Folder
    const deleteButtons = document.querySelectorAll('.delete-folder');
    deleteButtons.forEach(button => {
        button.addEventListener('click', async function() {
            if (confirm('Are you sure you want to delete this folder?')) {
                const folderId = this.dataset.folderId;
                
                try {
                    const response = await fetch(`/folders/${folderId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    if (response.ok) {
                        window.location.reload();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        });
    });
});
</script>
@endpush