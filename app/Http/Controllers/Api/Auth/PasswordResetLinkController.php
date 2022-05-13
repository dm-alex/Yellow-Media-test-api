<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return $this->failure($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $response = Password::sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? $this->success([__($response)], Response::HTTP_OK)
            : $this->failure([__($response)], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'email', 'max:255', 'exists:users'],
        ]);
    }
}
