<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $masterUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
        ]);

        $regulars = User::factory()->count(3)->create([
            'master_id' => $masterUser->id,
            'type'      => 'regular'
        ]);

        foreach ($regulars as $user) {
            Task::factory()->count(3)->create([
                'user_id' => $masterUser->id,
                'responsible_id' => $user->id
            ]);
        }
    }
}
