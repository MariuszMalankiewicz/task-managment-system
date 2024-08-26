<?php

namespace App\Http\Controllers\API\Authentication;

use App\Models\User;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\AuthenticationUserLoginRequest;
use App\Http\Requests\AuthenticationUserRegisterRequest;

class AuthenticationUserController extends Controller
{
    public function __construct(protected UserService $userService){}
    public function register(AuthenticationUserRegisterRequest $authenticationUserRegisterRequest): JsonResponse
    {
        $validatedData = $authenticationUserRegisterRequest->validated();

        $user = $this->userService->createUser($validatedData);

        return response()->json(['message' => 'rejestracja udana', 'data' => $user], Response::HTTP_CREATED);
    }

    public function login(AuthenticationUserLoginRequest $authenticationUserLoginRequest, User $user): JsonResponse
    {
        $validatedData = $authenticationUserLoginRequest->validated();

        $validateDataEmail = $validatedData['email'];

        $validateDataPassword = $validatedData['password'];

        $user = $this->userService->findUserFromEmail($validateDataEmail);

        if (!$user || !Hash::check($validateDataPassword, $user->password)) 
        {
            return response()->json(['message' => 'email lub hasło jest nie poprawne', 'data' => $user], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'access_token' => $user->createToken('personal access token')->plainTextToken,
            'token_type' => 'Bearer'
        ];

        return response()->json(['message' => 'logowanie udane', 'data' => $data], Response::HTTP_OK);
    }
}
