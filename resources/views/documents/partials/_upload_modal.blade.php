<!-- resources/views/documents/partials/_upload_document_modal.blade.php -->
<div class="modal fade" id="uploadDocumentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload New Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Document Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                        <small class="text-muted">Maximum file size: 10MB</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="folder" class="form-label">Select Folder</label>
                        <select class="form-select" id="folder" name="folder_id">
                            <option value="">Root Directory</option>
                            @foreach($allFolders ?? [] as $folder)
                                <option value="{{ $folder->id }}" 
                                    {{ request('folder_id') == $folder->id ? 'selected' : '' }}>
                                    {{ str_repeat('─ ', $folder->level) }} {{ $folder->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                                placeholder="Enter a description for this document (optional)"></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_public" name="is_public">
                            <label class="form-check-label" for="is_public">
                                Make document public
                            </label>
                            <small class="form-text text-muted d-block">
                                Public documents can be viewed by anyone with the link
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="uploadButton">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



