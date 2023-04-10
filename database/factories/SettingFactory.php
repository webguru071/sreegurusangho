<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    public function definition()
    {
        return [
            'field' => Str::ucfirst($this->faker->words(rand(5, 15), true)),
            'slug' => Str::uuid(),
            'type' =>  "App",
            'value' =>  Str::ucfirst($this->faker->words(rand(5, 15), true)),
            'updated_at'=> null,
            'created_at'=> now(),
            'created_by_id' =>  1,

        ];
    }
}
