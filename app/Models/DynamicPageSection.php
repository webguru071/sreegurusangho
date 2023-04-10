<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicPageSection extends Model
{
    use HasFactory;

    protected $table = 'dynamic_page_sections';

    protected $fillable = [
        'image',

        'name_en',
        'name_bn',

        'type',
        'module',

        'text_en',
        'text_bn',

        'created_by_id',
        'dynamic_page_id',
    ];

    protected $hidden = [
        'id',
        'created_by_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
