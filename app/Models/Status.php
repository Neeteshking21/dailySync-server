<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    /* Task Relationship */
    public function _tasks():HasOne
    {
        return $this->hasOne(Task::class);
    }

    /* Writer Relationship */
    public function _writer():HasOne
    {
        return $this->hasOne(User::class);
    }
}
