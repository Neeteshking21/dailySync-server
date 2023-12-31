<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workspace extends Model
{
    use HasFactory, SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* Projects Relationship */
    public function _projects(): HasMany {
        return $this->hasMany(Project::class);
    }

    /* Workspace User relationship */
    public function _workspaceUsers(): HasMany {
        return $this->hasMany(WorkspaceUser::class);
    }
}
