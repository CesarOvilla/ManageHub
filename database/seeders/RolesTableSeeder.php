<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Roles::asOptions() as $option) {
            Role::updateOrCreate([
                'name' => $option['value'],
            ], [
                'guard_name' => 'web',
            ]);
        }
    }
}
