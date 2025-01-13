<ul class="list-group list-group-flush folder-tree">
    @foreach($folders as $folder)
        <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('documents.index', ['folder' => $folder->id]) }}" 
                       class="text-decoration-none {{ request()->query('folder') == $folder->id ? 'fw-bold text-primary' : 'text-dark' }}">
                        <i class="fas fa-folder{{ request()->query('folder') == $folder->id ? '-open' : '' }} me-2"></i>
                        {{ $folder->name }}
                    </a>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-secondary rounded-pill me-2" title="Documents in this folder">
                        {{ $folder->documents_count }}
                    </span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-link text-dark" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <button class="dropdown-item" onclick="editFolder({{ $folder->id }}, '{{ $folder->name }}')">
                                    <i class="fas fa-edit me-2"></i> Rename
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item" onclick="createSubfolder({{ $folder->id }})">
                                    <i class="fas fa-folder-plus me-2"></i> New Subfolder
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button class="dropdown-item text-danger" onclick="deleteFolder({{ $folder->id }})">
                                    <i class="fas fa-trash-alt me-2"></i> Delete
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @if($folder->children->count() > 0)
                <div class="ms-4 mt-2">
                    @include('documents.partials._folder_tree', ['folders' => $folder->children])
                </div>
            @endif
        </li>
    @endforeach
</ul>