<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateController extends Controller
{
    /**
     * AuthenticateController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return $this->failure($validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        try{
            if (!$token = auth()->attempt($validator->validated())) {
                return $this->failure(['Email or password is incorrect'], Response::HTTP_UNAUTHORIZED);
            }
        }catch(\Illuminate\Validation\ValidationException $exception){
            return $this->failure([$exception->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data)
    {
        return Validator::make($data, [
            'email'      => ['required', 'email', 'max:255', 'exists:users'],
            'password'   => ['required', 'string', 'max:255'],
        ]);
    }
}
