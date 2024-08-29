<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService){}
    public function register(RegisterAuthRequest $registerAuthRequest): JsonResponse
    {
        $validatedData = $registerAuthRequest->validated();

        $user = $this->userService->createUser($validatedData);

        return response()->json(['message' => 'rejestracja udana', 'data' => $user], Response::HTTP_CREATED);
    }

    public function login(LoginAuthRequest $loginAuthRequest, User $user): JsonResponse
    {
        $validatedData = $loginAuthRequest->validated();

        $validateDataEmail = $validatedData['email'];

        $validateDataPassword = $validatedData['password'];

        $user = $this->userService->findUserFromEmail($validateDataEmail);

        if (!$user || !Hash::check($validateDataPassword, $user->password)) 
        {
            return response()->json(['message' => 'email lub hasło jest nie poprawne', 'data' => null], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'access_token' => $user->createToken('personal access token')->plainTextToken,
            'token_type' => 'Bearer'
        ];

        return response()->json(['message' => 'logowanie udane', 'data' => $data], Response::HTTP_OK);
    }

    public function logout()
    {
        $userId = Auth::check();

        $user = $this->userService->findUserFromId($userId);

        $user->tokens()->delete();

        return response()->json(['message' => 'poprawne wylogowanie', 'data' => null], Response::HTTP_OK);
    }
}
