@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- Existing task details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>{{ $task->title }}</h4>
                </div>
                <div class="card-body">
                    <!-- Task details here -->
                </div>
            </div>
            
            <!-- Related Documents Section -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Related Documents</h5>
                    <button class="btn btn-primary btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#attachDocumentModal">
                        Attach Document
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>Version</th>
                                    <th>Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($task->documents as $document)
                                <tr>
                                    <td>{{ $document->title }}</td>
                                    <td>v{{ $document->version }}</td>
                                    <td>{{ $document->updated_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('documents.download', $document) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                Download
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger"
                                                    onclick="detachDocument({{ $document->id }})">
                                                Detach
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('tasks.partials._attach_document_modal')
@endsection