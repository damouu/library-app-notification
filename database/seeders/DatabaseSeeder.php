<?php

namespace Database\Seeders;

use App\Models\UserProjection;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // UserProjection::factory(10)->create();

        UserProjection::factory()->create([
            'name' => 'Test UserProjection',
            'email' => 'test@example.com',
        ]);
    }
}
