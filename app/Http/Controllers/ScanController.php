<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class ScanController extends Controller
{
    public function scan(Request $request)
    {
        // Pastikan ada data qr
        if (!$request->has('qr')) {
            return response()->json(['error' => 'QR data tidak ditemukan'], 400);
        }

        // QR yang dikirim adalah JSON → decode
        $qrData = json_decode($request->qr, true);

        if (!$qrData) {
            return response()->json(['error' => 'Format QR tidak valid'], 400);
        }

        // Ambil ID dari isi QR
        $id = $qrData['id'] ?? null;

        if (!$id) {
            return response()->json(['error' => 'ID tidak ditemukan dalam QR'], 400);
        }

        // Cari barang di tabel
        $barang = Barang::where('id', $id)->first();

        if (!$barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'QR valid',
            'barang' => $barang
        ]);
    }
}
