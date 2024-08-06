<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'msg' => $validate->errors()
            ], 422);
        }
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);

        return response()->json([
            'msg' => 'data berhasil disimpan',
            'data' => $user,
            'token' => $user->createToken('apiToken')->plainTextToken
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Return user details and token
            return response()->json([
                'token' => $user->createToken('apiToken')->plainTextToken,
                'user' => $user // Include user details with role
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'msg' => 'anda berhasil logout'
        ], 200);
    }

    public function readUser()
    {
        $user = User::with('department.divisi')->get();
        return response()->json([
            'data' => $user
        ], 200);
    }

    public function user()
    {
        $user = Auth::user();
        return response()->json([
            'msg' => 'sudah login',
            'data' => $user
        ], 200);
    }
}
