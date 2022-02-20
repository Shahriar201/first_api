<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if ($token = $this->guard()->attempt($credentials)) {
    //         return $this->respondWithToken($token);
    //     }

    //     return response()->json(['error' => 'Email Or Password does not match'], 401);
    // }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return $this->set_response(null, 422, 'failed', $validator->errors()->all());
        }

        if (!(User::where('email', $request->email)->pluck('status')->first()==1)) {
            return $this->set_response(null, 422, 'failed', ['User is inactive!']);
        }

        if (!Auth::attempt($request->except(['remember_me']))) {
            return $this->set_response(null, 422, 'failed', ['Credentials mismatch']);
        }

        $personalAccessToken = $this->getPersonalAccessToken();


        $user = Auth::user();
        $user_roles_permissions = $this->user_roles_permissions_q();
        $roles = $user_roles_permissions->where('user_id', $user->id)->pluck('role_name')->unique()->toArray();
        $permissions = $user_roles_permissions->where('user_id', $user->id)->pluck('permission_name')->unique()->toArray();

        $tokenData = [
            'user' => [
                'access_token' => $personalAccessToken->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($personalAccessToken->token->expires_at)->toDateTimeString(),
                'name' => $user->name,
                'email' => $user->email,
                'userId' => $user->id,
            ],
            'roles' => $roles,
            'permissions' => $permissions,
        ];

        // Laravel passport prevent user to login together with the same credential
        // OauthAccessToken::where('user_id', $user->id)->orderBy('created_at', 'desc')->skip(1)->limit(100)->get()->map(function ($q) {
        //     return $q->update([
        //         'revoked' => 1
        //     ]);
        // });

        return $this->set_response($tokenData, 200, 'success', ['Logged in!']);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }

    public function payload()
    {
        return auth()->payload();
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->save();

        return $this->login($request);
    }
}