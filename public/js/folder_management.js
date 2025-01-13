// public/js/folder-management.js
document.addEventListener('DOMContentLoaded', function() {
    const newFolderForm = document.getElementById('newFolderForm');
    // Auto-fill title from filename
    const fileInput = document.querySelector('#file');
    const titleInput = document.querySelector('#title');
    
    if (newFolderForm) {
        newFolderForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            axios.post('/folders', formData)
                .then(response => {
                    if (response.data.success) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    alert('Error creating folder');
                });
        });
    }

    const uploadForm = document.querySelector('#uploadDocumentModal form');
    const uploadButton = document.querySelector('#uploadButton');
    const spinner = uploadButton.querySelector('.spinner-border');
    
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            uploadButton.disabled = true;
            spinner.classList.remove('d-none');
            
            const formData = new FormData(this);
            
            axios.post(this.action, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                // Hide modal and reload page
                const modal = bootstrap.Modal.getInstance(document.getElementById('uploadDocumentModal'));
                modal.hide();
                window.location.reload();
            }).catch(error => {
                // Show error message
                let errorMessage = 'Error uploading document';
                if (error.response?.data?.message) {
                    errorMessage = error.response.data.message;
                }
                alert(errorMessage);
                
                // Reset loading state
                uploadButton.disabled = false;
                spinner.classList.add('d-none');
            });
        });
    }
    
    
    if (fileInput && titleInput) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                // Set the title to the filename without extension if title is empty
                if (!titleInput.value) {
                    titleInput.value = fileName.replace(/\.[^/.]+$/, "");
                }
            }
        });
    }

     window.createRootFolder = function() {
        const name = prompt('Enter folder name:');
        if (name) {
            axios.post('{{ route("folders.store") }}', {
                name: name
            })
            .then(() => window.location.reload())
            .catch(error => alert('Error creating folder: ' + error.response.data.message));
        }
    }
    
     window.createSubfolder = function(parentId) {
        const name = prompt('Enter subfolder name:');
        if (name) {
            axios.post('{{ route("folders.store") }}', {
                name: name,
                parent_id: parentId
            })
            .then(() => window.location.reload())
            .catch(error => alert('Error creating subfolder: ' + error.response.data.message));
        }
    }
    
     window.editFolder = function(folderId, currentName) {
        const name = prompt('Enter new folder name:', currentName);
        if (name && name !== currentName) {
            axios.patch(`/folders/${folderId}`, {
                name: name
            })
            .then(() => window.location.reload())
            .catch(error => alert('Error renaming folder: ' + error.response.data.message));
        }
    }
    
     window.deleteFolder = function(folderId) {
        if (confirm('Are you sure you want to delete this folder? All documents will be moved to root.')) {
            axios.delete(`/folders/${folderId}`)
            .then(() => window.location.reload())
            .catch(error => alert('Error deleting folder: ' + error.response.data.message));
        }
    }
});