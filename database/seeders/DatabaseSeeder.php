<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'a@b.com',
            'is_admin' => true
        ]);

        User::factory(10)->create();

        Listing::factory(10)->create([
            'user_id' => 1
        ]);
        Listing::factory(10)->create([
            'user_id' => 2
        ]);
    }
}
