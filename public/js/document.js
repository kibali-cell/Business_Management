document.addEventListener('DOMContentLoaded', function() {
    // Preview document
    window.previewDocument = function(documentId) {
        // Implement document preview logic
        const previewUrl = `/documents/${documentId}/preview`;
        window.open(previewUrl, '_blank');
    };

    // Detach document from task
    window.detachDocument = function(documentId) {
        if (confirm('Are you sure you want to detach this document?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/tasks/${taskId}/documents/${documentId}/detach`;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Handle version modal
        const versionModal = document.getElementById('versionModal');
        if (versionModal) {
            versionModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const documentId = button.getAttribute('data-document-id');
                const form = this.querySelector('#versionForm');
                form.action = form.action.replace(':document_id', documentId);
            });
        } 
    });
});