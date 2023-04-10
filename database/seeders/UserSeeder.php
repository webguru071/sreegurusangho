<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::factory()->state([
            'name' => "Admin",
            'email' => "admin@gmail.com",
            'created_by_id' => 1,
            'user_role'=> "Admin", // Admin||User
            'slug' => Str::uuid(),
        ])->create();

        User::factory()->state([
            'name' => "Tahmid farzan",
            'email' => "tfarzan007@gmail.com",
            'created_by_id' => 2,
            'user_role'=> "Admin", // Admin||User
            'slug' => Str::uuid(),
        ])->create();
    }
}
