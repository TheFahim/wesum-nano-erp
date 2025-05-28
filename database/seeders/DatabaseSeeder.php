<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Resource;
use App\Models\Role;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Technology;
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
        Contact::factory()->count(500)->create();
        // Role::create([
        //     'name' => 'guest'
        // ]);
        // News::factory()->count(500)->create();
        // Technology::factory()->count(50)->create();
        // Service::factory()->count(20)->create();
        // Resource::factory()->count(100)->create();


        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
