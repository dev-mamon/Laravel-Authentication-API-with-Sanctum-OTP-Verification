<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = ['year', 'month'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_finances')
            ->withPivot(['is_submitted', 'allowance', 'expenses', 'save_amount', 'content'])
            ->withTimestamps();
    }
}
