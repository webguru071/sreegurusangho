<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouncilMember extends Model
{
    use HasFactory,HasSlug;

    protected $table = 'council_members';

    protected $fillable = [
        'slug',
        'image',
        'name_en',
        'name_bn',
        'council',
        'branch',

        'membership_type',
        'member_position',
        'member_position_bn',

        'short_description_en',
        'short_description_bn',

        'description_en',
        'description_bn',

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

    public function councilMembershipType()
    {
        return $this->belongsTo(CouncilMembershipType::class,'council_membership_type_id','id');
    }

    public function councilMemberPosition()
    {
        return $this->belongsTo(CouncilMemberPosition::class,'council_member_position_id','id');
    }
}
