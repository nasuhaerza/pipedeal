<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::with('company')->get();

        return response()->json($users);
    }

    public function store(UserRequest $request, ActivityLogService $activityLogService): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        $activityLogService->record($user, 'created', "User {$user->email} created", auth()->user());

        return response()->json($user, 201);
    }

    public function show(User $user): JsonResponse
    {
        $this->authorize('view', $user);

        return response()->json($user);
    }

    public function update(UserRequest $request, User $user, ActivityLogService $activityLogService): JsonResponse
    {
        $this->authorize('update', $user);

        $data = $request->validated();

        if (isset($data['password']) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        $activityLogService->record($user, 'updated', "User {$user->email} updated", auth()->user());

        return response()->json($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);
        $user->delete();

        return response()->json(['message' => 'User deleted.']);
    }
}
