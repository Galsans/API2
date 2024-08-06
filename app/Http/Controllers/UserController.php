<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function readUser()
    {
        $user = User::with('department.divisi')->get();
        return response()->json([
            'data' => $user
        ], 200);
    }

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
