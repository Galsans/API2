<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // FUNGSI UNTUK MELIHAT SEMUA DATA USER UNTUK ADMIN
    public function readUser()
    {
        $user = User::with('department.divisi')->get();
        if ($user->isEmpty()) {
            return response()->json([
                'msg' => 'data tidak ada',
            ], 404);
        }
        return response()->json([
            'data' => $user
        ], 200);
    }

    // FUNGSI UNTUK MENYIMPAN DATA USER UNTUK ADMIN
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required|in:admin,user',
            'department_id' => 'required|exists:departments,id',
        ]);
        if ($validasi->fails()) {
            return response()->json([
                'msg' => $validasi->errors()
            ], 422);
        }
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);

        return response()->json([
            'msg' => 'berhasil membuat akun',
            'data' => $user
        ], 201);
    }

    // FUNGSI UNTUK UPDATE DATA USER UNTUK ADMIN
    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required|in:admin,user',
            'department_id' => 'required|exists:departments,id',
        ]);
        if ($validasi->fails()) {
            return response()->json([
                'msg' => $validasi->errors()
            ], 422);
        }
        $user = User::find($id);
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user->update($input);

        return response()->json([
            'msg' => 'berhasil mengubah akun',
            'data' => $user
        ], 201);
    }
}
