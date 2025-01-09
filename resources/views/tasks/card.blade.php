
<div class="card mb-2 task-card" data-task-id="{{ $task->id }}">
    <div class="card-body">
        <h5 class="card-title">{{ $task->title }}</h5>
        <p class="card-text">{{ Str::limit($task->description, 50) }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <span class="badge bg-{{ $task->priority === 'high' ? 'danger' : 'warning' }}">
                {{ ucfirst($task->priority) }}
            </span>
            <small>Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</small>
        </div>
    </div>
</div>