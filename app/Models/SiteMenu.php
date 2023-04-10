<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteMenu extends Model
{
    use HasFactory;


    public function parent()
    {
        return $this->belongsTo(SiteMenu::class,'parent_id');
    }

    public function dynamicPage()
    {
        return $this->belongsTo(DynamicPage::class,'page_id','id');
    }

    public function siteMenus()
    {
        return $this->hasMany(SiteMenu::class,'parent_id','id');
    }
}
