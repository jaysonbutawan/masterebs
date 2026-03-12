<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $modules = [
            'product' => ['read', 'create', 'update', 'delete'],
            'category' => ['read', 'create', 'update', 'delete'],
            'order' => ['read', 'create', 'update', 'cancel'],
            'user' => ['read', 'create', 'update', 'delete'],
        ];

        foreach ($modules as $module => $actions) {

            foreach ($actions as $action) {

                Permission::firstOrCreate([
                    'name' => "{$module}.{$action}"
                ],[
                    'module' => $module
                ]);

            }

        }
    }
}
