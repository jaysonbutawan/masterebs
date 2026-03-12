<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $rolePermissions = [

            'admin' => [
                'product.read',
                'product.create',
                'product.update',
                'product.delete',

                'category.read',
                'category.create',
                'category.update',
                'category.delete',

                'order.read',
                'order.create',
                'order.update',
                'order.cancel',

                'user.read',
                'user.create',
                'user.update',
            ],

            'staff' => [
                'product.read',
                'product.update',
                'category.read',
                'order.read',
                'order.update',
            ],

            'customer' => [
                'product.read',
                'category.read',
                'order.read',
                'order.create',
            ],
        ];

        /**
         * SUPER ADMIN GETS ALL PERMISSIONS
         */
        $superAdmin = Role::where('name', 'super_admin')->first();

        if ($superAdmin) {
            $superAdmin->permissions()->sync(
                Permission::pluck('id')->toArray()
            );
        }

        /**
         * OTHER ROLES
         */
        foreach ($rolePermissions as $roleName => $permissions) {

            $role = Role::where('name', $roleName)->first();

            if (!$role) {
                continue;
            }

            $permissionIds = Permission::whereIn('name', $permissions)
                ->pluck('id')
                ->toArray();

            $role->permissions()->sync($permissionIds);
        }
    }
}
