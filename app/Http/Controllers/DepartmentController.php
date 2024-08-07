<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $department = Department::with('divisi')->paginate(10);
        if ($department->isEmpty()) {
            return response()->json([
                'msg' => 'data belum ada'
            ], 404);
        }

        return response()->json([
            'data' => $department
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "name" => 'required',
            "divisi_id" => 'required|exists:divisis,id',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'msg' => $validate->errors()
            ], 422);
        }
        $department = Department::create($request->all());
        return response()->json([
            'msg' => 'berhasil menyimpan data',
            'data' => $department
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::find($id);
        if ($department == null) {
            return response()->json([
                'msg' => 'data tidak ditemukan'
            ], 404);
        }
        return response()->json([
            'data' => $department
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            "divisi_id" => 'exists:divisis,id',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'msg' => $validate->errors()
            ], 422);
        }
        $department = Department::find($id);
        $department->update($request->all());
        return response()->json([
            'msg' => 'berhasil mengubah data',
            'data' => $department
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari barang berdasarkan ID
        $barang = Department::find($id);

        if ($barang === null) {
            return response()->json([
                'msg' => 'Data tidak ditemukan'
            ], 404);
        }

        // Cek apakah barang terhubung dengan tabel lain
        // Misalnya, kita cek tabel `request` yang mungkin memiliki kolom `department_id`
        // Sesuaikan dengan relasi yang ada di aplikasi Anda

        if ($barang->user()->exists()) {  // Ganti `user()` dengan relasi yang sesuai
            return response()->json([
                'msg' => 'Data tidak dapat dihapus karena ada relasi dengan tabel lain'
            ], 400);  // 400 Bad Request lebih tepat untuk kondisi ini
        }

        // Hapus barang
        $barang->delete();

        return response()->json([
            'msg' => 'Data berhasil dihapus'
        ], 200);
    }

    public function trash()
    {
        $department = Department::onlyTrashed()->get();
        if ($department->isEmpty()) {
            return response()->json([
                'msg' => 'data tidak ada'
            ], 404);
        }
        return response()->json([
            'msg' => 'data history delete',
            'data' => $department
        ], 200);
    }

    public function restore($id)
    {
        $department = Department::withTrashed()->find($id);

        if ($department) {
            $department->restore();
            return response()->json([
                'msg' => 'Department berhasil dikembalikan',
                'data' => $department
            ], 200);
        } else {
            return response()->json([
                'msg' => 'Department tidak ditemukan',
            ], 404);
        }
    }
}
