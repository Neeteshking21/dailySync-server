<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;
    /* module Relationship */
    public function _module(): HasOne
    {
        return $this->hasOne(Module::class);
    }

    /* Projects Relationship */
    public function _project(): HasOne
    {
        return $this->hasOne(Project::class);
    }

    /* Assignee Relationship */
    public function _assignee(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /* Reporter Relationship */
    public function _Reporter(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /* Comments Relationship */
    public function _comments(): HasMany {
        return $this->hasMany(Comment::class);
    }
}
