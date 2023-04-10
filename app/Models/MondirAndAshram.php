<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MondirAndAshram extends Model
{
    use HasFactory;


    protected $table = 'mondir_and_ashrams';

    protected $fillable = [
        'image',
        'name_en',
        'name_bn',
        'branch',

        'text_en',
        'text_en',

        'created_by_id',
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
