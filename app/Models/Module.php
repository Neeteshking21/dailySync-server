<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Module extends Model
{
    use HasFactory;

    /* Projects Relationship */
    public function _projects() : HasOne
    {
        return $this->hasOne(Project::class);
    }

    /* Modules Relationship */
     public function _tasks(): HasMany {
        return $this->hasMany(Task::class);
    }
}
