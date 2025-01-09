// resources/js/tasks.js
document.addEventListener('DOMContentLoaded', function() {
    const taskLists = document.querySelectorAll('.task-list');
    
    taskLists.forEach(taskList => {
        new Sortable(taskList, {
            group: 'shared',
            animation: 150,
            onEnd: function(evt) {
                const taskId = evt.item.dataset.taskId;
                const newStatus = evt.to.dataset.status;
                
                fetch('/tasks/update-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        taskId: taskId,
                        status: newStatus
                    })
                });
            }
        });
    });
});