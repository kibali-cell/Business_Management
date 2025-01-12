<div class="modal fade" id="newFolderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('documents.folders.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="folder_name" class="form-label">Folder Name</label>
                        <input type="text" class="form-control" id="folder_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="parent_folder" class="form-label">Parent Folder</label>
                        <select class="form-select" id="parent_folder" name="parent_id">
                            <option value="">Root Directory</option>
                            @foreach($folders ?? [] as $folder)
                                <option value="{{ $folder->id }}">{{ $folder->name }}</option>
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