<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\APIController;
use App\Services\JWT;
use App\Transformers\UserTransformer;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends APIController
{
    use ThrottlesLogins;

    /**
     * Issue a JWT token when valid login credentials are presented.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Determine if the user has too many failed login attempts.
        if ($this->hasTooManyLoginAttempts($request)) {
            // Fire an event when a lockout occurs.
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Grab credentials from the request.
        $credentials = $request->only('email', 'password');

        // Attempt to verify the credentials and create a token for the user.
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                // Increments login attempts.
                $this->incrementLoginAttempts($request);

                $message = Lang::get('auth.failed');

                return $this->responseWithUnauthorized($message);
            }
        } catch (JWTException $e) {
            return $this->responseWithInternalServerError("Couldn't create token.");
        }

        // All good so return the json with token and user.
        return $this->sendLoginResponse($request, $token);
    }

    /**
     * Returns the token and current user authenticated.
     *
     * @param Request $request
     * @param $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request, $token)
    {
        $this->clearLoginAttempts($request);

        $user = $this->transform->item($request->user(), new UserTransformer());

        $token_ttl = (new JWT($token))->getTokenTTL();

        return $this->response(compact('token', 'token_ttl', 'user'));
    }

    /**
     * Notify the user after determining they are locked out.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        return $this->responseWithTooManyRequests($message);
    }

    /**
     * @return string
     */
    public function username()
    {
        return 'email';
    }
}
