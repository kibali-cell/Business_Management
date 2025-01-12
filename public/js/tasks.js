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
    window.editTask = function(taskId) {
        const modal = document.getElementById('editTaskModal');
        if (!modal) {
            console.error('Edit task modal not found in the DOM');
            showNotification('Unable to edit task - modal not found', 'error');
            return;
        }
    
        fetch(`/tasks/${taskId}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(task => {
                const form = modal.querySelector('form');
                if (!form) {
                    throw new Error('Form not found in modal');
                }
    
                try {
                    // Fill form fields with error handling for each field
                    const fields = {
                        title: task.title,
                        description: task.description,
                        priority: task.priority,
                        due_date: task.due_date,
                        assigned_to: task.assigned_to // Changed from assignee_id to assigned_to
                    };
    
                    for (const [fieldName, value] of Object.entries(fields)) {
                        const field = form.querySelector(`[name="${fieldName}"]`);
                        if (field) {
                            field.value = value || '';
                        } else {
                            console.warn(`Field ${fieldName} not found in form`);
                        }
                    }
    
                    // Set up form submission
                    form.onsubmit = function(e) {
                        e.preventDefault();
                        const formData = new FormData(form);
                        formData.append('_method', 'PUT');
                        updateTask(taskId, formData);
                    };
    
                    // Show modal
                    const modalInstance = new bootstrap.Modal(modal);
                    modalInstance.show();
                } catch (error) {
                    console.error('Error populating form:', error);
                    showNotification('Error preparing edit form', 'error');
                }
            })
            .catch(error => {
                console.error('Error fetching task data:', error);
                showNotification('Failed to load task data', 'error');
            });
    };
    
    // Update the updateTaskCard function to match the response data structure
     window.updateTaskCard =  function(task) {
        const card = document.querySelector(`[data-task-id="${task.id}"]`);
        if (card) {
            card.querySelector('.card-title').textContent = task.title;
            card.querySelector('.card-text').textContent = task.description || '';
            
            // Update priority badge
            const badge = card.querySelector('.badge');
            badge.className = `badge bg-${task.priority === 'high' ? 'danger' : (task.priority === 'medium' ? 'warning' : 'info')}`;
            badge.textContent = task.priority.charAt(0).toUpperCase() + task.priority.slice(1);
            
            // Update due date
            const dueDate = new Date(task.due_date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            card.querySelector('small').textContent = `Due: ${dueDate}`;
            
            // Update assignee
            if (task.assignee) {
                card.querySelector('.text-muted').textContent = `Assigned to: ${task.assignee.name}`;
            }
        }
    }

// Edit Task
window.updateTask = function(taskId, formData) {
    fetch(`/tasks/${taskId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'  
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(text);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update task card in UI
            updateTaskCard(data.task);
            bootstrap.Modal.getInstance(document.getElementById('editTaskModal')).hide();
            showNotification('Task updated successfully', 'success');
        } else {
            showNotification(data.message || 'Failed to update task', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to update task: ' + error.message, 'error');
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

// Helper function for notifications if not already defined
 window.showNotification = function(message, type = 'success') {
    const notificationTypes = {
        success: 'background-color: #d4edda; color: #155724',
        error: 'background-color: #f8d7da; color: #721c24'
    };

    const notification = document.createElement('div');
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px;
        border-radius: 4px;
        z-index: 9999;
        ${notificationTypes[type] || notificationTypes.success}
    `;

    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}

});

// // Helper function for notifications
// function showNotification(message, type = 'success') {
//     // You can use any notification library here, or create a simple one
//     alert(message);
// }