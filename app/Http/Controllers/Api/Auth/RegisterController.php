<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Models\User;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private UserServiceInterface $userService;

    /**
     * RegisterController constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        parent::__construct();

        $this->middleware('guest');

        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return $this->failure($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            if (!$user = $this->userService->create($validator->validated())) {
                return $this->failure(['Can`t create user with given data'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Throwable $exception) {
            return $this->failure(['Can`t create user with given data'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'min:3', 'max:40'],
            'last_name'  => ['required', 'string', 'min:3', 'max:40'],
            'email'      => ['required', 'email', 'max:255', 'unique:users'],
            'phone'      => ['required',
                             'phone:UA',
                             'max:20',
                             function ($attribute, $value, $fail) {
                                 if (User::where('phone', (string)PhoneNumber::make($value))->exists()) {
                                     $fail('The ' . $attribute . ' has already been taken.');
                                 }
                             }],
            'password'   => ['required', Password::defaults()],
        ]);
    }
}
