{{-- resources/views/components/folder-modal.blade.php --}}
@props(['folders'])

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
                            @foreach($folders as $folder)
                                <option value="{{ $folder->id }}">
                                    {{ str_repeat('─ ', $folder->level) }} {{ $folder->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div id="folderError" class="alert alert-danger mt-3" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const newFolderForm = document.getElementById('newFolderForm');
    const newFolderModal = new bootstrap.Modal(document.getElementById('newFolderModal'));
    const errorDiv = document.getElementById('folderError');

    newFolderForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        errorDiv.style.display = 'none';
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch('/folders', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: formData.get('name'),
                    parent_id: formData.get('parent_id')
                })
            });
            
            const data = await response.json();
            
            if (response.ok) {
                newFolderModal.hide();
                window.location.reload();
            } else {
                errorDiv.textContent = data.message || 'Error creating folder';
                errorDiv.style.display = 'block';
            }
        } catch (error) {
            console.error('Error:', error);
            errorDiv.textContent = 'An error occurred while creating the folder';
            errorDiv.style.display = 'block';
        }
    });

    // Clear form and errors when modal is hidden
    document.getElementById('newFolderModal').addEventListener('hidden.bs.modal', function () {
        newFolderForm.reset();
        errorDiv.style.display = 'none';
    });
});
</script>
@endpush