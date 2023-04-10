<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class CountryArea extends Model
{
    use HasFactory, HasRecursiveRelationships;

    protected $table='country_areas';

    protected $fillable = [
        'name',
        'code',
        'slug',
        'parent_id',
        'deleted_at',
        'description',
        'created_by_id',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function allChildrens()
    {
        return $this->hasMany(CountryArea::class,'parent_id');
    }

    public function countryAreas()
    {
        return $this->hasMany(CountryArea::class,'parent_id','id');
    }

    public function councilMembers()
    {
        return $this->hasMany(CouncilMember::class,'branch','id');
    }

    public function parent()
    {
        return $this->belongsTo(CountryArea::class,'parent_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by_id','id');
    }
}
