<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // database/seeders/RoleSeeder.php

    DB::table('roles')->insert([
        ['name' => 'Administrator', 'slug' => 'admin'],
        ['name' => 'Manager', 'slug' => 'manager'],
        ['name' => 'Employee', 'slug' => 'employee']
    ]);

    }
}
