<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistoryController extends Controller
{
    // MELIHAT DATA HISTORY SESUAI DENGAN BARANG ID NYA
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

    // MENAMBAHKAN DATA HISTORY SESUAI DENGAN BARANG ID YANG SUDAH DIPILIH
    public function store(Request $request, $barangId)
    {
        // Validasi input
        $validate = Validator::make($request->all(), [
            "user_id" => $request->status !== 'rusak' ? 'required|exists:users,id' : 'nullable|exists:users,id',
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

        // Jika status adalah rusak, set user_id menjadi null
        if ($request->status === 'rusak') {
            $input['user_id'] = null;
        }

        // Simpan data history
        $history = History::create($input);

        return response()->json([
            'msg' => 'Data berhasil disimpan',
            'data' => $history
        ], 201); // Status 201 untuk Created
    }

    // FUNGSI UNTUK MENGHAPUS DATA HISTORY TETAPI TIDAK PERMANENT
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

    // FUNGSI UNTUK MENGHAPUS DATA HISTORY SECARA PERMANENT
    public function deletePermanently($id)
    {
        $history = History::find($id);
        if ($history == null) {
            return response()->json([
                'msg' => 'data tidak ditemukan'
            ], 404);
        }
        // Hapus permanen data yang ditemukan
        $history->forceDelete();

        return response()->json([
            'msg' => 'Data berhasil dihapus secara permanen'
        ], 200);
    }

    // FUNGSI MELIHAT DATA HISTORY YANG SUDAH DIDELETE SECARA TIDAK PERMANENT
    public function historyDeleted($barangId)
    {
        // Ambil data history yang dihapus dengan barang_id tertentu
        $history = History::onlyTrashed()->where('barang_id', $barangId)->get();

        if ($history->isEmpty()) {
            return response()->json([
                'msg' => 'Data tidak ditemukan untuk barang_id tersebut'
            ], 404);
        }

        return response()->json([
            'msg' => 'Data history yang dihapus',
            'data' => $history
        ], 200);
    }
}
