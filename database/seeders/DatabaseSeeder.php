<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\OwnerAdmin\RegisterBranch;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Permission;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'add branch']);
    }
}