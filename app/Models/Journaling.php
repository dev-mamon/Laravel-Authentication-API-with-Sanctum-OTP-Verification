<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journaling extends Model
{
    protected $fillable = ['year', 'week'];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'journal_users', 'journaling_id', 'user_id')
            ->withPivot('is_submitted', 'content')
            ->withTimestamps();
    }
}
