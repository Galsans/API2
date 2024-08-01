<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        if ($category->isEmpty()) {
            return response()->json([
                'msg' => 'data belum ada'
            ], 404);
        }
        return response()->json([
            'msg' => 'data category',
            'data' => $category
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'kode' => 'required|max:2|regex:/^[A-Z]+$/',
        ], [
            'name.required' => 'Nama harus diisi.',
            'kode.required' => 'Kode harus diisi.',
            'kode.max' => 'Kode tidak boleh lebih dari 2 huruf.',
            'kode.regex' => 'Kode harus berisi huruf kapital saja.',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'msg' => $validate->errors()
            ], 422);
        }
        $input = $request->all();
        $category = Category::create($input);

        return response()->json([
            'msg' => 'data berhasil disimpan',
            'data' => $category
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'kode' => 'required|max:2|regex:/^[A-Z]+$/',
        ], [
            'kode.required' => 'Kode harus diisi.',
            'kode.max' => 'Kode tidak boleh lebih dari 2 huruf.',
            'kode.regex' => 'Kode harus berisi huruf kapital saja.',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'msg' => $validate->errors()
            ], 422);
        }
        $category = Category::find($id);
        if ($category == null) {
            return response()->json([
                'msg' => 'data tidak ditemukan'
            ], 404);
        }
        $input = $request->all();
        $category->update($input);

        return response()->json([
            'msg' => 'data berhasil diubah',
            'data' => $category
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return response()->json([
                'msg' => 'data tidak ditemukan'
            ], 404);
        }
        $category->delete();
        return response()->json([
            'msg' => 'data berhasil dihapus',
            'data' => $category
        ], 200);
    }
}
