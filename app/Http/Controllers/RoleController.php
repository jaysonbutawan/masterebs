<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(): JsonResponse
    {
        $roles = $this->roleService->getAll();

        return response()->json([
            'message' => 'Roles retrieved successfully',
            'data' => $roles,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $role = $this->roleService->getById($id);

        if (!$role) {
            return response()->json([
                'message' => 'Role not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Role retrieved successfully',
            'data' => $role,
        ]);
    }

    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = $this->roleService->create($request->validated());

        return response()->json([
            'message' => 'Role created successfully',
            'data' => $role,
        ], 201);
    }

    public function update(UpdateRoleRequest $request, int $id): JsonResponse
    {
        $role = $this->roleService->update($id, $request->validated());

        if (!$role) {
            return response()->json([
                'message' => 'Role not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Role updated successfully',
            'data' => $role,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->roleService->delete($id);

        if (!$deleted) {
            return response()->json([
                'message' => 'Role not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Role deleted successfully',
        ]);
    }
}
