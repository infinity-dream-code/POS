<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;

class ApiBarangController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'kode_barang' => 'required|unique:barangs',
                'nama_barang' => 'required',
                'harga' => 'required|integer'
            ]);

            $barang = Barang::create($data);

            return response()->json([
                'status' => 200,
                'message' => 'Barang berhasil ditambahkan',
                'data' => $barang
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan saat menambah barang'
            ], 500);
        }
    }

    public function search($query)
    {
        try {
            if (is_numeric($query)) {
                $barang = Barang::where('id', $query)->first();
                if ($barang) {
                    return response()->json([
                        'status' => 200,
                        'data' => $barang
                    ], 200);
                }
            }

            $barang = Barang::where('kode_barang', $query)
                ->orWhere('nama_barang', 'like', "%{$query}%")
                ->get();

            if ($barang->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Barang tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'data' => $barang
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal mencari data barang'
            ], 500);
        }
    }
}
