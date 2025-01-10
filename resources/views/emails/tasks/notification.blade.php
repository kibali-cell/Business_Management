
@component('mail::message')
# Task Update

A task has been {{ $task->created_at->eq($task->updated_at) ? 'created' : 'updated' }}.

**Title:** {{ $task->title }}
**Due Date:** {{ $task->due_date->format('M d, Y') }}
**Priority:** {{ ucfirst($task->priority) }}

@component('mail::button', ['url' => route('tasks.show', $task)])
View Task
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent