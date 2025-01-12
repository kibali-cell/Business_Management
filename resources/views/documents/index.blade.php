@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Folder Sidebar -->
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Folders</h5>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newFolderModal">
                        <i class="fas fa-folder-plus"></i>
                    </button>
                </div>
                <div class="card-body p-0">
                    @include('documents.partials._folder_tree')
                </div>
            </div>
        </div>

        <!-- Document List -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Documents</h4>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadDocumentModal">
                            Upload Document
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Version</th>
                                    <th>Related Task</th>
                                    <th>Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="far fa-file-alt me-2"></i>
                                            {{ $document->title }}
                                        </div>
                                    </td>
                                    <td>v{{ $document->version }}</td>
                                    <td>
                                        @if($document->task)
                                            <a href="{{ route('tasks.show', $document->task) }}">
                                                {{ $document->task->title }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $document->updated_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="btn-group d-flex gap-1 overflow-auto" style="white-space: nowrap;">
                                            <button class="btn btn-sm btn-outline-primary"
                                                    onclick="previewDocument({{ $document->id }})">
                                                Preview
                                            </button>
                                            <a href="{{ route('documents.download', $document) }}" 
                                               class="btn btn-sm btn-outline-secondary">
                                                Download
                                            </a>
                                            <button class="btn btn-sm btn-outline-info"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#versionModal" 
                                                    data-document-id="{{ $document->id }}">
                                                New Version
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('documents.partials._upload_modal')
@include('documents.partials._version_modal')
@include('documents.partials._folder_modal')
@endsection