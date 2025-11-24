<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreativeDesign extends Model
{
    protected $fillable = ['user_id', 'image', 'image_title', 'image_size'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
