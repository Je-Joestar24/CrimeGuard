<?php

namespace App\Http\Controllers\CrimeGuardM;

use App\Http\Controllers\Controller;
use App\Mail\SendResetCode;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class userAuths extends Controller
{
    //
    public function createResetToken(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->input('email'))->where('archived_at', '=', NULL)->first();

        if (!$user) {
            return response()->json(['response' => false]);
        }

        $token = random_int(100000, 999999);

        $hashedToken = Hash::make($token);

        $expiresAt = Carbon::now()->addMinutes(15);

        PasswordReset::updateOrCreate(
            ['user_id' => $user->id],
            [
                'token' => $hashedToken,
                'expires_at' => $expiresAt,
            ]
        );

        // Send the token via email
        try {
            Mail::to($user->email)->send(new SendResetCode($token));
        } catch (\Exception $e) {
            return response()->json(['response' => false]);
        }

        return response()->json(['response' => true]);
    }


    public function validateResetToken(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        $userId  = $user->id;
        $plainToken = $request->input("code");

        $passwordReset = PasswordReset::where('user_id', $userId)
            ->where('expires_at', '>', Carbon::now())
            ->orderBy('expires_at', 'desc')
            ->first();

        if (!$passwordReset) {
            return response()->json(["reset" => false]); 
        }

        if (Hash::check($plainToken, $passwordReset->token)) {


            return response()->json(["reset" => true]);
        }

        return response()->json(["reset" => false]); 
    }

    public function resetMyPass(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'code' => 'required|string',
        ]);


        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['response' => false, 'message' => 'User not found'], 404);
        }


        $isValidToken = $this->validateT($user->id, $request->input('code'));

        if (!$isValidToken) {
            return response()->json(['response' => false, 'message' => 'Invalid or expired token'], 400);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        PasswordReset::where('user_id', $user->id)->delete();

        return response()->json(['response' => true, 'message' => 'Password reset successfully']);
    }


    public function validateT($userId, $plainToken)
    {

        $passwordReset = PasswordReset::where('user_id', $userId)
            ->where('expires_at', '>', Carbon::now())
            ->orderBy('expires_at', 'desc')
            ->first();

        if (!$passwordReset) {
            return false;
        }

        if (Hash::check($plainToken, $passwordReset->token)) {
            return true;
        }

        return false;
    }
    /* 
    public function temporaryLogin(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $request->validate([
            'user' => 'required|string',  
            'password' => 'required|string',
        ]);

        $user = User::where('user_name', $request->input('user'))
            ->orWhere('email', $request->input('user'))
            ->first();

        if (!$user) {
            return response()->json(['response' => false, 'error' => 'User not found'], 404);
        }

        if ($user->user_level == 3) {
            if (is_null($user->accepted_at) || is_null($user->accepted_by)) {
                return response()->json([
                    'response' => false,
                    'error' => 'User not yet accepted',
                ], 403);
            }
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json(['response' => false, 'error' => 'Incorrect password'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'response' => 'Success',
            'message' => 'Login successful',
            'data' => [
                'id' => $user->id,
                'user_level' => $user->user_level,
            ],
            'token' => $token,
        ], 200);
    } */


    public function temporaryLogin(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $request->validate([
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        $key = 'login-attempts:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'response' => 'Too many login attempts',
                'error' => 'Too many login attempts, please try again in ' . ceil($seconds / 60) . ' minutes.',
                'min' => "".ceil($seconds / 60).""
            ]/* , 429) */);
        }

        $user = User::where('user_name', $request->input('user'))
            ->orWhere('email', $request->input('user'))
            ->first();

        if (!$user) {
            RateLimiter::hit($key, 300);
            return response()->json(['response' => false, 'error' => 'User not found'], 404);
        }

        if ($user->user_level == 3 && (is_null($user->accepted_at) || is_null($user->accepted_by))) {
            return response()->json([
                'response' => false,
                'error' => 'User not yet accepted',
            ], 403);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            RateLimiter::hit($key, 300);
            return response()->json(['response' => false, 'error' => 'Incorrect password'], 401);
        }

        RateLimiter::clear($key);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'response' => 'Success',
            'message' => 'Login successful',
            'data' => [
                'id' => $user->id,
                'user_level' => $user->user_level,
            ],
            'token' => $token,
        ], 200);
    }
}
