<ul class="list-group list-group-flush">
    @foreach($folders as $folder)
        <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('documents.index', ['folder' => $folder->id]) }}" 
                   class="text-decoration-none text-dark">
                    <i class="fas fa-folder me-2"></i>
                    {{ $folder->name }}
                </a>
                <span class="badge bg-secondary rounded-pill">
                    {{ $folder->documents_count }}
                </span>
            </div>
            @if($folder->children->count() > 0)
                <div class="ms-4">
                    @include('documents.partials._folder_tree', ['folders' => $folder->children])
                </div>
            @endif
        </li>
    @endforeach
</ul>

