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

                'order-item.read',
                'order-item.create',
                'order-item.update',
                'order-item.delete',

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
                'order-item.read',
                'order-item.update',
                'order.cancel',
            ],

            'customer' => [
                'product.read',
                'category.read',
                'order.read',
                'order.create',
                'order.cancel',
                'order-item.read',
                
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
