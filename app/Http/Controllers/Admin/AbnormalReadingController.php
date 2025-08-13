<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbnormalReading;
use Illuminate\Http\Request;

class AbnormalReadingController extends Controller
{
    /**
     * Menandai peringatan sebagai sudah dibaca.
     * Method ini bisa merespon permintaan biasa dan permintaan JavaScript (AJAX).
     */
    public function acknowledge(AbnormalReading $warning)
    {
        // Update kolom 'acknowledged_at' dengan waktu sekarang
        $warning->update(['acknowledged_at' => now()]);

        // Jika ini adalah request dari JavaScript (yang meminta JSON),
        // kirim response sukses dalam format JSON.
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Peringatan berhasil ditandai.'
            ]);
        }

        // Jika ini adalah request biasa (sebagai cadangan),
        // lakukan redirect kembali ke dashboard dengan notifikasi.
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Peringatan berhasil ditandai.');
    }
}
