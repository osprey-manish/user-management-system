<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequests;
use App\Http\Requests\UpdateUserRequests;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return response()->json([
            'status' => true,
            'message' => $users->isEmpty() ? 'No users found' : 'Users fetched successfully',
            'data' => $users
        ]);
    }

     public function store(StoreUserRequests $request): JsonResponse
    {
        $user = $this->userService->createNewUser($request->validated());

        return response()->json([
            'status'  => true,
            'message' => 'User created successfully',
            'data'    => $user
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'User fetched successfully',
            'data' => $user
        ]);
    }

    public function update(UpdateUserRequests $request, int $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }
}
