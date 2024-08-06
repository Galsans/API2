<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistoryController extends Controller
{
    public function index(Request $request, $barangId)
    {
        // Ambil data history yang sesuai dengan barang_id dari URL
        $history = History::with('barang', 'user') // Memuat relasi barang
            ->where('barang_id', $barangId) // Filter berdasarkan barang_id
            ->get();

        // Periksa apakah data history ditemukan
        if ($history->isEmpty()) {
            return response()->json([
                'msg' => 'Tidak ada riwayat yang ditemukan pada barang ini'
            ], 404);
        }

        return response()->json([
            'msg' => 'data history',
            'data' => $history
        ], 200);
    }

    public function store(Request $request, $barangId)
    {
        // Validasi input
        $validate = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            "spek_upgraded" => "required",
            "status" => "required|in:in use,out,upgrade,in service,rusak",
            "lokasi" => "required",
        ]);

        if ($validate->fails()) {
            return response()->json([
                'msg' => $validate->errors()
            ], 422);
        }

        // Validasi bahwa barang_id ada dalam tabel barang
        $barang = Barang::find($barangId);
        if (!$barang) {
            return response()->json([
                'msg' => 'Invalid barang_id',
                'data' => null
            ], 404);
        }

        // Persiapkan input data
        $input = $request->all();
        $input['barang_id'] = $barangId; // Ambil barang_id langsung dari URL

        // Simpan data history
        $history = History::create($input);

        return response()->json([
            'msg' => 'Data berhasil disimpan',
            'data' => $history
        ], 201); // Status 201 untuk Created
    }

    public function destroy(string $id)
    {
        $history = History::find($id);
        if ($history == null) {
            return response()->json([
                'msg' => 'data tidak ditemukan'
            ], 404);
        }
        $history->delete();
        return response()->json([
            'msg' => 'data berhasil dihapus',
            'data' => $history
        ], 200);
    }
}
