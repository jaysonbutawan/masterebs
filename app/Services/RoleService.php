<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public function getAll()
    {
        return Role::with('permissions')->get();
    }

    public function getById(int $id)
    {
        return Role::with('permissions')->find($id);
    }

    public function create(array $data)
    {
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role = Role::create($data);

        if (!empty($permissions)) {
            $role->permissions()->sync($permissions);
        }

        return $role->load('permissions');
    }

    public function update(int $id, array $data)
    {
        $role = Role::find($id);

        if (!$role) {
            return null;
        }

        $permissions = $data['permissions'] ?? null;
        unset($data['permissions']);

        $role->update($data);

        if (is_array($permissions)) {
            $role->permissions()->sync($permissions);
        }

        return $role->load('permissions');
    }

    public function delete(int $id): bool
    {
        $role = Role::find($id);

        if (!$role) {
            return false;
        }

        $role->permissions()->detach();

        return (bool) $role->delete();
    }
}