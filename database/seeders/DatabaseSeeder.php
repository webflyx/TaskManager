<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Project::factory(10)->create();

        Task::factory(100)->create();


        $admin = User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
        ]);

        for ($i = 0; $i < 10; $i++){
            $project = Project::factory(1)->create([
                'user_id' => $admin->id,
            ]);

            Task::factory(rand(4,20))->create([
                'project_id' => $project[0]->id,
            ]);
        }

    }
}
