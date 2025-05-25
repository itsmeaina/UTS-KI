<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'course_id' => 'required|exists:course,course_id', // ✅ WAJIB
            // validasi lainnya
        ]);

        DosenCourse::create([
            'nip' => $request->nip,
            'course_id' => $request->course_id, // ✅ PENTING!
            'jurusan_id' => $request->jurusan_id,
            'thn_akademik' => $request->thn_akademik,
            'semester' => $request->semester,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'ruang' => $request->ruang,
        ]);
    }
}
