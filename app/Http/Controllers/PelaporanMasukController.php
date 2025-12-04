<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Pelaporan;
use Illuminate\Http\Request;
use App\Models\FeedbackReply;
use App\Http\Controllers\Controller;

class PelaporanMasukController extends Controller
{
    public function index()
    {
        return view('pelaporan-masuk.index', [
            'pelaporans'    => Pelaporan::whereNot('status', 'selesai')->orderBy('id', 'DESC')->get(),
        ]);
    }

    public function detail($id)
    {
        $pelaporan = Pelaporan::with(['barang.kategori', 'barang.merk', 'barang.lokasi', 'feedback.reply'])
            ->findOrFail($id);
        $feedback = $pelaporan->feedback;
        $feedbackReply = $feedback ? $feedback->reply : null;
        return view('pelaporan-masuk.detail', [
            'pelaporan'     => $pelaporan,
            'feedback'      => $feedback,
            'feedbackReply' => $feedbackReply
        ]);
    }

    public function perbaiki($id)
    {
        $pelaporan = Pelaporan::findOrFail($id);
        $pelaporan->update(['status' => 'sedang diperbaiki']);

        return redirect()->back()->with('success', 'Berhasil mengubah status pelaporan menjadi Sedang Diperbaiki');
    }

    public function selesai(Request $request, $id)
    {
        $pelaporan = Pelaporan::findOrFail($id);

        $validator = $request->validate([
            'analisis_perbaikan' => 'required|string'
        ], [
            'analisis_perbaikan.required' => 'Analisis perbaikan wajib diisi'
        ]);

        $pelaporan->update(['status' => 'selesai']);

        Feedback::updateOrCreate(
            ['pelaporan_id' => $pelaporan->id],
            ['analisis_perbaikan' => $validator['analisis_perbaikan']]
        );

        return redirect()->back()->with('success', 'Berhasil mengubah status pelaporan menjadi Selesai');
    }
}
