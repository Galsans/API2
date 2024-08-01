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
        $department = Department::paginate(10);
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        $department = Department::find($id);

        if ($department == null) {
            return response()->json([
                'msg' => 'data tidak ditemukan',
            ], 404);
        }
        return response()->json([
            'msg' => 'data berhasil dihapus'
        ], 200);
    }
}
