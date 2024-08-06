<?php

namespace App\Http\Controllers;

use App\Models\MakeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MakeRequestController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the currently authenticated user
            $user = Auth::user();

            // Fetch make requests uploaded by the authenticated user
            $makeRequest = MakeRequest::with('user', 'barang')->where('user_id', $user->id)->get();
            if ($makeRequest->isEmpty()) {
                return response()->json([
                    'msg' => 'data belum ada'
                ], 404);
            }
            return response()->json([
                'data' => $makeRequest
            ], 200);
        } else {
            // Return a 401 Unauthorized response if the user is not logged in
            return response()->json([
                'msg' => 'Unauthorized'
            ], 401);
        }
    }

    public function store(Request $request, $barangId = null)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'jenis_permintaan' => 'required|in:barang_baru,perbaikan/upgrade',
            'description' => 'required|string',
            'keperluan' => 'required|string',
            'bukti' => $request->jenis_permintaan === 'perbaikan/upgrade' ? 'required|file' : 'nullable|file',
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Determine the value of barang_id
        $barang_id = $request->jenis_permintaan === 'perbaikan/upgrade' ? $barangId : null;

        // Handle bukti file upload conditionally
        $buktiURL = null;
        if ($request->jenis_permintaan === 'perbaikan/upgrade' && $request->hasFile('bukti')) {
            $bukti = $request->file('bukti')->store('bukti', 'public');
            $buktiURL = Storage::url($bukti);
        }

        // Create the MakeRequest record
        $makeRequest = MakeRequest::create([
            'user_id' => Auth::id(),
            'jenis_permintaan' => $request->jenis_permintaan,
            'barang_id' => $barang_id,
            'description' => $request->description,
            'keperluan' => $request->keperluan,
            'bukti' => $buktiURL,
        ]);

        return response()->json([
            'msg' => 'MakeRequest created successfully',
            'data' => $makeRequest
        ], 201);
    }

    public function updateAdmin(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            "status" => 'required|in:in prosess, done, reject',
            "kode_pengambilan" => 'required',
            "tanggal_pengambilan" => 'required',
            "tanggal_penerimaan" => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'msg' => $validate->errors()
            ], 422);
        }

        $makeRequest = MakeRequest::find($id);
        $input = $request->all();

        $makeRequest->update($input);
        return response()->json([
            'msg' => 'data berhasil diupdate',
            'data' => $makeRequest
        ], 201);
    }

    public function delete($id)
    {
        $makeRequest = MakeRequest::find($id);
        if ($makeRequest == null) {
            return response()->json([
                'msg' => 'data tidak ditemukan'
            ], 404);
        }
        $makeRequest->delete();
        return response()->json([
            'msg' => 'data berhasil dihapus',
            'data' => $makeRequest
        ], 200);
    }
}
