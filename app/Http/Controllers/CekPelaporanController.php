<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Pelaporan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FeedbackReply;
use Illuminate\Support\Facades\Validator;

class CekPelaporanController extends Controller
{
    public function index()
    {
        return view('cek-pelaporan.index', [
            'pelaporans' => Pelaporan::orderBy('id', 'DESC')->get()
        ]);
    }

    public function detail($id)
    {
        $pelaporan = Pelaporan::with(['barang.kategori', 'barang.merk', 'barang.lokasi', 'feedback.reply'])
            ->findOrFail($id);
        $feedback = $pelaporan->feedback;
        $feedbackReply = $feedback ? $feedback->reply : null;

        return view('cek-pelaporan.detail', [
            'pelaporan'     => $pelaporan,
            'feedback'      => $feedback,
            'feedbackReply' => $feedbackReply
        ]);
    }

    public function store(Request $request, $id)
    {
        $feedback = Feedback::where('pelaporan_id', $id)->first();

        if (!$feedback) {
            return back()->withErrors(['feedback_replies' => 'Feedback admin belum tersedia'])->withInput();
        }
        $validator = Validator::make($request->all(), [
            'feedback_replies'  => 'required'
        ], [
            'feedback_replies.required' => 'Form Tidak Boleh Kosong '
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        FeedbackReply::updateOrCreate(
            ['feedback_id' => $feedback->id],
            ['feedback_replies' => $request->feedback_replies]
        );

        return redirect()->back()->with('success', 'Berhasil menambahkan feedback baru');
    }
}
