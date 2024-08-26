<?php

namespace App\Http\Controllers\API\Authentication;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\AuthenticationUserRegisterRequest;

class AuthenticationUserController extends Controller
{
    public function __construct(protected UserService $userService){}
    public function register(AuthenticationUserRegisterRequest $authenticationUserRegisterRequest)
    {
        $validatedData = $authenticationUserRegisterRequest->validated();

        $user = $this->userService->createUser($validatedData);

        return response()->json(['message' => 'użytkownik został dodany', 'data' => $user], Response::HTTP_CREATED);
    }

    public function login()
    {
        $user = [];

        return response()->json(['message' => 'zostałeś zalogowany poprawnie', 'data' => $user], Response::HTTP_OK);
    }
}
