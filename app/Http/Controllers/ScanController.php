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

        $rawPayload = $request->qr;
        $decoded = json_decode($rawPayload, true);

        $barang = null;

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $byId = $decoded['id'] ?? null;
            $byKode = $decoded['kd_barang'] ?? null;

            if ($byId) {
                $barang = Barang::find($byId);
            }

            if (!$barang && $byKode) {
                $barang = Barang::where('kd_barang', $byKode)->first();
            }
        }

        if (!$barang) {
            $barang = Barang::where('kd_barang', $rawPayload)->first();
        }

        if (!$barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'QR valid',
            'barang' => $barang
        ]);
    }
}
