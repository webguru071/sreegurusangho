<?php

namespace App\Providers;

use App\Models\SiteMenu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SiteMenuProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        view()->share("siteMenus",$this->getSiteMenu());
    }

    private function getSiteMenu(){
        $siteMenus = SiteMenu::orderBy("id","asc")->where("parent_id",null)->get();

        return $siteMenus;
    }
}
