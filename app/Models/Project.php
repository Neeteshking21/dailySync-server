<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    public function _workspace() :HasOne
    {
        return $this->hasOne(Workspace::class);
    }

    /* Modules Relationship */
     public function _modules(): HasMany {
        return $this->hasMany(Module::class);
    }

    /* Statuses Relationship */
     public function _statuses(): HasMany {
        return $this->hasMany(Status::class);
    }
}
