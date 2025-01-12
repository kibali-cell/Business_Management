<div class="modal fade" id="attachDocumentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attach Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="attachDocumentForm" method="POST" 
                      action="{{ route('tasks.attach_document', $task) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select Document</label>
                        <select name="document_id" class="form-select" required>
                            <option value="">Choose a document...</option>
                            @foreach($availableDocuments as $document)
                                <option value="{{ $document->id }}">
                                    {{ $document->title }} (v{{ $document->version }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Attach</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>