<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
        ]);

        $roles = Role::all();

        User::factory(10)->create()->each(function ($user) use ($roles) {
            $user->role_id = $roles->random()->id;
            $user->save();
        });

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => $roles->random()->id,
        ]);
    }
}