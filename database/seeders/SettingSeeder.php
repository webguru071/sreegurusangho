<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Setting::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "site_name_en",
            'value' => "Sri Guru Sangha",
            'slug' => Str::slug("Sri Guru Sangha"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "site_name_bn",
            'value' => "শ্রী গুরু সংঘ",
            'slug' => Str::slug("শ্রী গুরু সংঘ"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "logo",
            'value' => "default-logo.png",
            'slug' => Str::slug("default-logo.png"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "favicon",
            'value' => "default-favicon.png",
            'slug' => Str::slug("default-favicon.png"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "manubar_logo",
            'value' => "default-manubar-logo.png",
            'slug' => Str::slug("default-meanubar-logo.png"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "topbar_title_en",
            'value' => "Om Sri Guru Joy",
            'slug' => Str::slug("Om Sri Guru Joy"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "topbar_title_bn",
            'value' => "ওঁ শ্রীগুরু জয়",
            'slug' => Str::slug("ওঁ শ্রীগুরু জয়"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "topbar_founder_en",
            'value' => "Poribrajokacharzobor Sri Srimod Durgaprosonno poromhongsodeber",
            'slug' => Str::slug("Poribrajokacharzobor Sri Srimod Durgaprosonno poromhongsodeber"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "topbar_founder_bn",
            'value' => "পরিব্রাজকাচার্য্যবর শ্রী শ্রীমদ্ দুর্গাপ্রসন্ন পরমহংসদেব",
            'slug' => Str::slug("পরিব্রাজকাচার্য্যবর শ্রী শ্রীমদ্ দুর্গাপ্রসন্ন পরমহংসদেব"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "footer_youtube_link",
            'value' => "https://www.youtube.com/@SreeGuruSanghaBeliever",
            'slug' => Str::slug("fbinsta"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "footer_fb_link",
            'value' => "https://www.facebook.com/SreeGuruSanghaKawkhali",
            'slug' => Str::slug("fblink"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "footer_twitter_link",
            'value' => "",
            'slug' => Str::slug("twitter"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "footer_linkedin_link",
            'value' => "",
            'slug' => Str::slug("linkedin"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "footer_en",
            'value' => "© Copyright Sriguru Songho Kendriyo Asrom",
            'slug' => Str::slug("Copyright Sriguru Songho Kendriyo Asrom"),
        ])->create();

        Setting::factory()->state([
            'type' =>  'App',
            'field' => "footer_bn",
            'value' => "© কপিরাইট শ্রীগুরু সংঘ কেন্দ্রীয় আশ্রম",
            'slug' => Str::slug("কপিরাইট শ্রীগুরু সংঘ কেন্দ্রীয় আশ্রম"),
        ])->create();

    }
}
