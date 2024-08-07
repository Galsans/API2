<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function user()
    {
        $user = Auth::user();
        $user->load('department');
        return response()->json([
            'msg' => 'Akun anda',
            'data' => $user
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => $validator->errors()
            ], 422);
        }

        // Update user data
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'msg' => 'Profile updated successfully',
            'data' => $user
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'msg' => $validator->errors()
            ], 422);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'msg' => 'current password salah'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json([
            'msg' => 'berhasil mengubah password'
        ], 200);
    }

    // MENAMPILKAN BARANG SESUAI DENGAN AUTHENTIKASI NYA ATAUPUN USER-IDNYA
    public function readBarang()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'msg' => 'unauthorization'
            ], 401);
        }
        $item = Barang::where('user_id', $user->id)->with('category')->get();

        if ($item->isEmpty()) {
            return response()->json([
                'msg' => 'data belum ada'
            ], 404);
        }
        return response()->json([
            'data' => $item,
        ], 200);
    }
}
