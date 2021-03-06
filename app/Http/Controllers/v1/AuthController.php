<?php

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function index(Request $request)
    {
        $per_page = isset($request->per_page) ? $request->per_page : 50;

        $users = User::paginate($per_page);

        $users->appends(['per_page' => $per_page]);

        return response()->json(['users' => $users], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal access client');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'token' => [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
            ],
            'user' => $user,
            'message' => __('auth.success')
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'document_type' => 'required|string|in:cc,ce,tc,pp',
            'document_number' => 'required|string|unique:users',
            'is_administrator' => 'boolean',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
                'is_administrator' => $request->is_administrator
            ]);

            return response()->json([
                'message' => __('auth.register')
            ], 201);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 409);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => __('auth.logout')
        ]);
    }

    public function getAuthUser(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string'
        ]);

        try {
            $request->user()->password = bcrypt($request->new_password);
            $request->user()->save();

            return response()->json(['message' => __('auth.new_password')], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 409);
        }

    }
}
