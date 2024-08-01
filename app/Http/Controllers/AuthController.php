<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'msg' => $validate->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'msg' => 'credential salah'
            ], 203);
        }

        return response()->json([
            'msg' => 'anda berhasil login',
            'akun' => $user,
            'token' => $user->createToken('apiToken')->plainTextToken
        ], 200);
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
}
