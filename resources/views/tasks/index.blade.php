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
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-light">Pending</div>
            <div class="card-body">
                <div class="task-list" id="pending" data-status="pending">
                    @foreach($tasks->where('status', 'pending') as $task)
                        @include('tasks.card')
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-light">In Progress</div>
            <div class="card-body">
                <div class="task-list" id="in_progress" data-status="in_progress">
                    @foreach($tasks->where('status', 'in_progress') as $task)
                        @include('tasks.card')
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-light">Completed</div>
            <div class="card-body">
                <div class="task-list" id="completed" data-status="completed">
                    @foreach($tasks->where('status', 'completed') as $task)
                        @include('tasks.card')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@include('tasks.create-modal')
@endsection