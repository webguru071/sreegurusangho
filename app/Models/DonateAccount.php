<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonateAccount extends Model
{
    use HasFactory,HasSlug;

    protected $table = 'donate_accounts';

    protected $fillable = [
        'slug',
        'image',
        'name_en',
        'name_bn',

        'account_en',
        'account_bn',

        'created_by_id',
    ];

    protected $hidden = [
        'id',
        'slug',
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

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name_en')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
