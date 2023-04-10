<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(CouncilMembershipTypeSeeder::class);
        $this->call(CouncilMemberPositionSeeder::class);
    }
}
