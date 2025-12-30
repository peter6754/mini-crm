<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->manager()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
        ]);

        $this->call([
            CustomerSeeder::class,
            TicketSeeder::class,
        ]);
    }
}
