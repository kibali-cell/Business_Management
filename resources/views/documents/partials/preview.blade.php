@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ $document->title }}</h4>
                    <div>
                        <a href="{{ route('documents.download', $document) }}" 
                           class="btn btn-primary">
                            Download
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="preview-container">
                        @switch($previewType)
                            @case('pdf')
                                <iframe src="{{ Storage::url($document->path) }}" 
                                        class="w-100" style="height: 800px;">
                                </iframe>
                                @break
                            
                            @case('image')
                                <img src="{{ Storage::url($document->path) }}" 
                                     class="img-fluid" 
                                     alt="{{ $document->title }}">
                                @break
                            
                            @case('text')
                                <pre class="preview-text">
                                    {{ Storage::get($document->path) }}
                                </pre>
                                @break
                            
                            @default
                                <div class="text-center p-5">
                                    <h5>Preview not available</h5>
                                    <p>Please download the file to view its contents.</p>
                                </div>
                        @endswitch
                    </div>
                </div>
            </div>
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