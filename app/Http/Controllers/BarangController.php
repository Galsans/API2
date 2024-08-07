<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Category;
use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * FUNGSI UTNUK MELIHAT DATA BARANG BESERTA DENGAN RELASI DARI BARANG YANG TERHUBUNG
     * RELASI YANG TERLIHAT ADALAH CATEGORY DAN USER SESUAI DENGAN DATA BARANG NYA
     * barang sudah otomatis tampil sesuai dengan prioritas nya dengan sort by status
     */
    public function index()
    {
        $barang = Barang::with(['category', 'user'])->get();

        if ($barang->isEmpty()) {
            return response()->json([
                'msg' => 'data belum ada'
            ], 404);
        }

        // Urutkan barang berdasarkan status_penggunaan
        $barang = $barang->sortBy(function ($item) {
            switch ($item->status) {
                case 'in use':
                    return 1;
                case 'out':
                    return 2;
                case 'in service':
                    return 3;
                case 'rusak':
                    return 4;
                default:
                    return 5; // Jaga-jaga jika ada status lain yang tidak terduga
            }
        });

        return response()->json([
            'data' => $barang->values()->all()
        ], 200);
    }

    /**
     * FUNGSI UNTUK MENAMBAHKAN DATA BARANG
     * asset_kode akan terisi secara otomatis jika user_id, category_id dan date_barang_masuk sudah diinputkan
     * qrcode menggunakan library dari BaconQrCode base on url dari frontend
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "category_id" => 'required|exists:categories,id',
            "user_id" => 'required|exists:users,id',
            "brand" => 'required',
            "type_monitor" => 'required',
            "status" => 'required',
            "unit_device" => 'required',
            "date_barang_masuk" => 'required|date',
            "spek_origin" => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'msg' => $validate->errors()
            ], 422);
        }

        // Ambil data divisi dan category
        $user = User::find($request->user_id);
        $category = Category::find($request->category_id);

        // Periksa apakah divisi dan kategori ditemukan
        if (!$user) {
            return response()->json(['msg' => 'User tidak ditemukan'], 404);
        }

        if (!$category) {
            return response()->json(['msg' => 'Category tidak ditemukan'], 404);
        }

        // Buat kode asset_kode
        $divisionCode = $user->department->divisi->kode;
        $categoryCode = $category->kode;

        // Hitung nomor urut barang
        $itemCount = Barang::count() + 1;
        $sequenceNumber = str_pad($itemCount, 3, '0', STR_PAD_LEFT);

        // Ambil bulan dan tahun dari date_barang_masuk
        $date = new \DateTime($request->date_barang_masuk);
        $dateCode = $date->format('m') . $date->format('y');

        // Gabungkan untuk membuat asset_kode
        $asset_kode = $divisionCode . $categoryCode . $sequenceNumber . $dateCode;

        // Buat record baru di tabel barang
        $input = $request->all();
        $barang = new Barang();
        $barang->asset_kode = $asset_kode;
        $barang->category_id = $input['category_id'];
        $barang->user_id = $input['user_id'];
        $barang->type_monitor = $input['type_monitor'];
        $barang->unit_device = $input['unit_device'];
        $barang->status = $input['status'];
        $barang->date_barang_masuk = $input['date_barang_masuk'];
        $barang->note = $input['note'];
        $barang->brand = $input['brand'];
        $barang->spek_origin = $input['spek_origin'];
        $barang->spek_akhir = $input['spek_akhir'];
        $barang->save(); // Simpan barang terlebih dahulu untuk mendapatkan ID

        // Buat data QR Code setelah barang disimpan dan mendapatkan ID
        // $qrCodeData = url('/api/barang/' . $barang->id); // Gunakan URL lengkap
        $qrCodeData = 'http://localhost:5173/barang/' . $barang->id;
        $qrCodePath = 'qrcodes/' . "barcode" . $barang->id . '.svg';

        // Menyimpan svg qrcode dengan Storage di folder public
        if (!Storage::exists('public/qrcodes')) {
            Storage::makeDirectory('public/qrcodes');
        }

        try {
            // Menghasilkan QR code dalam format SVG dan menyimpannya
            $renderer = new ImageRenderer(
                new RendererStyle(300),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);
            $qrCode = $writer->writeString($qrCodeData);

            // Simpan file QR code
            $qrCodeFullPath = storage_path('app/public/' . $qrCodePath);
            file_put_contents($qrCodeFullPath, $qrCode);

            // Pastikan file berhasil disimpan
            if (!file_exists($qrCodeFullPath)) {
                return response()->json(['error' => 'Failed to save QR code image.']);
            }

            // Simpan path QR Code ke database
            $barang->qrcode = Storage::url($qrCodePath);
            $barang->save(); // Update record dengan qrcode

            return response()->json([
                'msg' => 'Data berhasil disimpan',
                'data' => $barang
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate QR code: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barang = Barang::with(['category', 'user.department.divisi'])->find($id);
        if ($barang == null) {
            return response()->json([
                'msg' => 'data tidak ditemukan'
            ], 404);
        }
        return response()->json([
            'msg' => 'detail barang',
            'data' => $barang
        ], 200);
    }

    /**
     * update untuk barang
     * jika status yang dipilih adalah rusak maka user_id otomatis akan bernilai null
     * jika category_id, user_id dan date_barang_masuk di ubah maka asset_kode akan berubah juga
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            "category_id" => 'exists:categories,id',
            // "user_id" => $request->status !== 'rusak' ? 'required|exists:users,id' : 'nullable|exists:users,id',
            "user_id" => 'nullable|exists:users,id',
            "date_barang_masuk" => 'date',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'msg' => $validate->errors()
            ], 422);
        }

        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['msg' => 'Barang tidak ditemukan'], 404);
        }

        // Ambil data divisi dan kategori jika ada perubahan
        $user = $request->has('user_id') ? User::find($request->user_id) : User::find($barang->user_id);
        $category = $request->has('category_id') ? Category::find($request->category_id) : Category::find($barang->category_id);

        // Periksa apakah user dan kategori ditemukan
        if (!$user && $request->has('user_id')) {
            return response()->json(['msg' => 'User tidak ditemukan'], 404);
        }

        if (!$category && $request->has('category_id')) {
            return response()->json(['msg' => 'Kategori tidak ditemukan'], 404);
        }

        // Buat kode asset_kode baru jika ada perubahan di user_id atau category_id
        $updateAssetId = false;
        if ($request->has('user_id') || $request->has('category_id')) {
            // Buat kode asset_kode baru
            $divisionCode = $user ? $user->department->divisi->kode : $barang->user->department->divisi->kode;
            $categoryCode = $category->kode;

            // Hitung nomor urut barang
            $itemCount = Barang::count() + 1;
            $sequenceNumber = str_pad($itemCount, 3, '0', STR_PAD_LEFT);

            // Ambil bulan dan tahun dari date_barang_masuk
            $date = $request->has('date_barang_masuk') ? new \DateTime($request->date_barang_masuk) : new \DateTime($barang->date_barang_masuk);
            $dateCode = $date->format('m') . $date->format('y');

            // Gabungkan untuk membuat asset_kode
            $asset_kode = $divisionCode . $categoryCode . $sequenceNumber . $dateCode;

            // Set asset_kode baru
            $barang->asset_kode = $asset_kode;
            $updateAssetId = true;
        }

        // Jika status menjadi rusak, set user_id menjadi null
        if ($request->has('status') && $request->status === 'rusak') {
            $request->merge(['user_id' => null]);
        }

        // Update record dengan input baru
        $input = $request->all();
        if ($updateAssetId) {
            $input['asset_kode'] = $barang->asset_kode;
        }

        $barang->update($input);

        return response()->json([
            'msg' => 'Data berhasil diubah',
            'data' => $barang
        ], 201);
    }

    /**
     * FUNGSI DELETE TIDAK PERMANENT
     */
    public function destroy(string $id)
    {
        // Cari barang berdasarkan ID
        $barang = Barang::find($id);

        if ($barang === null) {
            return response()->json([
                'msg' => 'Data tidak ditemukan'
            ], 404);
        }

        // Cek apakah barang terhubung dengan tabel lain
        // Misalnya, kita cek tabel `request` yang mungkin memiliki kolom `department_id`
        // Sesuaikan dengan relasi yang ada di aplikasi Anda
        if ($barang->history()->exists()) {  // Ganti `divisi()` dengan relasi yang sesuai
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
    // Fungsi untuk mengembalikan data yang sudah di hapus
    public function restore($id)
    {
        $barang = Barang::withTrashed()->find($id);

        if ($barang) {
            $barang->restore();
            return response()->json([
                'msg' => 'Barang berhasil dikembalikan',
                'data' => $barang
            ], 200);
        } else {
            return response()->json([
                'msg' => 'Barang tidak ditemukan',
            ], 404);
        }
    }

    // Melihat data yang sudah dihapus
    public function trash()
    {
        $barang = Barang::onlyTrashed()->get();
        if ($barang->isEmpty()) {
            return response()->json([
                'msg' => 'data tidak ada'
            ], 404);
        }
        return response()->json([
            'msg' => 'data history delete',
            'data' => $barang
        ], 200);
    }
}
