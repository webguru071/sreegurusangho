<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory,HasSlug;

    protected $table = 'events';

    protected $fillable = [
        'slug',
        'name_en',
        'name_bn',

        'details_en',
        'details_bn',

        'day_en',
        'day_bn',

        'date_en',
        'date_bn',

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

    public function isCurrentEvent()
    {
        $isCurrentEvent = false;
        if(now() == $this->date_en){
            $isCurrentEvent = true;
        }
        return $isCurrentEvent;
    }

    public function isUpcomingEvent()
    {
        $isUpcomingEvent = false;
        if(now() < $this->date_en){
            $isUpcomingEvent = true;
        }
        return $isUpcomingEvent;
    }

    public function isPastEvent()
    {
        $isPastEvent = false;
        if(now() > $this->date_en){
            $isPastEvent = true;
        }
        return $isPastEvent;
    }
}
