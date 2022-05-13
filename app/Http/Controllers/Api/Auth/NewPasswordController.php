<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Symfony\Component\HttpFoundation\Response;

class NewPasswordController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private UserServiceInterface $userService;

    /**
     * NewPasswordController constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return $this->failure($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $response = Password::reset($request->only('email', 'password', 'token'),
            fn($user, $password) => $this->userService->update($user, ['password' => $password])
        );

        return $response == Password::PASSWORD_RESET
            ? $this->success([__($response)],Response::HTTP_OK)
            : $this->failure([__($response)], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data)
    {
        return Validator::make($data, [
            'token'    => ['required'],
            'email'    => ['required', 'email', 'max:255', 'exists:users'],
            'password' => ['required', Rules\Password::defaults()],
        ]);
    }
}
