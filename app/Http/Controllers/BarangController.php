<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use App\Models\Barang;
use App\Models\Lokasi;
use App\Models\Kategori;
use App\Models\Pelaporan;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        return view('barang.index', [
            'barangs' => Barang::orderBy('id', 'DESC')->get()
        ]);
    }

    public function create()
    {
        return view('barang.create', [
            'kategories' => Kategori::all(),
            'merks' => Merk::all(),
            'lokasies' => Lokasi::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|mimes:jpeg,jpg,png',
            'nm_barang' => 'required',
            'deskripsi' => 'required',
            'kategori_id' => 'required',
            'merk_id' => 'required',
            'lokasi_id' => 'required'
        ], [
            'gambar.required' => 'Wajib menambahkan gambar!',
            'gambar.mimes' => 'Format gambar yang diizinkan: jpeg, jpg, png.',
            'nm_barang.required' => 'Form wajib diisi!',
            'deskripsi.required' => 'Form wajib diisi!',
            'kategori_id.required' => 'Form wajib dipilih!',
            'merk_id.required' => 'Form wajib dipilih!',
            'lokasi_id.required' => 'Form wajib dipilih!',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $path = 'gambar/';
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;
            $gambar = $file->storeAs($path, $fileName, 'public');
        }


$kd_barang = 'BRG-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
$qrCodePath = 'qrcode/' . $kd_barang . '.png';

if (!Storage::disk('public')->exists($qrCodePath)) {
    $qrCode = new QrCode($kd_barang);
    $writer = new PngWriter();

    $qrImage = $writer->write($qrCode);

    // Simpan hasil QR ke storage
    Storage::disk('public')->put($qrCodePath, $qrImage->getString());
}

        Barang::create([
            'kd_barang' => $kd_barang,
            'nm_barang' => $request->nm_barang,
            'deskripsi' => $request->deskripsi,
            'tgl_penambahan' => $request->tgl_penambahan,
            'gambar' => $gambar,
            'kategori_id' => $request->kategori_id,
            'merk_id' => $request->merk_id,
            'lokasi_id' => $request->lokasi_id,
        ]);

        return redirect('/barang')->with('success', 'Berhasil menambahkan data barang baru');
    }

    public function show(string $id)
    {
        $barang = Barang::findOrFail($id);
        $pelaporans = Pelaporan::where('barang_id', $barang->id)
            ->with('feedback')
            ->orderByDesc('updated_at')
            ->get();
        $qrCode = new QrCode($barang->kd_barang);

        return view('barang.show', [
            'barang' => $barang,
            'pelaporans' => $pelaporans,
            'qrCode' => $qrCode
        ]);
    }

    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);

        return view('barang.edit', [
            'barang' => $barang,
            'kategories' => Kategori::all(),
            'merks' => Merk::all(),
            'lokasies' => Lokasi::all()
        ]);
    }

    public function update(Request $request, string $id)
    {
        $barang = Barang::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'gambar' => 'nullable|mimes:jpeg,jpg,png',
            'nm_barang' => 'required',
            'deskripsi' => 'required',
            'kategori_id' => 'required',
            'merk_id' => 'required',
            'lokasi_id' => 'required'
        ], [
            'gambar.mimes' => 'Format gambar yang diizinkan: jpeg, jpg, png.',
            'nm_barang.required' => 'Form wajib diisi!',
            'deskripsi.required' => 'Form wajib diisi!',
            'kategori_id.required' => 'Form wajib dipilih!',
            'merk_id.required' => 'Form wajib dipilih!',
            'lokasi_id.required' => 'Form wajib dipilih!',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $gambar = $barang->gambar;
        if ($request->hasFile('gambar')) {
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }

            $path = 'gambar/';
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;
            $gambar = $file->storeAs($path, $fileName, 'public');
        }

        $barang->update([
            'nm_barang' => $request->nm_barang,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
            'kategori_id' => $request->kategori_id,
            'merk_id' => $request->merk_id,
            'lokasi_id' => $request->lokasi_id,
        ]);

        return redirect('/barang')->with('success', 'Berhasil memperbarui data barang');
    }

    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $qrPath = 'qrcode/' . $barang->kd_barang . '.png';
        if (Storage::disk('public')->exists($qrPath)) {
            Storage::disk('public')->delete($qrPath);
        }

        $barang->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data barang');
    }
}
