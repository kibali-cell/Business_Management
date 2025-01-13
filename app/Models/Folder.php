<?php

namespace App\Models;

use App\Models\User;
use App\Models\Document;


use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = ['name', 'parent_id', 'created_by'];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($folder) {
            $folder->slug = Str::slug($folder->name);
            $folder->created_by = auth()->id();
            
            // Set path and level
            if ($folder->parent_id) {
                $parent = static::find($folder->parent_id);
                $folder->path = $parent->path . '/' . $folder->slug;
                $folder->level = $parent->level + 1;
            } else {
                $folder->path = $folder->slug;
                $folder->level = 0;
            }
        });
    }

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper methods
    public function getFullPathAttribute()
    {
        return explode('/', $this->path);
    }

    public function getLevelAttribute()
    {
        $level = 0;
        $parent = $this->parent;
        
        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }
        
        return $level;
    }

    public function getBreadcrumbAttribute()
    {
        $paths = $this->full_path;
        $breadcrumb = [];
        $currentPath = '';
        
        foreach ($paths as $path) {
            $currentPath .= ($currentPath ? '/' : '') . $path;
            $breadcrumb[] = [
                'name' => $path,
                'path' => $currentPath
            ];
        }
        
        return $breadcrumb;
    }
}

    