<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Faction::create([
            'name' => "none",
            'color' => "",
            'key' => "none",
        ]);

        \App\Faction::create([
            'name' => "Kazan",
            'color' => "red",
            'key' => "kazan",
        ]);

        \App\Faction::create([
            'name' => "Gaia",
            'color' => "green",
            'key' => "gaia",
        ]);

        \App\Faction::create([
            'name' => "Saxosus",
            'color' => "purple",
            'key' => "saxosus",
        ]);
    }
}
