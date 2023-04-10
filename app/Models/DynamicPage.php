<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{
    use HasFactory,HasSlug;

    protected $table = 'dynamic_pages';

    protected $fillable = [
        'image',

        'name',
        'slug',

        'title_en',
        'title_bn',

        'sub_title_en',
        'sub_title_en',

        'section_en',
        'section_bn',
        'has_section',

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

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function sections()
    {
        return $this->hasMany(DynamicPageSection::class,'dynamic_page_id','id');
    }
}
