<div class="modal fade" id="versionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload New Version</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('documents.version', ':document_id') }}" method="POST" enctype="multipart/form-data" id="versionForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="version_file" class="form-label">File</label>
                        <input type="file" class="form-control" id="version_file" name="file" required>
                    </div>
                    <div class="mb-3">
                        <label for="version_notes" class="form-label">Version Notes</label>
                        <textarea class="form-control" id="version_notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload Version</button>
                </div>
            </form>
        </div>
    </div>
</div>