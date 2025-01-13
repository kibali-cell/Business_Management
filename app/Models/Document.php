<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Folder;
use App\Models\DocumentVersion;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    protected $fillable = [
        'title',
        'description',
        'filename',
        'path',
        'file_type',
        'file_size',
        'task_id',
        'folder_id',
        'uploaded_by',
        'is_public',
        'version'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function versions()
    {
        return $this->hasMany(DocumentVersion::class)->orderBy('version_number', 'desc');
    }
}
