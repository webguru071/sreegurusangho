<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\DonateAccount;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class SettingServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        view()->share("setting",$this->getSetting());
    }

    private function getSetting(){
        $donateAccounts = DonateAccount::orderBy("id","desc")->get();
        $settingFormated = array(
            "App" => array(
                "site_name_en" => "Sri guru shango",
                "site_name_bn" => "Sri guru shango",
                "logo" => "default-logo.png",
                "manubar_logo" => "default-manubar-log.png",
                "favicon" => "default-favicon.png",
                "topbar_title_en" => "Om Sri Guru Joy",
                "topbar_title_bn" => "ওম শ্রী গুরু জয়",
                "topbar_founder_en" => "Poribrajokacharzobor Sri Srimod Durgaprosonno poromhongsodeber",
                "topbar_founder_bn" => "Poribrajokacharzobor Sri Srimod Durgaprosonno poromhongsodeber",
                "footer_youtube_link" => null,
                "footer_fb_link" => null,
                "footer_twitter_link" => null,
                "footer_linkedin_link" => null,
                "donate_accounts" => $donateAccounts,
            ),
        );



        if (Schema::hasTable('settings')) {
            $settings = Setting::orderBy("created_at","desc")->where("type","App")->get();

            foreach ($settings as $settingValue) {

                if(!($settingValue->value == null)){
                    $settingFormated[$settingValue->type][$settingValue->field] = $settingValue->value;
                }
            }
        }

        return $settingFormated;
    }
}
