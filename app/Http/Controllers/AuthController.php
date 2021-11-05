<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\SendEmail;
use App\Models\LoginLog;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Validator;

class AuthController extends Controller
{
    public static $maxInvalidLogin = 5;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Login a User.
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first()], 422);
        }

        if($this->checkAttempts()) {
            return $this->checkAttempts();
        };
        if (!$token = auth()->attempt($validator->validated())) {
            LoginLog::create(['email'=>$request->email]);
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        return $this->createNewToken($token);
    }

    public static function checkAttempts() {
        $request = Request();
        $log = LoginLog::where('email', $request->email)->where('created_at', '>', Carbon::now()->subMinutes(self::$maxInvalidLogin)->toDateTimeString())->orderBy('id', 'DESC')->get();
        if (count($log) > 5 && LoginLog::where('email', $request->email)->where('created_at', '>', Carbon::now()->subMinutes(self::$maxInvalidLogin)->toDateTimeString())->orderBy('id', 'DESC')->exists()) {
            $request_datetime = LoginLog::where('email', $request->email)->where('created_at', '>', Carbon::now()->subMinutes(self::$maxInvalidLogin)->toDateTimeString())->orderBy('id', 'DESC')->get()->first()['created_at'];
            $request_datetime = strtotime($request_datetime);
            $timeout = ($request_datetime + (60 * self::$maxInvalidLogin) - strtotime(date('Y-m-d H:i:s'))) / 60;
            return response()->json(['message' => 'Login Banned for ' . (int)gmdate('i', $timeout * 60) . ' minutes and ' . (int)gmdate('s', $timeout * 60) . ' seconds.'], 403);
        }
    }

    /**
     * Register a User.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5',
        ],
        [ 'email.unique' => 'Email already taken']);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        dispatch(new SendEmailJob($request->email));
        return response()->json([
            'message' => 'User successfully registered'
        ], 201);
    }

    /**
     * Get the token array structure.
     *
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token
        ], 201);
    }

}
