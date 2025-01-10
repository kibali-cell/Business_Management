document.addEventListener('DOMContentLoaded', function() {
    // Initialize Sortable for each task list
    const taskLists = document.querySelectorAll('.task-list');
    
    taskLists.forEach(taskList => {
        new Sortable(taskList, {
            group: 'shared',
            animation: 150,
            ghostClass: 'bg-light',
            onEnd: function(evt) {
                const taskId = evt.item.dataset.taskId;
                const newStatus = evt.to.dataset.status;
                
                // Send AJAX request to update task status
                fetch(`/tasks/${taskId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success notification
                        showNotification('Task status updated successfully', 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to update task status', 'error');
                });
            }
        });
    });

    // public/js/tasks.js
function editTask(taskId) {
    fetch(`/tasks/${taskId}/edit`)
        .then(response => response.json())
        .then(task => {
            const modal = document.getElementById('editTaskModal');
            const form = modal.querySelector('form');
            
            // Fill form fields
            form.querySelector('[name="title"]').value = task.title;
            // Fill other fields...
            
            form.onsubmit = function(e) {
                e.preventDefault();
                updateTask(taskId, new FormData(form));
            };
            
            new bootstrap.Modal(modal).show();
        });
}

// Edit Task
function updateTask(taskId, formData) {
    fetch(`/tasks/${taskId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update task card in UI
            updateTaskCard(data.task);
            bootstrap.Modal.getInstance(document.getElementById('editTaskModal')).hide();
            showNotification('Task updated successfully');
        }
    });
}

    // Function to delete a task
    window.deleteTask = function(taskId) {
        if (confirm('Are you sure you want to delete this task?')) {
            fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`[data-task-id="${taskId}"]`).remove();
                    showNotification('Task deleted successfully');
                } else {
                    console.error('Failed to delete task');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to delete task', 'error');
            });
        }
    };
});

// Helper function for notifications
function showNotification(message, type = 'success') {
    // You can use any notification library here, or create a simple one
    alert(message);
}