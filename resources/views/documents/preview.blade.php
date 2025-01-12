@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Preview: {{ $document->title }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Version:</strong> v{{ $document->version }}</p>
            <p><strong>Last Updated:</strong> {{ $document->updated_at->format('d M Y, h:i A') }}</p>
            <p><strong>File Exists:</strong> {{ isset($exists) ? ($exists ? 'Yes' : 'No') : 'Not checked' }}</p>

            @if(isset($error))
                <p class="text-danger">{{ $error }}</p>
            @elseif(Storage::disk('public')->exists($document->path))
                @php
                    $fileExtension = pathinfo($document->path, PATHINFO_EXTENSION);
                @endphp

                @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                    <img src="{{ Storage::disk('public')->url($document->path) }}" alt="Preview" class="img-fluid">
                @elseif($fileExtension === 'pdf')
                    <iframe src="{{ Storage::disk('public')->url($document->path) }}" width="100%" height="600"></iframe>
                @else
                    <p>Preview not available. Please <a href="{{ route('documents.download', $document) }}">download the file</a> to view its contents.</p>
                @endif
            @else
                <p class="text-danger">No file available for preview. The file may have been deleted or is inaccessible.</p>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.preview-container {
    min-height: 400px;
    background: #f8f9fa;
    border-radius: 4px;
    padding: 1rem;
}

.preview-text {
    white-space: pre-wrap;
    word-wrap: break-word;
    max-height: 800px;
    overflow-y: auto;
}
</style>
@endpush
@endsection