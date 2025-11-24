<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMS extends Model
{
    protected $table = 'c_m_s';

    protected $fillable = [
        'page',
        'section',
        'title',
        'sub_title',
        'content',
        'sub_content',
        'image',
        'background_image',
        'btn_text',
        'video',
    ];
}
