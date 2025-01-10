@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Task Board</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
            Add Task
        </button>
    </div>

    <div class="row">
        <!-- Pending Tasks Column -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    Pending Tasks
                </div>
                <div class="card-body">
                    <div class="task-list" id="pending" data-status="pending">
                        @foreach($tasks->where('status', 'pending') as $task)
                            @include('tasks.partials.task-card')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- In Progress Column -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    In Progress
                </div>
                <div class="card-body">
                    <div class="task-list" id="in_progress" data-status="in_progress">
                        @foreach($tasks->where('status', 'in_progress') as $task)
                            @include('tasks.partials.task-card')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Column -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Completed
                </div>
                <div class="card-body">
                    <div class="task-list" id="completed" data-status="completed">
                        @foreach($tasks->where('status', 'completed') as $task)
                            @include('tasks.partials.task-card')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('tasks.partials.create-modal')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/tasks.js') }}"></script>
@endpush