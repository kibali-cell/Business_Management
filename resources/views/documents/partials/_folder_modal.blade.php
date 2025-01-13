{{-- resources/views/components/folder-modal.blade.php --}}
@props(['folders'])

<div class="modal fade" id="newFolderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="newFolderForm">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>