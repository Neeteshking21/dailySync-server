<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WorkspaceUser extends Model
{
    use HasFactory;

    /* User Relation */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /* Workspace Relation */
    public function _workspace(): HasOne
    {
        return $this->hasOne(Workspace::class);
    }
}
